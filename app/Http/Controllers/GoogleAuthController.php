<?php

namespace App\Http\Controllers;

use App\Http\Services\EmailService;
use App\Http\Services\CommonService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirige al usuario a Google OAuth
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $redirectUri = config('services.google.redirect');
        

        $params = [
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => 'openid email profile',
            'response_type' => 'code',
            'state' => Str::random(40),
            'access_type' => 'offline',
            'prompt' => 'consent'
        ];

        $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        
        return redirect($authUrl);
    }

    /**
     * Maneja el callback de Google OAuth
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $code = $request->get('code');
            $state = $request->get('state');

            if (!$code) {
                return redirect()->route('login')->with('error', 'Error en la autenticación con Google');
            }

            // Intercambiar código por token de acceso
            $tokenResponse = Http::post('https://oauth2.googleapis.com/token', [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => config('services.google.redirect'),
            ]);

            if (!$tokenResponse->successful()) {
                Log::error('Error obteniendo token de Google', ['response' => $tokenResponse->body()]);
                return redirect()->route('login')->with('error', 'Error en la autenticación con Google');
            }

            $tokenData = $tokenResponse->json();
            $accessToken = $tokenData['access_token'];

            // Obtener información del usuario
            $userResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->get('https://www.googleapis.com/oauth2/v2/userinfo');

            if (!$userResponse->successful()) {
                Log::error('Error obteniendo datos del usuario de Google', ['response' => $userResponse->body()]);
                return redirect()->route('login')->with('error', 'Error obteniendo información del usuario');
            }

            $googleUser = $userResponse->json();

            // Buscar o crear usuario
            $user = $this->findOrCreateUser($googleUser);

            if (!$user) {
                return redirect()->route('login')->with('error', 'Error creando el usuario');
            }

            // Autenticar al usuario
            Auth::login($user);

            // Log para debugging
            Log::info('Usuario Google autenticado', [
                'email' => $user->email,
                'is_new_user' => $user->is_new_user ?? 'no definido',
                'como_se_entero' => $user->como_se_entero
            ]);

            // Todos los usuarios van al dashboard
            // El modal se mostrará automáticamente si necesitan completar el registro
            return redirect()->route('company.select');

        } catch (\Exception $e) {
            Log::error('Error en Google OAuth callback', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Error en la autenticación con Google');
        }
    }

    /**
     * Busca o crea un usuario basado en los datos de Google
     */
    private function findOrCreateUser($googleUser)
    {
        try {
            // Buscar usuario existente por email
            $user = User::where('email', $googleUser['email'])->first();

            if ($user) {
                // Usuario existente - actualizar información si es necesario
                $user->update([
                    'name' => $googleUser['given_name'] ?? $user->name,
                    'lastname' => $googleUser['family_name'] ?? $user->lastname,
                    'google_id' => $googleUser['id'],
                ]);

                // Marcar como usuario existente
                $user->is_new_user = false;
                return $user;
            }

            // Crear nuevo usuario
            $user = User::create([
                'name' => $googleUser['given_name'] ?? '',
                'lastname' => $googleUser['family_name'] ?? '',
                'email' => $googleUser['email'],
                'password' => bcrypt(Str::random(16)), // Contraseña aleatoria
                'google_id' => $googleUser['id'],
                'email_verified_at' => now(), // Google ya verificó el email
                'como_se_entero' => null, // Se completará después
            ]);

            // Marcar como usuario nuevo
            $user->is_new_user = true;

            // Enviar correo de bienvenida
            $nombreCompleto = trim(($googleUser['given_name'] ?? '') . ' ' . ($googleUser['family_name'] ?? ''));
            EmailService::enviarCorreoBienvenida($user->email, $nombreCompleto);

            return $user;

        } catch (\Exception $e) {
            Log::error('Error creando/buscando usuario de Google', ['error' => $e->getMessage(), 'googleUser' => $googleUser]);
            return null;
        }
    }

    /**
     * Muestra el formulario para completar el registro de usuarios de Google
     */
    public function showCompleteRegistration()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Si el usuario ya completó el registro, redirigir al dashboard
        if ($user->como_se_entero !== null) {
            return redirect()->route('company.select');
        }

        return view('website.auth.google-complete-registration', [
            'footer' => CommonService::footer(),
            'links' => CommonService::links()
        ]);
    }

    /**
     * Completa el registro del usuario de Google
     */
    public function completeRegistration(Request $request)
    {
        $request->validate([
            'como_se_entero' => 'required|string|in:whatsapp,correo_electronico,mensaje_texto,llamada_telefonica,redes_sociales,evento,asesor,otro'
        ]);

        $user = Auth::user();
        $user->update([
            'como_se_entero' => $request->como_se_entero,
            'usuario_creo' => $user->id,        // El usuario que completa el registro
            'usuario_actualizo' => $user->id   // También se actualiza
        ]);

        return redirect()->route('company.select')->with('success', '¡Registro completado exitosamente!');
    }

    /**
     * Completa el registro del usuario desde el modal del dashboard
     */
    public function completeRegistrationFromModal(Request $request)
    {
        $request->validate([
            'como_se_entero' => 'required|string|in:whatsapp,correo_electronico,mensaje_texto,llamada_telefonica,redes_sociales,evento,asesor,otro'
        ]);

        $user = Auth::user();
        $user->update([
            'como_se_entero' => $request->como_se_entero,
            'usuario_creo' => $user->id,        // El usuario que completa el registro
            'usuario_actualizo' => $user->id   // También se actualiza
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Registro completado exitosamente!'
        ]);
    }
}
