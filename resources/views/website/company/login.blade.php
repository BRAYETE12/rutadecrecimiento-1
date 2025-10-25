@extends('website.layouts.main')
@section('title','Ruta C - Ingreso de empresarios')
@section('description','')

@section('content')
<div id="login">
    <form method="post" action="{{route('login.process')}}">
        @csrf
        <h2 class="mayus mb-20">Iniciar sesión</h2>
        <div class="row">
            <label class="textl">Email</label>
            <input type="text" name="email" tabindex="4" placeholder="Email" autocomplete="username" />
        </div>
        <div class="row">
            <label class="textl">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" tabindex="5" required autocomplete="current-password" />
            <span id="divMostrarPassword" style="position: absolute; margin-left: -30px; cursor: pointer; padding: 15px 0px; width: 30px;" >
                <i class="fa fa-solid fa-eye bi bi-eye-slash" id="togglePassword"></i>
            </span>
        </div>
        <div class="row" tabindex="6">
            <input class="button button-primary" type="submit" name="send" value="Iniciar sesión">
        </div>
        <div class="row" tabindex="6">
            <a class="button button-third mt-10 forgot-password block" href="#" id="openForgotPasswordModal" tabindex="7">¿Olvidó su contraseña?</a>
        </div>
    </form>
</div>

<!-- Modal de Recuperación de Contraseña -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mayus" id="forgotPasswordModalLabel">Recuperar contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
                
                <form id="forgotPasswordForm">
                    @csrf
                    <div class="row">
                        <label class="textl">Correo electrónico</label>
                        <input type="email" id="reset_email" name="email" placeholder="Correo electrónico" required autofocus>
                        <div class="text-danger" id="email-error" style="text-align: left; margin-top: 5px;"></div>
                    </div>
                    
                    <div class="row mt-20">
                        <button type="submit" class="button button-primary" id="submit-forgot-btn">
                            Enviar enlace de recuperación
                        </button>
                    </div>
                </form>

                <div id="forgot-success-message" style="display: none; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin-top: 15px; color: #155724;"></div>
                <div id="forgot-error-message" style="display: none; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin-top: 15px; color: #721c24;"></div>
            </div>
        </div>
    </div>
</div>

<style>
    #forgotPasswordModal .modal-content {
        border-radius: 10px;
    }
    
    #forgotPasswordModal .modal-header {
        border-bottom: 1px solid #e9ecef;
    }
    
    #forgotPasswordModal .modal-title {
        font-weight: 600;
        font-size: 18px;
    }
    
    #forgotPasswordModal .modal-body {
        padding: 30px;
    }
    
    #forgotPasswordModal .row {
        margin-bottom: 15px;
    }
    
    #forgotPasswordModal input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    #forgotPasswordModal input:focus {
        border-color: #007bff;
        outline: none;
    }
    
    #forgotPasswordModal label {
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }
</style>

<script>
  $(document).ready(function () {
      // Toggle password visibility
      $("#divMostrarPassword").click(function () {
          console.log($("#password").attr('type'));
          var tipo  = ($("#password").attr('type') === "password" ? "text" : "password");
          console.log(tipo);
          password.setAttribute("type", tipo);
      });
      
      // Abrir modal de recuperación
      $('#openForgotPasswordModal').click(function(e) {
          e.preventDefault();
          const modal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
          modal.show();
      });
      
      // Enviar formulario de recuperación
      $('#forgotPasswordForm').on('submit', function(e) {
          e.preventDefault();
          
          const email = $('#reset_email').val();
          const submitBtn = $('#submit-forgot-btn');
          const emailError = $('#email-error');
          const successMessage = $('#forgot-success-message');
          const errorMessage = $('#forgot-error-message');
          
          // Limpiar mensajes anteriores
          emailError.text('');
          successMessage.hide();
          errorMessage.hide();
          
          // Validación básica
          if (!email) {
              emailError.text('El correo electrónico es requerido.');
              return;
          }
          
          // Deshabilitar botón y mostrar loading
          submitBtn.prop('disabled', true);
          submitBtn.text('Enviando...');
          
          $.ajax({
              url: '{{ route("password.send") }}',
              method: 'POST',
              data: {
                  email: email,
                  _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                  if (response.success) {
                      successMessage.show();
                      successMessage.html('<i class="fa fa-check-circle" aria-hidden="true"></i> ' + response.message);
                      $('#forgotPasswordForm')[0].reset();
                      
                      // Cerrar modal después de 2 segundos
                      setTimeout(function() {
                          const modal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
                          modal.hide();
                          successMessage.hide();
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
                      (response && response.message ? response.message : 'Error al enviar el correo. Por favor intenta nuevamente.'));
              },
              complete: function() {
                  submitBtn.prop('disabled', false);
                  submitBtn.text('Enviar enlace de recuperación');
              }
          });
      });
  });
</script>

@endsection
