@extends('website.layouts.main')
@section('title','Ruta C | Recuperar Contraseña')
@section('description','Recuperar contraseña')

@section('content')
<div id="password-reset" class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4">¿Olvidaste tu contraseña?</h2>
                    <p class="text-center mb-4">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
                    
                    <form id="passwordResetForm">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                            <div class="text-danger" id="email-error"></div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="submit-btn">
                                <i class="fas fa-paper-plane me-2"></i>Enviar enlace de recuperación
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Volver al inicio de sesión
                            </a>
                        </div>
                    </form>

                    <div class="alert alert-success d-none" id="success-message"></div>
                    <div class="alert alert-danger d-none" id="error-message"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #password-reset {
        min-height: 70vh;
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }
    .card {
        border: none;
        border-radius: 15px;
    }
    .card-title {
        color: #333;
        font-weight: 600;
    }
    .btn-primary {
        background-color: #0d6efd;
        border: none;
        padding: 12px;
        border-radius: 8px;
        font-weight: 500;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
    }
    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ddd;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
</style>

<script>
$(document).ready(function() {
    $('#passwordResetForm').on('submit', function(e) {
        e.preventDefault();
        
        const email = $('#email').val();
        const submitBtn = $('#submit-btn');
        const emailError = $('#email-error');
        const successMessage = $('#success-message');
        const errorMessage = $('#error-message');
        
        // Limpiar mensajes anteriores
        emailError.text('');
        successMessage.addClass('d-none');
        errorMessage.addClass('d-none');
        
        // Validación básica
        if (!email) {
            emailError.text('El correo electrónico es requerido.');
            return;
        }
        
        // Deshabilitar botón y mostrar loading
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Enviando...');
        
        $.ajax({
            url: '{{ route("password.send") }}',
            method: 'POST',
            data: {
                email: email,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    successMessage.removeClass('d-none');
                    successMessage.html('<i class="fas fa-check-circle me-2"></i>' + response.message);
                    $('#passwordResetForm')[0].reset();
                    
                    // Redirigir después de 3 segundos
                    setTimeout(function() {
                        window.location.href = '{{ route("login") }}';
                    }, 3000);
                } else {
                    errorMessage.removeClass('d-none');
                    errorMessage.html('<i class="fas fa-exclamation-circle me-2"></i>' + response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                errorMessage.removeClass('d-none');
                errorMessage.html('<i class="fas fa-exclamation-circle me-2"></i>' + 
                    (response && response.message ? response.message : 'Error al enviar el correo. Por favor intenta nuevamente.'));
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.html('<i class="fas fa-paper-plane me-2"></i>Enviar enlace de recuperación');
            }
        });
    });
});
</script>
@endsection

