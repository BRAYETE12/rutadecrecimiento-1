<div class="w-100 hidden" id="usuario" > 
    <form class="row" id="usuarioform" >

        <div class="col-12 col-md-12 mb-4">
            <h1 class="size-xl color-2 font-w-700 text-center">
                Creación de usuario
            </h1>
            <hr>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="user_identification" class="form-label">N° de identificación</label>
            <input type="text" class="form-control" id="user_identification" name="user_identification" placeholder="N° Identificación" required>
        </div>

        <div class="col-12 col-md-6"></div>

        <div class="col-12 col-md-6 mb-3">
            <label for="user_name" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Nombres" required>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="user_lastname" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="user_lastname" name="user_lastname" placeholder="Apellidos" required>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="user_email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Correo Electrónico" required>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="user_password" class="form-label">Contraseña</label>
            <div class="input-group">
                <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Contraseña" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="fas fa-eye-slash" id="iconPassword"></i>
                </button>
            </div>
        </div>

        <div class="mt-4 text-center">
            <div class="d-flex justify-content-center">
                <a href="/" class="button button-secundary w-auto mx-1">Cancelar</a>
                <button type="submit" class="button button-primary w-auto mx-1">Continuar</button>
            </div>
            <hr>
            <a href="/ingreso" class="bnt btn-link w-auto mx-1">Iniciar sesión</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {

        $('#usuarioform').on('submit', function (e) {
            
            e.preventDefault();

            const email = $('#user_email').val().trim();

            $('#screenLoader').removeClass('d-none');
            $('#errorMessage').addClass('d-none').text('');

            $.ajax({
                url: '/registro/buscarUsuario',
                method: 'POST',
                data: { email: email, _token: '{{ csrf_token() }}' },
                success: function (response) 
                {
                    if (response.success) {
                      return mostrarAlerta(response.mensaje);
                    }

                    $('#errorMessage').addClass('d-none');
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