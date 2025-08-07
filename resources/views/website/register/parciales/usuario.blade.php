<div class="w-100" id="usuario" > 

    <div class="row">
        <div class="col-12 col-md-7 col-lg-8 d-none d-sm-block" id="bannerUsuario" ></div>
        <div class="col-12 col-md-5 col-lg-4 p-5">

            <form class="row" id="usuarioform" >

                <div class="col-12 col-md-12 mb-3">
                    <h2 class="color-2 font-w-700 text-center">
                        Registro de usuario
                    </h2>
                    <hr>
                </div>

                <div class="col-12 col-md-12 mb-3">
                    <label for="user_identification" class="form-label">N° de identificación</label>
                    <input type="text" class="form-control" id="user_identification" name="user_identification" placeholder="N° Identificación" required>
                </div>

                <div class="col-12 col-md-12 mb-3">
                    <label for="user_name" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Nombres" required>
                </div>

                <div class="col-12 col-md-12 mb-3">
                    <label for="user_lastname" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="user_lastname" name="user_lastname" placeholder="Apellidos" required>
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

<style>
    #bannerUsuario{
        background-image: url(https://app.rutadecrecimiento.com/storage/banners/BqjnTeN0WwSyFiASEOkVjIEWj7JwCuL64H5d5NPv.png);
        background-size: 100% 100%;
        background-repeat: no-repeat;
        min-height: 100vh;
    }
</style>

<script>
    $(document).ready(function () {

        $('#usuarioform').on('submit', function (e) {            
            e.preventDefault();

            $('#screenLoader').removeClass('d-none');
            ocultarAlerta();

            let data = $('#usuarioform').serializeArray();
            data.push({ name: '_token', value: '{{ csrf_token() }}' });

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
        });
        
        $('#togglePassword').on('click', function () {
            const passwordInput = $('#user_password');
            const icon = $('#iconPassword');

            const isPassword = passwordInput.attr('type') === 'password';
            passwordInput.attr('type', isPassword ? 'text' : 'password');
            
            icon.toggleClass('fa-eye fa-eye-slash');
        });

    });
</script>