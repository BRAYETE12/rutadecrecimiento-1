<section class="w-100 hidden" id="matriculaCCSM">
    <div id="matriculaCCSMBusqueda" >
        
        <h2 class="color-2 font-w-700 my-5">
            Registra los datos de tu empresa
        </h2>

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

            <div class="col-12 col-md-12 my-3">
                <button type="submit" id="matriculaCCSMBtn" class="button button-primary">BUSCAR EMPRESA</button>
                <button type="button" id="matriculaCCSMVolver" class="button button-secundary mt-3">VOLVER</button>
            </div>


            <input type="hidden" name="identificacion" id="identificacion">

        </form>
    </div>

    <div class="hidden" id="matriculaCCSMDetalle" >

        <h1 class="size-l color-2 font-w-700">Se ha encontrado los siguientes registro de su búsqueda</h1>
        <p class="mt-5">
            A continuación se muestran los datos de la empresa que coinciden con los valores ingresados. <b>Por favor valide y confirme si es correcto.</b>
        </p>

        <div id="busquedaResultado" >
        </div>

        <div class="col-12 col-md-12 my-3">
            <button type="button" id="matriculaCCSMCorrectoBtn" class="button button-primary">
                CONTINUAR
            </button>
            <button type="button" id="matriculaCCSMBusquedaBtn" class="button button-secundary mt-3">
                VOLVER
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
            ocultarAlerta();

            $('#busquedaResultado').html('');    

            $.ajax({
                url: '/registro/buscar',
                method: 'POST',
                data: { search_type: type, search_name: name,  _token: '<?php echo e(csrf_token()); ?>' },
                success: function (response) {
                    
                    if (!response.success) {
                        return mostrarAlerta(response.mensaje);
                    }

                    response.listado.forEach(item => {
                        $('#busquedaResultado').append(`
                            <label class="unidad shadow-sm p-3 my-2 d-block border rounded position-relative" style="cursor: pointer;">
                                <input type="radio" name="unidadSeleccionada" value="${item.nit}" style="position: absolute; right: 11px; transform: scale(2);" required />
                                <p class="m-0 text-start" style="font-size: 1rem;">
                                    Razón social: <b>${item.nombre}</b><br>
                                    NIT: <b class="nit" >${item.nit}</b><br>
                                    MATRICULA: <b class="nit" >${item.matricula}</b><br>
                                    FECHA: <b class="nit" >${item.fechamatricula}</b>
                                </p>
                            </label>
                        `);                    
                    });
                    
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

            const search_nit = $('input[name="unidadSeleccionada"]:checked').val();

            if (!search_nit) {
                return mostrarAlerta("Por favor seleccione una unidad para continuar.");
            }

            $('#screenLoader').removeClass('d-none');
            ocultarAlerta();

            $.ajax({
                url: '/registro/buscar/detalles',
                method: 'POST',
                data: { search_nit: search_nit, _token: '<?php echo e(csrf_token()); ?>' },
                success: function (response) {
                    
                    if (!response.success) {
                        return mostrarAlerta(response.mensaje);
                    }

                    for(let input in response.datos){
                        $("#"+input).val(response.datos[input]);
                    }

                    initselect('/municipios/listado', response.datos.department_id , '#municipality_id', response.datos.municipality_id);
                    initselect('/secciones/listado', response.datos.sector_id, '#seccion', response.datos.seccion);
                    initselect('/actividades/listado', response.datos.seccion, '#ciiuactividad_id', response.datos.ciiuactividad_id);
                    
                    $("#matriculaCCSM").slideUp();
                    $("#matriculaFormal").slideDown();
                },
                error: function () {
                    mostrarAlerta("Ocurrió un error en la busqueda de la unidad.");
                },
                complete: function () {
                    $('#screenLoader').addClass('d-none');
                }
            });
        });

        $('#matriculaCCSMBusquedaBtn').on('click', function () {
            $("#matriculaCCSMDetalle").slideUp();
            $("#matriculaCCSMBusqueda").slideDown();
        });

    });
</script><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/register/parciales/matriculaCCSM.blade.php ENDPATH**/ ?>