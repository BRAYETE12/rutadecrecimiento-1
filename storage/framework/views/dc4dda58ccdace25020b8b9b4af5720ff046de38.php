
<style>    
    #googleSignIn {
        font-weight: 600;
        border-radius: 8px;
    }
    
    #bannerUsuario {
        display: flex!important;
        justify-content: center; /* Centra horizontalmente */
        align-items: center;     /* Centra verticalmente */
        flex-direction: column;  /* Mantiene los elementos uno debajo del otro */
        min-height: 100vh;
        text-align: center;
        padding: 2rem;
        background: #f5fdff;
        background: linear-gradient(115deg, rgba(245, 253, 255, 1) 0%, rgba(241, 255, 235, 1) 50%, rgba(255, 249, 189, 1) 100%);
        background-size: 100% 100%;
        background-repeat: no-repeat;
        min-height: 100vh;
    }
    .bienvenida-centrada {
        max-width: 600px;
    }

</style>
<div class="w-100" id="usuario" > 

    <div class="row">
        <div class="col-12 col-md-7 col-lg-8 d-none d-sm-block" id="bannerUsuario" >
            <section class="step-1 bienvenida-centrada">
                <h1 class="size-xl color-2 font-w-700" tabindex="4">Bienvenido al proceso de registro de Ruta C</h1>
                <p class="mt-5" tabindex="5">A continuación deberá responder algunas preguntas con el objetivo de identificar el estado de su proyecto</p>
            </section>
        </div>
        <div class="col-12 col-md-5 col-lg-4 d-flex align-items-center p-5">

            <form class="row" id="usuarioform" >

                <div class="col-12 col-md-12 mb-3">
                    <h2 class="color-2 font-w-700 text-center mb-4">
                        Registro de usuario
                    </h2>
                    <div class="col-12 col-md-12 mb-3 text-center">
                        <button type="button" id="googleSignIn" class="btn btn-outline-danger w-100">
                            <i class="fab fa-google me-2"></i> Continuar con Google
                        </button>
                        <small class="d-block mt-2 text-muted">
                             Usaremos tu cuenta de Google para completar tu registro. 
                             Si ya tienes una cuenta, te llevaremos directamente al tablero de unidades productivas registradas.
                        </small>
                    </div>
                    <hr>

                </div>

                <div class="col-12 col-md-12 mb-3">
                    <label for="user_email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Correo Electrónico" required>
                </div>

                <div class="col-12 col-md-12 mb-3">
                    <label for="user_password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Contraseña" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye-slash" id="iconPassword"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12 col-md-12 mb-3">
                    <label for="como_se_entero" class="form-label">¿Cómo te enteraste de Ruta C?</label>
                    <select class="form-select" id="como_se_entero" name="como_se_entero" required>
                        <option value="">Seleccione una opción</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="correo_electronico">Correo Electrónico</option>
                        <option value="mensaje_texto">Mensaje de Texto</option>
                        <option value="llamada_telefonica">Llamada Telefónica</option>
                        <option value="redes_sociales">Redes Sociales</option>
                        <option value="evento">Evento</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <input type="hidden" name="user_id" id="user_id" >

                <div class="mt-4 text-center">
                    <div class="d-flex justify-content-center mb-3">
                        <a href="/" class="btn btn-secondary w-auto mx-1 py-2">Cancelar</a>
                        <button type="submit" class="button button-primary w-auto mx-1">Continuar</button>
                    </div>
                    <a href="/ingreso" class="bnt btn-link w-auto">
                        Iniciar sesión
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#usuarioform').on('submit', function (e) {            
            e.preventDefault();

            $('#screenLoader').removeClass('d-none');
            ocultarAlerta();

            let data = $('#usuarioform').serializeArray();
            data.push({ name: '_token', value: '<?php echo e(csrf_token()); ?>' });

            $.ajax({
                url: '/registro/validarUsuario',
                method: 'POST',
                data: data,
                success: function (response) 
                {
                    if (!response.success) {
                        $('#screenLoader').addClass('d-none');
                        return mostrarAlerta(response.mensaje);
                    }

                    if (response.mensaje) {
                       mostrarAlerta(response.mensaje);
                    }

                    registro(data);
                },
                error: function () {
                    mostrarAlerta("Ocurrió un error al verificar el usuario.");
                    $('#screenLoader').addClass('d-none');
                },
            });
        });
        
        $('#togglePassword').on('click', function () {
            const passwordInput = $('#user_password');
            const icon = $('#iconPassword');

            const isPassword = passwordInput.attr('type') === 'password';
            passwordInput.attr('type', isPassword ? 'text' : 'password');
            
            icon.toggleClass('fa-eye fa-eye-slash');
        });

        function registro(data)
        {
            $.ajax({
                url: '/registro/crearUsuario',
                method: 'POST',
                data: data,
                success: function (response) 
                {
                    if (response.existe) {
                      return mostrarAlerta(response.mensaje);
                    }

                    $("#user_id").val(response.user_id);

                    const mail = $("#user_email").val();
                    $("#registration_email").val(mail);
                    $("#contact_email").val(mail);
                    
                    $('#usuario').slideUp();
                    $('#tipoRegistro').show();
                },
                error: function () {
                    mostrarAlerta("Ocurrió un error al verificar el usuario.");
                },
                complete: function () {
                    $('#screenLoader').addClass('d-none');
                }
            });
        }

    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const select = document.getElementById('como_se_entero');
    const otroContainer = document.getElementById('otro_origen_container');
    const otroInput = document.getElementById('otro_origen');

    select.addEventListener('change', function() {
        if (select.value === 'otro') {
            otroContainer.classList.remove('d-none');
            otroInput.required = true;
        } else {
            otroContainer.classList.add('d-none');
            otroInput.required = false;
            otroInput.value = '';
        }
    });

    // Opcional: para enviar el valor escrito si selecciona "otro"
    document.getElementById('usuarioform').addEventListener('submit', function(e) {
        if (select.value === 'otro' && otroInput.value.trim() !== '') {
            select.value = otroInput.value.trim();
        }
    });
});
</script>



<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    window.onload = function () {
        const googleButton = document.getElementById("googleSignIn");
        
        googleButton.addEventListener("click", function () {
            google.accounts.id.initialize({
                client_id: "TU_CLIENT_ID_DE_GOOGLE",
                callback: handleCredentialResponse
            });

            google.accounts.id.prompt(); // muestra el cuadro de selección de cuenta
        });

        function handleCredentialResponse(response) {
            // Aquí envías el token a tu backend para verificar e iniciar sesión o registrar
            $.ajax({
                url: '/registro/googleLogin',
                method: 'POST',
                data: {
                    credential: response.credential,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(res) {
                    if (res.success) {
                        window.location.href = '/dashboard';
                    } else {
                        mostrarAlerta(res.mensaje || 'No se pudo iniciar sesión con Google');
                    }
                },
                error: function() {
                    mostrarAlerta("Error al autenticar con Google.");
                }
            });
        }
    }
</script>
<?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/register/parciales/usuario.blade.php ENDPATH**/ ?>