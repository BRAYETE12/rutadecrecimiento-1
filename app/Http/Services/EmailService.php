<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailService
{
    private const API_URL = 'https://adm.rutadecrecimiento.com/api/email/html';
    private static function getApiKey(): string
    {
        return config('services.email.api_key');
    }

    /**
     * Envía un correo HTML personalizado usando la API
     */
    public static function enviarCorreoPersonalizado(array $data): bool
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-API-Key' => self::getApiKey(),
            ])->post(self::API_URL, $data);

            if ($response->successful()) {
                Log::info('Correo enviado exitosamente', [
                    'to' => $data['to'],
                    'subject' => $data['subject']
                ]);
                return true;
            } else {
                Log::error('Error al enviar correo', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'data' => $data
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Excepción al enviar correo', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return false;
        }
    }

    /**
     * Genera el template HTML base con el estilo de Ruta C
     */
    public static function generarTemplateBase(string $titulo, string $contenido, string $nombreUsuario = ''): string
    {
        return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$titulo}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f8f9fa;
                    line-height: 1.6;
                }
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    background: #ffffff;
                }
                .header-banner {
                    background: #213770;
                    padding: 30px 20px;
                    text-align: center;
                    color: white;
                }
                .header-banner .slogan {
                    font-size: 16px;
                    font-weight: 500;
                    margin-bottom: 20px;
                    text-align: right;
                }
                .logos-container {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                }
                .camara-logo {
                    text-align: left;
                }
                .camara-logo img {
                    height: 50px;
                    max-width: 200px;
                }
                .rutac-logo {
                    font-size: 24px;
                    font-weight: bold;
                    color: white;
                }
                .rutac-logo .c-icon {
                    display: inline-block;
                    width: 20px;
                    height: 20px;
                    border: 2px solid white;
                    border-radius: 50%;
                    margin-left: 5px;
                    position: relative;
                }
                .rutac-logo .c-icon::after {
                    content: '';
                    position: absolute;
                    top: -2px;
                    right: -2px;
                    width: 8px;
                    height: 8px;
                    background: white;
                    border-radius: 50%;
                }
                .main-title {
                    font-size: 28px;
                    font-weight: bold;
                    margin: 0;
                    text-align: center;
                }
                .content-body {
                    padding: 40px 30px;
                    background: white;
                }
                .greeting {
                    font-size: 16px;
                    color: #333;
                    margin-bottom: 20px;
                }
                .greeting strong {
                    color: #213770;
                }
                .message {
                    font-size: 15px;
                    color: #555;
                    margin-bottom: 20px;
                    line-height: 1.6;
                }
                .highlight-box {
                    background: #f8f9fa;
                    border-left: 4px solid #213770;
                    padding: 20px;
                    margin: 25px 0;
                    border-radius: 0 8px 8px 0;
                }
                .highlight-box h3 {
                    color: #213770;
                    margin-top: 0;
                    font-size: 18px;
                }
                .highlight-box ul {
                    margin: 10px 0;
                    padding-left: 20px;
                }
                .highlight-box li {
                    margin: 8px 0;
                    color: #555;
                }
                .cta-button {
                    display: inline-block;
                    background: #F7B500;
                    color: white;
                    padding: 15px 30px;
                    text-decoration: none;
                    border-radius: 8px;
                    font-weight: bold;
                    font-size: 16px;
                    margin: 20px 0;
                    border: 1px solid #000;
                    text-align: center;
                }
                .cta-button:hover {
                    background: #e6a300;
                }
                .footer-link {
                    color: #213770;
                    text-decoration: none;
                    font-size: 14px;
                }
                .footer-link:hover {
                    text-decoration: underline;
                }
                .footer {
                    background: #f8f9fa;
                    padding: 30px;
                    text-align: center;
                    color: #666;
                    border-top: 1px solid #e9ecef;
                }
                .footer p {
                    margin: 5px 0;
                    font-size: 14px;
                }
                @media (max-width: 600px) {
                    .email-container {
                        margin: 0;
                    }
                    .header-banner, .content-body, .footer {
                        padding: 20px;
                    }
                    .logos-container {
                        flex-direction: column;
                        gap: 15px;
                    }
                    .main-title {
                        font-size: 24px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='header-banner'>
                    <div class='slogan'>Haz crecer tu negocio</div>
                    <div class='logos-container'>
                        <div class='camara-logo'>
                            <img src='https://cdnsicam.net/img/rutac/rutac_blanco.png' alt='Cámara de Comercio de Santa Marta para el Magdalena - Ruta C' />
                        </div>
                   
                    </div>
                    <h1 class='main-title'>{$titulo}</h1>
                </div>
                <div class='content-body'>
                    {$contenido}
                </div>
                <div class='footer'>
                    <p><strong>Ruta C - Ruta de Crecimiento</strong></p>
                    <p>Cámara de Comercio de Santa Marta para el Magdalena</p>
                    <p>© " . date('Y') . " Todos los derechos reservados.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Envía correo de bienvenida cuando se crea un usuario
     */
    public static function enviarCorreoBienvenida(string $email, string $nombre): bool
    {
        $contenido = "
            <div class='greeting'>Hola <strong>{$nombre}</strong>,</div>
            
            <div class='message'>
                ¡Nos complace darte la bienvenida a <strong>Ruta de Crecimiento</strong>!
            </div>
            
            <div class='message'>
                Tu cuenta ha sido creada exitosamente y ahora tienes acceso a todas las herramientas y recursos que necesitas para hacer crecer tu empresa.
            </div>
            
            <div class='highlight-box'>
                <h3>¿Qué puedes hacer ahora?</h3>
                <ul>
                    <li>Registrar tu unidad productiva</li>
                    <li>Realizar diagnósticos empresariales</li>
                    <li>Acceder a programas de crecimiento</li>
                    <li>Conectar con otros empresarios</li>
                </ul>
            </div>
            
            <div class='message'>
                Estamos aquí para acompañarte en cada paso de tu crecimiento empresarial. Si tienes alguna pregunta, no dudes en contactarnos.
            </div>
            
            <div class='message'>
                ¡Bienvenido al futuro de tu empresa!
            </div>
            
            <div class='message'>
                <strong>El equipo de Ruta C</strong>
            </div>
        ";

        $html = self::generarTemplateBase('¡Bienvenido a Ruta C!', $contenido, $nombre);

        return self::enviarCorreoPersonalizado([
            'to' => $email,
            'subject' => '¡Bienvenido a Ruta C - Ruta de Crecimiento!',
            'html' => $html,
        ]);
    }

    /**
     * Envía correo cuando se crea una unidad productiva
     */
    public static function enviarCorreoUnidadProductiva(string $email, string $nombreUsuario, string $nombreEmpresa): bool
    {
        $contenido = "
            <div class='greeting'>Hola <strong>{$nombreUsuario}</strong>,</div>
            
            <div class='message'>
                ¡Excelente noticia! Tu unidad productiva <strong>{$nombreEmpresa}</strong> ha sido registrada exitosamente en Ruta C.
            </div>
            
            <div class='highlight-box'>
                <h3>Próximos pasos recomendados:</h3>
                <ul>
                    <li>Completa tu diagnóstico empresarial</li>
                    <li>Explora los programas disponibles</li>
                    <li>Actualiza la información de tu empresa</li>
                    <li>Conecta con otros empresarios</li>
                </ul>
            </div>
            
            <div class='message'>
                El diagnóstico te ayudará a identificar las áreas de oportunidad y los programas más adecuados para el crecimiento de tu empresa.
            </div>
            
            <div class='message'>
                ¡Estamos emocionados de acompañarte en este viaje de crecimiento!
            </div>
            
            <div class='message'>
                <strong>El equipo de Ruta C</strong>
            </div>
        ";

        $html = self::generarTemplateBase('Unidad Productiva Registrada', $contenido, $nombreUsuario);

        return self::enviarCorreoPersonalizado([
            'to' => $email,
            'subject' => 'Unidad Productiva Registrada - Ruta C',
            'html' => $html,
        ]);
    }

    /**
     * Envía correo cuando se completa un diagnóstico
     */
    public static function enviarCorreoDiagnosticoCompletado(string $email, string $nombreUsuario, string $nombreEmpresa, float $puntaje, string $etapa): bool
    {
        $contenido = "
            <div class='greeting'>Hola <strong>{$nombreUsuario}</strong>,</div>
            
            <div class='message'>
                ¡Felicitaciones! Has completado exitosamente el diagnóstico empresarial para <strong>{$nombreEmpresa}</strong>.
            </div>
            
            <div class='highlight-box'>
                <h3>Resultados de tu diagnóstico:</h3>
                <ul>
                    <li><strong>Puntaje obtenido:</strong> {$puntaje}%</li>
                    <li><strong>Etapa actual:</strong> {$etapa}</li>
                </ul>
            </div>
            
            <div class='message'>
                Basándonos en estos resultados, hemos identificado las mejores oportunidades de crecimiento para tu empresa. Te recomendamos revisar los programas y recursos disponibles en tu dashboard.
            </div>
            
            <div class='message'>
                ¡Sigue trabajando en el crecimiento de tu empresa! Estamos aquí para apoyarte en cada paso.
            </div>
            
            <div class='message'>
                <strong>El equipo de Ruta C</strong>
            </div>
        ";

        $html = self::generarTemplateBase('Diagnóstico Completado', $contenido, $nombreUsuario);

        return self::enviarCorreoPersonalizado([
            'to' => $email,
            'subject' => 'Diagnóstico Completado - Ruta C',
            'html' => $html,
        ]);
    }
}