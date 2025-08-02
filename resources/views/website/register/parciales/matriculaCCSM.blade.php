<section class="w-100 hidden" id="matriculaCCSM">
    <div id="matriculaCCSMBusqueda" >
        
        <h2 class="color-2 font-w-700">Registra los datos de tu empresa</h2>
        <p class="mt-10" >
            Seleccione el método por el cual desea validar su empresa y complete el resto de información
        </p>

        <form class="row" id="matriculaCCSMForm" >
            
            <div class="col-12 col-md-6 form-group mb-3">
                <label class="form-label" for="nit">Criterio de búsqueda</label>
                <select class="form-select" id="search_type" name="search_type" required>
                    <option value="NIT">NIT</option>
                    <option value="RAZONSOCIAL">Razón social</option>
                    <option value="MATRICULA">Matrícula mercantil</option>
                </select>
            </div>

            <div class="col-12 col-md-6 form-group mb-3">
                <label class="form-label" for="search_name">Búsqueda</label>
                <input class="form-control" type="text" id="search_name" name="search_name" placeholder="Búsqueda" required />
            </div>

            <input type="hidden" id="search_nit" name="search_nit"  required />

            <div class="col-12 col-md-12 my-3">
                <button type="submit" id="matriculaCCSMBtn" class="button button-primary">BUSCAR EMPRESA</button>
                <button type="button" id="matriculaCCSMVolver" class="button button-secundary mt-3">VOLVER</button>
            </div>

        </form>
    </div>

    <div class="hidden" id="matriculaCCSMDetalle" >

        <h1 class="size-l color-2 font-w-700">Se ha encontrado un registro de su búsqueda</h1>
        <p class="mt-5">
            A continuación se muestran los datos de la empresa que coinciden con los valores ingresados. <b>Por favor valide y confirme si es correcto.</b>
        </p>

        <div class="shadow-sm p-3">
            <p class="fs-5 text-black m-0" id="busquedaResultado" >
                Razon social: <b>...</b> <br>
                Nit: <b>...</b> <br>
                Email: <b>...</b>               
            </p>
        </div>

        <div class="col-12 col-md-12 my-3">
            <button type="button" id="matriculaCCSMCorrectoBtn" class="button button-primary">
                Es correcto y deseo continuar 
            </button>
            <button type="button" id="matriculaCCSMBusquedaBtn" class="button button-secundary mt-3">
                Los datos son incorrectos
            </button>
        </div>

    </div>
</section>

<script>
    $(document).ready(function () {
    
        $('#matriculaCCSMForm').on('submit', function (e) {

            e.preventDefault();
            
            const name = $('#search_name').val();
            const type = $('#search_type').val();

            $('#screenLoader').removeClass('d-none');
            $('#errorMessage').addClass('d-none').text('');

            $.ajax({
                url: '/registro/buscar',
                method: 'POST',
                data: { search_type: type, search_name: name,  _token: '{{ csrf_token() }}' },
                success: function (response) {
                    
                    if (!response.success) {
                        return mostrarAlerta(response.mensaje);
                    }

                    $('#busquedaResultado').html(`
                        Razón social: <b>${response.nombre}</b><br>
                        NIT: <b>${response.nit}</b><br>
                        Email: <b>${response.email}</b>
                    `);

                    $("#search_nit").val(response.nit);

                    $("#matriculaCCSMBusqueda").slideUp();
                    $("#matriculaCCSMDetalle").slideDown();
                },
                error: function () {
                    mostrarAlerta("Ocurrió un error en la busqueda de la unidad.");
                },
                complete: function () {
                    $('#screenLoader').addClass('d-none');
                }
            });
        });


        $('#matriculaCCSMVolver').on('click', function () {
            $("#matriculaCCSM").slideUp();
            $("#tipoRegistro").slideDown();
        });


        $('#matriculaCCSMCorrectoBtn').on('click', function () {
            $("#matriculaCCSM").slideUp();
            $("#contacto").slideDown();
        });

        $('#matriculaCCSMBusquedaBtn').on('click', function () {
            $("#matriculaCCSMDetalle").slideUp();
            $("#matriculaCCSMBusqueda").slideDown();
        });

    });
</script>