@extends('website.layouts.main')
@section('title','Ruta C - Completar Registro')
@section('description','Completar información de registro')

@section('content')
<div class="wrap wrap-small">
    <div id="google-complete-registration">
        <div class="registration-header">
            <div class="icon-circle">
                <i class="fa fa-user-plus"></i>
            </div>
            <h2 class="mayus">Completar Registro</h2>
            <p class="textc">Solo necesitamos una información adicional para completar tu registro</p>
        </div>
        
        <form id="completeRegistrationForm" method="POST" action="{{ route('google.complete-registration.save') }}">
            @csrf
            <div class="row">
                <label class="textl">¿Cómo te enteraste de Ruta C?</label>
                <select class="form-select" id="como_se_entero" name="como_se_entero" required>
                    <option value="">Seleccione una opción</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="correo_electronico">Correo Electrónico</option>
                    <option value="mensaje_texto">Mensaje de Texto</option>
                    <option value="llamada_telefonica">Llamada Telefónica</option>
                    <option value="redes_sociales">Redes Sociales</option>
                    <option value="evento">Evento</option>
                    <option value="asesor">Asesor</option>
                    <option value="otro">Otro</option>
                </select>
                <div class="text-danger" id="como_se_entero-error" style="text-align: left; margin-top: 5px;"></div>
            </div>
            
            <div class="row" tabindex="6">
                <input class="button button-primary" type="submit" name="send" value="Completar Registro" id="submit-btn">
            </div>
        </form>
        
        <div id="success-message" style="display: none; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin-top: 20px; color: #155724;"></div>
        <div id="error-message" style="display: none; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin-top: 20px; color: #721c24;"></div>
    </div>
</div>

<style>
    .wrap.wrap-small {
        margin-top: 80px;
        margin-bottom: 40px;
    }
    
    #google-complete-registration {
        max-width: 550px;
        margin: 0 auto;
        padding: 50px 30px;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    }
    
    .registration-header {
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
    
    #google-complete-registration h2 {
        font-size: 32px;
        color: #2c3e50;
        margin-bottom: 12px;
        font-weight: 600;
        letter-spacing: 1px;
    }
    
    #google-complete-registration p {
        font-size: 15px;
        color: #7f8c8d;
        margin-bottom: 0;
    }
    
    #google-complete-registration .row {
        margin-bottom: 25px;
    }
    
    #google-complete-registration label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        letter-spacing: 0.3px;
    }
    
    #google-complete-registration select {
        width: 100%;
        padding: 15px 18px;
        border: 2px solid #e0e6ed;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
        background: #f8f9fa;
    }
    
    #google-complete-registration select:focus {
        border-color: #667eea;
        outline: none;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    #google-complete-registration input[type="submit"] {
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
        color: white;
    }
    
    #google-complete-registration input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }
    
    #google-complete-registration input[type="submit"]:active {
        transform: translateY(0);
    }
    
    #google-complete-registration .text-danger {
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
        
        #google-complete-registration {
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
        
        #google-complete-registration h2 {
            font-size: 26px;
        }
    }
</style>

<script>
$(document).ready(function() {
    $('#completeRegistrationForm').on('submit', function(e) {
        e.preventDefault();
        
        const comoSeEntero = $('#como_se_entero').val();
        const comoSeEnteroError = $('#como_se_entero-error');
        const successMessage = $('#success-message');
        const errorMessage = $('#error-message');
        
        // Limpiar mensajes anteriores
        comoSeEnteroError.text('');
        successMessage.hide();
        errorMessage.hide();
        
        // Validaciones
        if (!comoSeEntero) {
            comoSeEnteroError.text('Por favor selecciona cómo te enteraste de Ruta C.');
            return;
        }
        
        // Deshabilitar botón y mostrar loading
        const submitBtn = $('#submit-btn');
        submitBtn.prop('disabled', true);
        submitBtn.val('Completando...');
        
        $.ajax({
            url: '{{ route("google.complete-registration.save") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    successMessage.show();
                    successMessage.html('<i class="fa fa-check-circle" aria-hidden="true"></i> ' + response.message);
                    
                    // Redirigir después de 2 segundos
                    setTimeout(function() {
                        window.location.href = '{{ route("company.select") }}';
                    }, 2000);
                } else {
                    errorMessage.show();
                    errorMessage.html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> ' + response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                errorMessage.show();
                errorMessage.html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> ' + 
                    (response && response.message ? response.message : 'Error al completar el registro. Por favor intenta nuevamente.'));
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.val('Completar Registro');
            }
        });
    });
});
</script>
@endsection
