<section class="w-100 hidden" id="tipoRegistro" >
    <h2 class="color-2 font-w-700 mt-4">Actualmente...</h2>

    <h2 class="color-3 font-w-900 mb-3 mt-4">... soy una empresa o persona registrada en una cámara de comercio:</h2>

    <div class="text-center">
        <div class="row">
            <div class="col_ col-xs-12 col-sm-12 col-md-6 mb-4">

                <ul class="question-1 opcion_registro opcion_registrado_ccsm m-0 p-0 ">
                    <li>
                        <div class="animated-border-box-glow_encendido"></div>
                        <label class="radio animated-border-box_encendido" style="">
                            <input type="radio" name="tipoRegistroRUTAC" value="4" />
                            <div class="info">
                                <h2 class="font-w-500">Tengo un negocio registrado con domicilio en el
                                    Magdalena</h2>
                                <p style="font-weight: bold;">Cuento con registro activo como persona
                                    natural o jurídica (empresa) ante la Cámara de Comercio de Santa Marta
                                    para el Magdalena</p>
                            </div>
                            <div class="float-end icono_opcion_registro">
                                <img src="<?php echo e(asset('img/registro/registrado_ccsm.png')); ?>"
                                    alt="registrado_ccsm" class="" />
                            </div>
                        </label>
                    </li>
                </ul>

            </div>

            <div class="col_  col-xs-12 col-sm-12 col-md-6 mb-4">
                <ul class="question-1 opcion_registro opcion_registrado_fuera  m-0 p-0 ">
                    <li>
                        <div class="animated-border-box-glow_encendido"></div>
                        <label class="radio  animated-border-box_encendido" style="   border-radius: 10px;">
                            <input type="radio" name="tipoRegistroRUTAC" value="3" />
                            <div class="info">
                                <h3 class="font-w-500">Tengo un negocio registrado <strong>por fuera del
                                        Magdalena</strong></h3>
                                <p>Cuento con registro activo como persona natural o jurídica (empresa) ante
                                    una Cámara de Comercio diferente a la de Santa Marta para el Magdalena
                                </p>
                            </div>
                            <div class="float-end icono_opcion_registro">
                                <img src="<?php echo e(asset('img/registro/registrado_fuera_ccsm.png')); ?>"
                                    alt="registrado_fuera_ccsm" class="" />
                            </div>
                        </label>
                    </li>
                </ul>

            </div>
        </div>
    </div>

    <h2 class="color-3 font-w-900 mb-3 mt-4">Otras opciones para registrarse</h2>

    <div class="text-center">
        <div class="row">
            <div class="col_ col-xs-12 col-sm-12 col-md-6 mb-4">

                <ul class="question-1 opcion_registro m-0 p-0 ">
                    <li>
                        <div class="animated-border-box-glow_encendido"></div>
                        <label class="radio animated-border-box_encendido">
                            <input type="radio" name="tipoRegistroRUTAC" value="1" />
                            <div class="info">
                                <h3 class="font-w-500">Tengo una idea de negocio</h3>
                                <p>No tengo ventas, no estoy registrado ante Cámara de Comercio</p>
                            </div>
                            <div class="float-end icono_opcion_registro">
                                <img src="<?php echo e(asset('img/registro/idea_negocio.png')); ?>" alt="idea_negocio"
                                    class="" />
                            </div>
                        </label>
                    </li>
                </ul>

            </div>
            <div class="col_ col-xs-12 col-sm-12 col-md-6 mb-4">

                <ul class="question-1 opcion_registro   m-0 p-0 ">
                    <li>
                        <div class="animated-border-box-glow_encendido"></div>
                        <label class="radio animated-border-box_encendido">
                            <input type="radio" name="tipoRegistroRUTAC" value="2" />
                            <div class="info">
                                <h3 class="font-w-500">Tengo un negocio sin registrar</h3>
                                <p>Tengo un negocio con ventas reales y/o empleados. Sin embargo, no está
                                    registrado o activo como persona natural o jurídica (empresa) ante la
                                    Cámara de Comercio</p>
                            </div>
                            <div class="float-end icono_opcion_registro">
                                <img src="<?php echo e(asset('img/registro/informal_negocio_en_casa.png')); ?>"
                                    alt="informal_negocio_en_casa" class="" />
                            </div>
                        </label>
                    </li>
                </ul>


            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <a href="/" class="button button-secundary w-auto mx-1">Cancelar</a>
        <button id="tipoRegistroBtn" class="button button-primary w-auto" >Continuar</button>
    </div>
</section>

<script>
    $(document).ready(function () {

        $('#tipoRegistroBtn').on('click', function () {
           redireccionarTipoRegistro();
        });

         $('input[name="tipoRegistroRUTAC"]').change(function() {
            redireccionarTipoRegistro();
        });

        function redireccionarTipoRegistro()
        {
            let tipoRegistroRUTAC = $('input[name="tipoRegistroRUTAC"]:checked').val();

            $("#tipoRegistro").slideUp();

            $("#banner_info_idea").hide();

            $('#tipoPersonaID option').hide();
            $('#tipoPersonaID option[value="0"]').show();
            $('#tipoPersonaID option[value="0"]').attr("selected", "selected");
            $("#tipoPersonaID").change();
            $("#tipoPersonaID").attr('read-only', true);

            $('#camara_comercio').attr('disabled', false);
            $('#registration_number').attr('disabled', false);
            $('#nit_registrado').attr('disabled', false);
            $('#name_legal_representative').attr('disabled', false);

            switch (tipoRegistroRUTAC) 
            {
                case "1": abrirFormularioIdea(); break;
                case "2": abrirFormularioInformal(); break;
                case "3": abrirFormularioMatriculaOTRACAM(); break;
                case "4": abrirFormularioMatriculaCCSM(); break;
                default: break;
            }
            
        }

        function abrirFormularioMatriculaCCSM() {
            $(".tituloSegunTipo").html("Empresa");
            $("#matriculaCCSM").slideDown();
        }

        function abrirFormularioMatriculaOTRACAM() 
        {
            $(".tituloSegunTipo").html("Empresa");
            $("#matriculaFormal").slideDown();
        }


        function abrirFormularioInformal() 
        {
            $(".tituloSegunTipo").html("Idea de Negocio");
            $("#infoUnidad").slideDown();
        }

        function abrirFormularioIdea() 
        {
            $("#banner_info_idea").show();
            $(".tituloSegunTipo").html("Idea de Negocio");
            $("#infoUnidad").slideDown();
        }


    });
</script><?php /**PATH D:\Proyectos de Desarrollo\RUTAC\PROPUESTA_REGISTRO_LOGIN\rutadecrecimiento-1\resources\views/website/register/parciales/tipoRegistro.blade.php ENDPATH**/ ?>