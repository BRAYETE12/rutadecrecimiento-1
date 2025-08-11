<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class ExternalEmailService
{
    protected $apiBaseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiBaseUrl = config('services.external_email.api_url');
        $this->apiKey = config('services.external_email.api_key');
    }

    /**
     * Enviar correo de recuperación de contraseña a través de la API externa
     */
    public function sendPasswordReset($email, $userName, $resetUrl, $projectName = null)
    {
        try {
            // Validar que la API key esté configurada
            if (empty($this->apiKey)) {
                Log::error('API key no configurada para el servicio de email externo');
                throw new \Exception('API key no configurada para el servicio de email externo');
            }

            $fullUrl = rtrim($this->apiBaseUrl, '/') . '/api/email/password-reset';
            $requestData = [
                'email' => $email,
                'reset_url' => $resetUrl,
                'user_name' => $userName,
                'project_name' => $projectName ?? config('app.name'),
            ];

            Log::info('Enviando solicitud a API externa', [
                'url' => $fullUrl,
                'data' => $requestData,
                'api_key_length' => strlen($this->apiKey),
                'api_key_prefix' => substr($this->apiKey, 0, 8) . '...'
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-API-Key' => $this->apiKey,
                'Accept' => 'application/json'
            ])->post($fullUrl, $requestData);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Correo de recuperación enviado exitosamente a través de API externa', [
                    'email' => $email,
                    'response' => $data
                ]);
                return $data;
            } else {
                $errorResponse = $response->json();
                Log::error('Error al enviar correo de recuperación a través de API externa', [
                    'email' => $email,
                    'status' => $response->status(),
                    'response' => $errorResponse
                ]);
                throw new \Exception('Error en la API externa: ' . $response->status() . ' - ' . json_encode($errorResponse));
            }
        } catch (\Exception $e) {
            Log::error('Excepción al enviar correo de recuperación a través de API externa', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Verificar el estado de la API externa
     */
    public function healthCheck()
    {
        try {
            // Validar que la API key esté configurada
            if (empty($this->apiKey)) {
                Log::error('API key no configurada para el servicio de email externo');
                return false;
            }

            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Accept' => 'application/json'
            ])->get(rtrim($this->apiBaseUrl, '/') . '/api/email/health');

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::warning('API externa no responde correctamente', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error al verificar estado de API externa', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Verificar si la API externa está configurada
     */
    public function isConfigured()
    {
        $isConfigured = !empty($this->apiBaseUrl) && !empty($this->apiKey);
        
        Log::info('Verificando configuración del servicio de email externo', [
            'api_url_configured' => !empty($this->apiBaseUrl),
            'api_key_configured' => !empty($this->apiKey),
            'api_key_length' => $this->apiKey ? strlen($this->apiKey) : 0,
            'is_fully_configured' => $isConfigured
        ]);
        
        return $isConfigured;
    }
}
