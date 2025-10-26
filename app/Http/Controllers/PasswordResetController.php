<?php

namespace App\Http\Controllers;

use App\Http\Services\CommonService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    private $apiUrl = 'https://adm.rutadecrecimiento.com/api/email/password-reset';
    
    private function getApiKey(): string
    {
        return config('services.email.api_key');
    }

    public function showRequestForm()
    {
        $data = [
            'footer' => CommonService::footer(),
            'links' => CommonService::links(),
        ];

        return view('website.auth.password-reset-request', $data);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No encontramos ningún usuario con ese correo electrónico.'
            ], 404);
        }

        // Generar token
        $token = Str::random(64);
        
        // Guardar token en la base de datos (opcional, para verificación)
        // Por ahora usaremos solo la API

        // Construir la URL de reset
        $resetUrl = url('/password/reset?token=' . $token . '&email=' . urlencode($user->email));

        // Preparar datos para la API
        $data = [
            'email' => $user->email,
            'reset_url' => $resetUrl,
            'user_name' => $user->name,
            'project_name' => 'Ruta de Crecimiento'
        ];

        try {
            // Llamar a la API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-API-Key' => $this->getApiKey()
            ])->post($this->apiUrl, $data);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Correo de recuperación enviado exitosamente. Por favor revisa tu bandeja de entrada.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al enviar el correo. Por favor intenta nuevamente.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión. Por favor intenta nuevamente.'
            ], 500);
        }
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            return redirect()->route('login')->with('error', 'Enlace inválido');
        }

        $data = [
            'footer' => CommonService::footer(),
            'links' => CommonService::links(),
            'token' => $token,
            'email' => $email,
        ];

        return view('website.auth.password-reset', $data);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        // Actualizar la contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada exitosamente. Ahora puedes iniciar sesión.'
        ]);
    }
}
