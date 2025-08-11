<?php

namespace App\Http\Controllers;

use App\Services\ExternalEmailService;
use App\Http\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PasswordResetController extends Controller
{
    protected $emailService;

    public function __construct(ExternalEmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Mostrar formulario para solicitar recuperación de contraseña
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email', [
            'footer' => CommonService::footer(),
            'links' => CommonService::links()
        ]);
    }

    /**
     * Enviar correo de recuperación de contraseña
     */
    public function sendResetLinkEmail(Request $request)
    {
        Log::info('Iniciando solicitud de recuperación de contraseña', [
            'email' => $request->email,
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección válida.',
            'email.exists' => 'No existe una cuenta con esa dirección de email.',
        ]);

        if ($validator->fails()) {
            Log::warning('Validación fallida en solicitud de recuperación', [
                'email' => $request->email,
                'errors' => $validator->errors()->toArray()
            ]);
            
            if ($this->expectsJson($request)) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Verificar si la API externa está configurada
            if (!$this->emailService->isConfigured()) {
                Log::error('API externa de email no está configurada', [
                    'api_url' => config('services.external_email.api_url'),
                    'api_key_configured' => !empty(config('services.external_email.api_key'))
                ]);
                
                $errorMessage = 'Servicio de email temporalmente no disponible.';
                
                if ($this->expectsJson($request)) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => [$errorMessage]]
                    ], 422);
                }
                return back()->withErrors(['email' => $errorMessage]);
            }

            // Verificar el estado de la API externa antes de intentar enviar
            try {
                $healthCheck = $this->emailService->healthCheck();
                if ($healthCheck === false) {
                    Log::warning('API externa no responde correctamente antes de enviar email', [
                        'email' => $request->email
                    ]);
                    
                    $errorMessage = 'Servicio de email temporalmente no disponible. Por favor, inténtalo más tarde.';
                    
                    if ($this->expectsJson($request)) {
                        return response()->json([
                            'success' => false,
                            'errors' => ['email' => [$errorMessage]]
                        ], 422);
                    }
                    return back()->withErrors(['email' => $errorMessage]);
                }
            } catch (\Exception $e) {
                Log::error('Error al verificar estado de API externa', [
                    'email' => $request->email,
                    'error' => $e->getMessage()
                ]);
                
                $errorMessage = 'Error al verificar el servicio de email. Por favor, inténtalo más tarde.';
                
                if ($this->expectsJson($request)) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => [$errorMessage]]
                    ], 422);
                }
                return back()->withErrors(['email' => $errorMessage]);
            }

            // Generar token de recuperación
            $token = Str::random(64);
            $email = $request->email;

            Log::info('Generando token de recuperación', [
                'email' => $email,
                'token' => $token
            ]);

            // Guardar token en la base de datos
            DB::table('password_resets')->updateOrInsert(
                ['email' => $email],
                [
                    'email' => $email,
                    'token' => $token,
                    'created_at' => now()
                ]
            );

            // Construir URL de recuperación con el email como parámetro
            $resetUrl = url('/password/reset/' . $token . '?email=' . urlencode($email));

            // Obtener nombre del usuario
            $user = DB::table('users')->where('email', $email)->first();
            $userName = $user ? ($user->name ?? 'Usuario') : 'Usuario';

            Log::info('Enviando correo de recuperación', [
                'email' => $email,
                'user_name' => $userName,
                'reset_url' => $resetUrl
            ]);

            // Enviar correo a través de la API externa
            $this->emailService->sendPasswordReset(
                $email,
                $userName,
                $resetUrl,
                config('app.name')
            );

            Log::info('Solicitud de recuperación de contraseña enviada', [
                'email' => $email,
                'token' => $token
            ]);

            $successMessage = 'Hemos enviado un enlace de recuperación de contraseña a tu email.';
            
            if ($this->expectsJson($request)) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
            
            return back()->with('status', $successMessage);

        } catch (\Exception $e) {
            Log::error('Error al enviar correo de recuperación de contraseña', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'No pudimos enviar el enlace de recuperación. Por favor, inténtalo de nuevo.';
            
            if ($this->expectsJson($request)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => [$errorMessage]]
                ], 422);
            }
            
            return back()->withErrors(['email' => $errorMessage]);
        }
    }

    /**
     * Mostrar formulario para restablecer contraseña
     */
    public function showResetForm(Request $request, $token)
    {
        Log::info('Accediendo al formulario de reset de contraseña', [
            'token' => $token,
            'email_query' => $request->query('email'),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        $email = $request->query('email');
        
        // Si no hay email en la URL, redirigir al formulario de solicitud
        if (!$email) {
            Log::warning('No se proporcionó email en la URL de reset', [
                'token' => $token
            ]);
            
            return redirect()->route('password.request')->withErrors([
                'email' => 'Debes proporcionar tu dirección de correo electrónico.'
            ]);
        }
        
        // Verificar si el token es válido
        $passwordReset = DB::table('password_resets')
            ->where('token', $token)
            ->where('email', $email)
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if (!$passwordReset) {
            Log::warning('Token de reset inválido o expirado en showResetForm', [
                'token' => $token,
                'email' => $email
            ]);
            
            return redirect()->route('password.request')->withErrors([
                'email' => 'El enlace de recuperación es inválido o ha expirado.'
            ]);
        }

        Log::info('Formulario de reset mostrado correctamente', [
            'token' => $token,
            'email' => $email
        ]);

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $email,
            'footer' => CommonService::footer(),
            'links' => CommonService::links()
        ]);
    }

    /**
     * Restablecer la contraseña
     */
    public function reset(Request $request)
    {
        Log::info('Iniciando proceso de reset de contraseña', [
            'request_data' => $request->only(['token', 'email']),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        if ($validator->fails()) {
            Log::warning('Validación fallida en reset de contraseña', [
                'errors' => $validator->errors()->toArray()
            ]);
            
            if ($this->expectsJson($request)) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $token = $request->token;
            $email = $request->email;
            $password = $request->password;

            Log::info('Verificando token de reset', [
                'token' => $token,
                'email' => $email
            ]);

            // Verificar token y que no haya expirado
            $passwordReset = DB::table('password_resets')
                ->where('token', $token)
                ->where('email', $email)
                ->where('created_at', '>', now()->subHours(24))
                ->first();

            if (!$passwordReset) {
                Log::warning('Token de reset inválido o expirado', [
                    'token' => $token,
                    'email' => $email
                ]);
                
                $errorMessage = 'El enlace de recuperación es inválido o ha expirado.';
                
                if ($this->expectsJson($request)) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => [$errorMessage]]
                    ], 422);
                }
                
                return back()->withErrors(['email' => $errorMessage]);
            }

            Log::info('Token válido encontrado, procediendo a actualizar contraseña', [
                'email' => $email
            ]);

            // Actualizar contraseña del usuario
            $updated = DB::table('users')
                ->where('email', $email)
                ->update([
                    'password' => Hash::make($password),
                    'updated_at' => now()
                ]);

            if (!$updated) {
                Log::error('No se pudo actualizar la contraseña del usuario', [
                    'email' => $email
                ]);
                throw new \Exception('No se pudo actualizar la contraseña del usuario');
            }

            // Eliminar token usado
            DB::table('password_resets')
                ->where('email', $email)
                ->delete();

            Log::info('Contraseña restablecida exitosamente', [
                'email' => $email
            ]);

            $successMessage = 'Tu contraseña ha sido restablecida exitosamente. Ya puedes iniciar sesión.';
            
            if ($this->expectsJson($request)) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
            
            return redirect('/ingreso')->with('status', $successMessage);

        } catch (\Exception $e) {
            Log::error('Error al restablecer contraseña', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'No pudimos restablecer tu contraseña. Por favor, inténtalo de nuevo.';
            
            if ($this->expectsJson($request)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => [$errorMessage]]
                ], 422);
            }
            
            return back()->withErrors(['email' => $errorMessage]);
        }
    }

    /**
     * Verificar estado de la API externa
     */
    public function checkApiStatus()
    {
        try {
            $status = $this->emailService->healthCheck();
            return response()->json($status);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar estado de la API',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verificar si la petición espera una respuesta JSON
     */
    private function expectsJson(Request $request)
    {
        return $request->expectsJson() || $request->ajax() || $request->wantsJson();
    }
}
