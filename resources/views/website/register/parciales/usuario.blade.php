
<style>    
    .btn-outline-danger {
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid #dadce0;
        box-shadow: 0 1px 2px 0 rgba(60,64,67,.3), 0 1px 3px 1px rgba(60,64,67,.15);
        transition: all 0.2s ease;
    }
    
    .btn-outline-danger:hover {
        background: #f8f9fa;
        box-shadow: 0 1px 3px 0 rgba(60,64,67,.3), 0 4px 8px 3px rgba(60,64,67,.15);
        transform: translateY(-1px);
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
                        <a href="{{ route('google.login') }}" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center" style="gap: 10px;">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Continuar con Google
                        </a>
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
                        <option value="asesor">Asesor</option>
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
            data.push({ name: '_token', value: '{{ csrf_token() }}' });

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

