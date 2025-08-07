<section class="w-100 hidden" id="resumen">
    <form class="row mt-4" id="resumenForm" >

        <div class="col-12 mb-3" id="tipoRegistroResumen" ></div>

        <div class="col-12 mb-3">
            <div class="shadow-sm border p-3">
                <h5 class="text-center">Información del usuario</h5>
                <h6 class="text-black m-0" id="usuarioResumen"></h6>
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="shadow-sm border p-3">
                <h5 class="text-center">Información de la unidad</h5>
                <h6 class="text-black m-0" id="infoResumen"></h6>
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="shadow-sm border p-3">
                <h5 class="text-center">Información de contacto</h5>
                <h6 class="text-black m-0" id="contactoResumen"></h6>
            </div>
        </div>


        <div class="col-12 col-md-12 mb-3 form-group habeas">
            <p class="textj" tabindex="30">
                Aviso de privacidad: Con el registro de sus datos personales está manifestando su
                consentimiento previo, expreso e informado, en los términos de la Ley de Protección de Datos
                Personales en la República de Colombia, Ley 1581 de 2012 - Reglamentada mediante Decreto
                1377 de 2013, para que Cámara de Comercio de Santa Marta para el Magdalena, almacene,
                administre y utilice los datos suministrados por Usted en una base de datos de propiedad de
                Cámara de Comercio de Santa Marta para el Magdalena, la cual tiene como finalidad enviarle
                información relacionada y/o en conexión con encuestas de opinión, estadísticas, eventos,
                páginas web, ofertas de nuestros productos o cualquier otra información relacionada con
                nuestros servicios. Así mismo, Usted declara expresamente que la finalidad de la utilización
                por Cámara de Comercio de Santa Marta para el Magdalena de sus datos personales, le ha sido
                plenamente informada y autoriza de modo expreso que sus datos sean compartidos con terceros,
                debidamente autorizados por Cámara de Comercio de Santa Marta para el Magdalena.
            </p>
            <p class="textj mt-10" tabindex="31">
                El envío de esta información hace constar que el titular de la información fue informado
                acerca de las finalidades para las cuales sus datos serán tratados de manera confidencial y
                con las medidas de seguridad correspondientes.
            </p>
            <p class="textj mt-10" tabindex="32">
                Usted como titular de los datos cuenta con los siguientes derechos: acceso, actualización,
                rectificación, y supresión, éste último cuando no medie un deber legal o contractual que lo
                impida. Para ello, la Cámara de Comercio de Santa Marta para el Magdalena ha establecido los
                siguientes canales de atención: (i) correo electrónico:
                proteccion.datospersonales@ccsm.org.co; (ii) dirección física: calle 24 # 2 – 66, Santa
                Marta D.T.C.H. (iii) Teléfono (5)4209909. Para más información sobre la Política de
                Tratamiento de Información de la Entidad, puede consultar en el sitio web:
                https://www.ccsm.org.co/proteccion-de-datos-personales.html
            </p>
        </div>

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="checkbox" tabindex="22">
                <input type="checkbox" name="terms" value="1" required />
                <div>&nbsp;&nbsp;&nbsp;
                    <span>Acepta nuestra</span> <a
                        href="https://www.ccsm.org.co/proteccion-de-datos-personales.html" target="_blank"
                        tabindex="23" title="política de privacidad">política de privacidad</a> y
                    nuestros <a href="{{ env('APP_URL') . '/storage/' . App\helpers::getSettingValue(2) }}"
                        tabindex="24" target="_blank" title="terminos y condiciones">términos y
                        condiciones</a>
                </div>
            </label>
        </div>

        <div class="col-12 col-md-12 mb-3">
            <button type="button" id="resumenBtn" class="button button-primary">ENVIAR SOLICITUD</button>
            <button type="button" id="resumenVolver" class="button button-secundary mt-3">VOLVER</button>
        </div>

    </form>
</section>

<script>
    $(document).ready(function () {

        $('#resumenBtn').on('click', function () {

            if (!$('input[name="terms"]').is(':checked')) {
                return mostrarAlerta("Debes aceptar los términos y condiciones.");
            }

            $('#screenLoader').removeClass('d-none');
            ocultarAlerta();

            let tipoRegistroRUTAC = $('input[name="tipoRegistroRUTAC"]:checked').val();

            // Serializa todos los formularios y los une
            const dataUsuario = $('#usuarioform').serializeArray();      
            const dataUnidad = $('#infoUnidadForm').serializeArray();      
            const dataContacto = $('#contactoform').serializeArray();
            let dataFormal = [];            

            if(tipoRegistroRUTAC == '4' || tipoRegistroRUTAC == '3')
            {
                dataFormal = $('#matriculaFormalForm').serializeArray();
            }

            const allData = [...dataUsuario, ...dataFormal, ...dataUnidad, ...dataContacto];
            allData.push({ name: 'tipo_registro_rutac', value: tipoRegistroRUTAC });
            allData.push({ name: '_token', value: '{{ csrf_token() }}' });

            $.ajax({
                url: '/registro/store',
                method: 'POST',
                data: allData,
                success: function (response) {

                    if (!response.success) 
                    {
                        $('#screenLoader').addClass('d-none');
                        return mostrarAlerta(response.mensaje);
                    }

                    window.location.href = "/dashboard";                    
                },
                error: function () {
                    mostrarAlerta("Ocurrió un error al verificar la información.");
                    $('#screenLoader').addClass('d-none');
                }
            });

        });

        $('#resumenVolver').on('click', function () {
            $("#resumen").slideUp();
            $("#contacto").slideDown();
        });

    });
</script>

<style>
    #tipoRegistroResumen input[type="radio"],
    #infoResumen input[type="radio"] {
        display: none;
    }
    #tipoRegistroResumen img{
        height: 90px;
        margin: 0 auto;
    }
    #tipoRegistroResumen p{
        margin: 0 !important;
    }
</style>