@extends('website.layouts.main')
@section('title','Ruta C | Restablecer Contraseña')
@section('description','Restablecer contraseña')

@section('content')
<div class="wrap wrap-small">
    <div id="password-reset">
        <div class="password-reset-header">
            <div class="icon-circle">
                <i class="fa fa-lock"></i>
            </div>
            <h2 class="mayus">Restablecer contraseña</h2>
            <p class="textc">Crea una nueva contraseña segura para tu cuenta</p>
        </div>
        
        <form id="passwordResetForm">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="row">
                <label class="textl">Nueva contraseña</label>
                <div style="position: relative; width: 100%;">
                    <input type="password" id="password" name="password" placeholder="Nueva contraseña" required minlength="8" style="padding-right: 50px;" />
                    <i class="fa fa-eye" id="togglePassword" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #999;" aria-hidden="true"></i>
                </div>
                <small style="font-size: 12px; color: #666; margin-top: 5px; display: block; text-align: left;">Mínimo 8 caracteres</small>
                <div class="text-danger" id="password-error" style="text-align: left; margin-top: 5px;"></div>
            </div>
            
            <div class="row">
                <label class="textl">Confirmar contraseña</label>
                <div style="position: relative; width: 100%;">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar contraseña" required style="padding-right: 50px;" />
                    <i class="fa fa-eye" id="togglePasswordConfirmation" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #999;" aria-hidden="true"></i>
                </div>
                <div class="text-danger" id="password-confirmation-error" style="text-align: left; margin-top: 5px;"></div>
            </div>
            
                         <div class="row" tabindex="6">
                 <input class="button button-primary" type="submit" name="send" value="Actualizar contraseña" id="submit-btn">
             </div>
             
            </form>
            
            <div class="back-to-login">
                <a href="{{ route('login') }}">
                    <i class="fa fa-arrow-left"></i> Volver al inicio de sesión
                </a>
            </div>

        <div id="success-message" style="display: none; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin-top: 20px; color: #155724;"></div>
        <div id="error-message" style="display: none; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin-top: 20px; color: #721c24;"></div>
    </div>
</div>

<style>
    .wrap.wrap-small {
        margin-top: 80px;
        margin-bottom: 40px;
    }
    
    #password-reset {
        max-width: 550px;
        margin: 0 auto;
        padding: 50px 30px;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    }
    
    .password-reset-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .icon-circle {
        width: 80px;
        height: 80px;
        margin: 0 auto 25px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .icon-circle i {
        font-size: 35px;
        color: #ffffff;
    }
    
    #password-reset h2 {
        font-size: 32px;
        color: #2c3e50;
        margin-bottom: 12px;
        font-weight: 600;
        letter-spacing: 1px;
    }
    
    #password-reset p {
        font-size: 15px;
        color: #7f8c8d;
        margin-bottom: 0;
    }
    
    #password-reset .row {
        margin-bottom: 25px;
    }
    
    #password-reset label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        letter-spacing: 0.3px;
    }
    
    #password-reset input[type="password"],
    #password-reset input[type="text"] {
        width: 100%;
        padding: 15px 50px 15px 18px;
        border: 2px solid #e0e6ed;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
        background: #f8f9fa;
    }
    
    #password-reset input[type="password"]:focus,
    #password-reset input[type="text"]:focus {
        border-color: #667eea;
        outline: none;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    #password-reset small {
        display: block;
        font-size: 12px;
        color: #95a5a6;
        margin-top: 8px;
    }
    
    #password-reset input[type="submit"] {
        width: 100%;
        margin-top: 10px;
        padding: 16px;
        font-weight: 600;
        font-size: 16px;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    #password-reset input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }
    
    #password-reset input[type="submit"]:active {
        transform: translateY(0);
    }
    
    #password-reset .fa-eye {
        transition: all 0.3s;
        font-size: 16px;
    }
    
    #password-reset .fa-eye:hover {
        color: #667eea;
        transform: scale(1.1);
    }
    
    .back-to-login {
        text-align: center;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e9ecef;
    }
    
    .back-to-login a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #7f8c8d;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .back-to-login a:hover {
        color: #667eea;
    }
    
    .back-to-login a i {
        transition: transform 0.3s;
    }
    
    .back-to-login a:hover i {
        transform: translateX(-5px);
    }
    
    #password-reset .text-danger {
        font-size: 13px;
        font-weight: 500;
        margin-top: 5px;
    }
    
    #success-message,
    #error-message {
        border-radius: 8px;
        font-weight: 500;
    }
    
    @media (max-width: 576px) {
        .wrap.wrap-small {
            margin-top: 40px;
            margin-bottom: 20px;
        }
        
        #password-reset {
            padding: 30px 20px;
            margin: 20px;
        }
        
        .icon-circle {
            width: 70px;
            height: 70px;
        }
        
        .icon-circle i {
            font-size: 30px;
        }
        
        #password-reset h2 {
            font-size: 26px;
        }
    }
</style>

<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').click(function() {
        const passwordInput = $('#password');
        const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
        passwordInput.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
    
    $('#togglePasswordConfirmation').click(function() {
        const passwordInput = $('#password_confirmation');
        const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
        passwordInput.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
    
    $('#passwordResetForm').on('submit', function(e) {
        e.preventDefault();
        
        const password = $('#password').val();
        const passwordConfirmation = $('#password_confirmation').val();
        const passwordError = $('#password-error');
        const passwordConfirmationError = $('#password-confirmation-error');
        const successMessage = $('#success-message');
        const errorMessage = $('#error-message');
        
        // Limpiar mensajes anteriores
        passwordError.text('');
        passwordConfirmationError.text('');
        successMessage.hide();
        errorMessage.hide();
        
        // Validaciones
        if (password.length < 8) {
            passwordError.text('La contraseña debe tener al menos 8 caracteres.');
            return;
        }
        
        if (password !== passwordConfirmation) {
            passwordConfirmationError.text('Las contraseñas no coinciden.');
            return;
        }
        
        // Deshabilitar botón y mostrar loading
        const submitBtn = $('#submit-btn');
        submitBtn.prop('disabled', true);
        submitBtn.val('Actualizando...');
        
        $.ajax({
            url: '{{ route("password.reset") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    successMessage.show();
                    successMessage.html('<i class="fa fa-check-circle" aria-hidden="true"></i> ' + response.message);
                    $('#passwordResetForm')[0].reset();
                    
                    // Redirigir después de 3 segundos
                    setTimeout(function() {
                        window.location.href = '{{ route("login") }}';
                    }, 3000);
                } else {
                    errorMessage.show();
                    errorMessage.html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> ' + response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                errorMessage.show();
                errorMessage.html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> ' + 
                    (response && response.message ? response.message : 'Error al actualizar la contraseña. Por favor intenta nuevamente.'));
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.val('Actualizar contraseña');
            }
        });
    });
});
</script>
@endsection
