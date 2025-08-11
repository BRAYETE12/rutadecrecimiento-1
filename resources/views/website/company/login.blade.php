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
        <button type="button" class="button button-third mt-10 forgot-password block" id="btnForgotPassword" tabindex="7">¿Olvidó su contraseña?</button>
        </div>
    </form>
</div>

<!-- Modal de Recuperación de Contraseña -->
<div id="modalForgotPassword" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Recuperar Contraseña</h3>
            <span class="close" id="closeModal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="formForgotPassword" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="row">
                    <label class="textl">Email</label>
                    <input type="email" name="email" id="forgotEmail" placeholder="Ingrese su email" required />
                </div>
                <div class="row">
                    <button type="submit" class="button button-primary" id="btnSendReset">
                        <span id="btnText">Enviar enlace de recuperación</span>
                        <span id="btnLoading" style="display: none;">
                            <i class="fa fa-spinner fa-spin"></i> Enviando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  $(document).ready(function () {
      // Toggle password visibility
      $("#divMostrarPassword").click(function () {
          console.log($("#password").attr('type'));
          var tipo  = ($("#password").attr('type') === "password" ? "text" : "password");
          console.log(tipo);
          password.setAttribute("type", tipo);
      });

      // Modal functionality
      $("#btnForgotPassword").click(function() {
          $("#modalForgotPassword").show();
          $("#forgotEmail").focus();
      });

      $("#closeModal").click(function() {
          $("#modalForgotPassword").hide();
          $("#formForgotPassword")[0].reset();
      });

      // Close modal when clicking outside
      $(window).click(function(event) {
          if (event.target == $("#modalForgotPassword")[0]) {
              $("#modalForgotPassword").hide();
              $("#formForgotPassword")[0].reset();
          }
      });

      // Handle form submission
      $("#formForgotPassword").submit(function(e) {
          e.preventDefault();
          
          var email = $("#forgotEmail").val();
          if (!email) {
              Swal.fire({
                  icon: 'warning',
                  title: 'Campo requerido',
                  text: 'Por favor ingrese su email',
                  confirmButtonText: 'Entendido'
              });
              return;
          }

          // Show loading state
          $("#btnText").hide();
          $("#btnLoading").show();
          $("#btnSendReset").prop('disabled', true);

          // Submit form via AJAX
      // Submit form via AJAX
$.ajax({
    url: $(this).attr('action'),
    method: 'POST',
    data: $(this).serialize(),
    dataType: 'json', // <-- importante para decodificar bien
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json'
    },
    success: function(response) {
        $("#modalForgotPassword").hide();
        $("#formForgotPassword")[0].reset();

        Swal.fire({
            icon: response.success ? 'success' : 'info',
            title: response.success ? '¡Enlace enviado!' : 'Aviso',
            text: response.message, // ← usa el mensaje que manda el backend
            confirmButtonText: 'Entendido'
        });
    },
    error: function(xhr) {
        let message = "Error al enviar el enlace de recuperación.";
        
        if (xhr.responseJSON) {
            if (xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            if (xhr.status === 422 && xhr.responseJSON.errors) {
                const firstField = Object.keys(xhr.responseJSON.errors)[0];
                if (firstField && xhr.responseJSON.errors[firstField][0]) {
                    message = xhr.responseJSON.errors[firstField][0];
                }
            }
        }

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonText: 'Entendido'
        });
    },
    complete: function() {
        $("#btnText").show();
        $("#btnLoading").hide();
        $("#btnSendReset").prop('disabled', false);
    }
});

      });
  });
</script>

<style>
/* Modal Styles */
.modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 0;
    border: 1px solid #888;
    width: 90%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.modal-header {
    background-color: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #dee2e6;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: #333;
    font-size: 18px;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    line-height: 1;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
}

.modal-body {
    padding: 20px;
}

.modal-body .row {
    margin-bottom: 15px;
}

.modal-body label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #333;
}

.modal-body input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.modal-body input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.modal-body button {
    width: 100%;
    padding: 12px;
    font-size: 14px;
}

/* Loading spinner */
.fa-spinner {
    margin-right: 5px;
}

/* Responsive */
@media (max-width: 480px) {
    .modal-content {
        margin: 10% auto;
        width: 95%;
    }
}
</style>


@endsection
