@extends('website.layouts.main')
@section('header-class', 'without-header')
@section('title', 'Ruta C')
@section('description', '')
@section('content')
    <script src="https://www.google.com/recaptcha/api.js?render=6Lf_1cgUAAAAAE2cF5IC0-s5Bhw-sfkQSHnZSP-X"></script>
    <div id="register" class="container">
        <div class="row d-flex justify-content-center">

            <div class="col-12 col-md-9">
                
                <section class="step-1">
                    <h1 class="size-xl color-2 font-w-700" tabindex="4">Bienvenido al proceso de registro de Ruta C</h1>
                    <p class="mt-5" tabindex="5">A continuación deberá responder algunas preguntas con el objetivo de
                        identificar el estado de su proyecto</p>
                    <button id="start-proccess" class="button button-primary button-small mt-20 margin-center"
                        tabindex="6">Iniciar proceso</button>
                </section>

                <section class="step-2 hidden">
                    <h2 class="color-2 font-w-700 mt-4" tabindex="7">Actualmente...</h2>

                    <h2 class="color-3 font-w-900 mb-3 mt-4">... soy una empresa o persona registrada en una cámara de
                        comercio:</h2>

                    <div class="container text-center">
                        <div class="row">
                            <div class="col_ col-xs-12 col-sm-12 col-md-6 mb-4">

                                <ul class="question-1 opcion_registro opcion_registrado_ccsm m-0 p-0 ">
                                    <li tabindex="10" class=" ">
                                        <div class="animated-border-box-glow_encendido"></div>
                                        <label class="radio animated-border-box_encendido" style="">
                                            <input type="radio" name="who" value="4" />
                                            <div class="info">
                                                <h2 class="font-w-500">Tengo un negocio registrado con domicilio en el
                                                    Magdalena</h2>
                                                <p style="font-weight: bold;">Cuento con registro activo como persona
                                                    natural o jurídica (empresa) ante la Cámara de Comercio de Santa Marta
                                                    para el Magdalena</p>
                                            </div>
                                            <div class="float-end icono_opcion_registro">
                                                <img src="{{ asset('img/registro/registrado_ccsm.png') }}"
                                                    alt="registrado_ccsm" class="" />
                                            </div>
                                        </label>
                                    </li>
                                </ul>

                            </div>

                            <div class="col_  col-xs-12 col-sm-12 col-md-6 mb-4">
                                <ul class="question-1 opcion_registro opcion_registrado_fuera  m-0 p-0 ">
                                    <li tabindex="10" style="" class="">
                                        <div class="animated-border-box-glow_encendido"></div>
                                        <label class="radio  animated-border-box_encendido" style="   border-radius: 10px;">
                                            <input type="radio" name="who" value="3" />
                                            <div class="info">
                                                <h3 class="font-w-500">Tengo un negocio registrado <strong>por fuera del
                                                        Magdalena</strong></h3>
                                                <p>Cuento con registro activo como persona natural o jurídica (empresa) ante
                                                    una Cámara de Comercio diferente a la de Santa Marta para el Magdalena
                                                </p>
                                            </div>
                                            <div class="float-end icono_opcion_registro">
                                                <img src="{{ asset('img/registro/registrado_fuera_ccsm.png') }}"
                                                    alt="registrado_fuera_ccsm" class="" />
                                            </div>
                                        </label>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>


                    <h2 class="color-3 font-w-900 mb-3 mt-4">Otras opciones para registrarse</h2>

                    <div class="container text-center">
                        <div class="row">
                            <div class="col_ col-xs-12 col-sm-12 col-md-6 mb-4">

                                <ul class="question-1 opcion_registro m-0 p-0 ">
                                    <li tabindex="8">
                                        <div class="animated-border-box-glow_encendido"></div>
                                        <label class="radio animated-border-box_encendido">
                                            <input type="radio" name="who" value="1" />
                                            <div class="info">
                                                <h3 class="font-w-500">Tengo una idea de negocio</h3>
                                                <p>No tengo ventas, no estoy registrado ante Cámara de Comercio</p>
                                            </div>
                                            <div class="float-end icono_opcion_registro">
                                                <img src="{{ asset('img/registro/idea_negocio.png') }}" alt="idea_negocio"
                                                    class="" />
                                            </div>
                                        </label>
                                    </li>
                                </ul>


                            </div>
                            <div class="col_ col-xs-12 col-sm-12 col-md-6 mb-4">

                                <ul class="question-1 opcion_registro   m-0 p-0 ">
                                    <li tabindex="9">
                                        <div class="animated-border-box-glow_encendido"></div>
                                        <label class="radio animated-border-box_encendido">
                                            <input type="radio" name="who" value="2" />
                                            <div class="info">
                                                <h3 class="font-w-500">Tengo un negocio sin registrar</h3>
                                                <p>Tengo un negocio con ventas reales y/o empleados. Sin embargo, no está
                                                    registrado o activo como persona natural o jurídica (empresa) ante la
                                                    Cámara de Comercio</p>
                                            </div>
                                            <div class="float-end icono_opcion_registro">
                                                <img src="{{ asset('img/registro/informal_negocio_en_casa.png') }}"
                                                    alt="informal_negocio_en_casa" class="" />
                                            </div>
                                        </label>
                                    </li>
                                </ul>


                            </div>
                        </div>
                    </div>
                    <div class="container mb-5">
                        <button id="continue-step-2" class="button button-primary button-small mt-20 margin-center"
                            tabindex="11">Continuar</button>
                    </div>
                </section>

                <section class="step-basic-user hidden">
                    <h2 class="color-2 font-w-700" tabindex="12">Estás comenzando tu ruta de crecimiento</h2>
                    <div id="banner_info_idea">                    
                        <a class="example mt-20" href="{{ asset('img/content/lead-idea-negocio.jpg') }}" target="_blank"
                            tabindex="13">
                            <img src="{{ asset('img/content/lead-idea-negocio.jpg') }}" alt="">
                            <div class="info">
                                <p>Completa el siguiente formulario y te enviaremos a tu correo algunas guías que te ayudarán a
                                    consolidar tu emprendimiento.</p>
                                <span class="mt-20 italic">click para ver guía</span>
                            </div>
                        </a>
                    </div>
                    <form id="frm_sinmatriculaccsm" class="mt-20" method="post" action="{{ route('register.lead') }}">
                        @csrf
                        <input id="lead-user-type" type="hidden" name="type" value="0" />
                        <input id="tipo_registro_rutac" type="hidden" name="tipo_registro_rutac" value="0" />
                        <br />
                        <hr />
                        <br />

                        <!--DATOS DE CONTACTO-->
                        <div class="row d-flex">

                            <div class="col-12 col-md-12">
                                <h4>Datos de la Persona de Contacto</h4>
                            </div>

                            <div class="col-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="tipoPersonaID">Tipo de Organización *</label>
                                    <select id="tipoPersonaID" name="tipoPersonaID" required>
                                        <option value="0" selected="" class="selecPersonaNatural">PERSONA NATURAL
                                        </option>
                                        <!--<option value="1">Establecimentos</option>-->
                                        <option value="2" class="selecPersonaJuridica">PERSONA JURÍDICA O EMPRESA
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mt-3 nombreTipoPersona nombreTipoPersonaNATURAL">
                                <div class="form-group">
                                    <label for="personaNOMBRES" class="">Nombres *</label>
                                    <input id="personaNOMBRES" type="text" name="personaNOMBRES"
                                        placeholder="Nombres" tabindex="14" required
                                        style="text-transform: uppercase;" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mt-3 nombreTipoPersona nombreTipoPersonaNATURAL">
                                <div class="form-group">
                                    <label for="personaAPELLIDOS" class="">Apellidos *</label>
                                    <input id="personaAPELLIDOS" type="text" name="personaAPELLIDOS"
                                        placeholder="Apellidos" tabindex="14" required
                                        style="text-transform: uppercase;" />
                                </div>
                            </div>

                            <div class="col-12 col-md-12 mt-3 nombreTipoPersona nombreTipoPersonaJURIDICA">
                                <div class="form-group">
                                    <label for="personaRAZONSOCIAL" class="">Razón Social *</label>
                                    <input id="personaRAZONSOCIAL" type="text" name="personaRAZONSOCIAL"
                                        placeholder="Razón Social" tabindex="14" style="text-transform: uppercase;" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="tipo_identificacion">Seleccione su tipo de identificación*</label>
                                    <select id="tipo_identificacion" name="tipo_identificacion" required>
                                        <option value="0">SELECCIONE UNO</option>
                                        @foreach ($tiposIdentificacion as $tipoIdentificacion)
                                            <option value="{{ $tipoIdentificacion->tipoIdentificacionID }}"
                                                class=" tipoIdentificacionOpciones tipoIdentificacion{{ $tipoIdentificacion->tipoIdentificacionTIPOPERSONA }}">
                                                {{ $tipoIdentificacion->tipoIdentificacionTITULO }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="document">Número de identificación *</label>
                                    <input id="document" type="text" name="document"
                                        placeholder="Número de identificación" tabindex="15" required />
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mt-3">
                                <label for="email">E-mail *</label>
                                <input id="email" type="email" name="email" placeholder="E-mail" tabindex="16"
                                    required />
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <label for="phone">Teléfono *</label>
                                <input id="phone" type="tel" name="phone" placeholder="Teléfono"
                                    tabindex="17" maxlength="15" required />
                            </div>

                        </div>

                        <br />
                        <hr />

                        <!--datos para la ubicacion del negocio o contacto-->
                        <div class="row d-flex">
                            <div class="col-12 col-md-12">
                                <h4>Datos de Ubicación</h4>
                            </div>

                            <div class="col-12 col-md-6 mt-3">
                                <label>Seleccione un departamento *</label>
                                <select id="department" name="department" required>
                                    <option value="0">SELECCIONE UNO</option>
                                    @foreach ($departamentos as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <label>Seleccione un municipio *</label>
                                <select id="municipality" name="municipality" required>
                                    <option data-depto="0">SELECCIONE UNO</option>
                                    @foreach ($municipios as $item)
                                        <option value="{{ $item->id }}" data-depto="{{ $item->departamentoID }}"
                                            style="display: none;">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-12 mt-3">
                                <label>Dirección *</label>
                                <input type="text" name="address" value="" placeholder="Dirección" required
                                    style="text-transform: uppercase;" />
                            </div>

                        </div>

                        <br />
                        <hr />

                        <div class="form-group mb-3">
                            <h4>Datos de <span class="tituloSegunTipo">...........</span></h4>
                        </div>
                        <br />
                        <div class="form-group mb-3">
                            <label>Nombre de <span class="tituloSegunTipo">...........</span> *</label>
                            <input type="text" name="business_name" placeholder="Nombre" value="" required
                                style="text-transform: uppercase;" />
                        </div>

                        <div class="form-group mb-3 nit_registrado">
                            <label for="nit_registrado">Número de Identificación Tributraria [NIT] *</label>
                            <input id="nit_registrado" type="text" placeholder="Número de Identificación Tributraria"
                                name="nit_registrado" tabindex="17" />
                        </div>

                        <div class="form-group mb-3">
                            <label>Desde cuándo tiene <span class="tituloSegunTipo">...........</span> *</label>
                            <input type="date" pattern="\d{4}-\d{2}-\d{2}" name="registration_date"
                                value="<?= date('Y-m-d') ?>" required style="text-transform: uppercase;" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Descripción de <span
                                    class="tituloSegunTipo">...........</span></label>
                            <textarea name="description" placeholder="Descripción" tabindex="18"></textarea>
                        </div>

                        <div class="form-group mb-3 camara_comercio">
                            <label for="camara_comercio">Seleccione la Cámara de Comercio a la que pertenece *</label>
                            <select id="camara_comercio" name="camara_comercio" required>
                                <option value="0">SELECCIONE UNO</option>
                                @foreach ($camaras as $camara)
                                    <option value="{{ $camara->camaraCODIGO }}">{{ $camara->camaraNOMBRE }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 registration_number">
                            <label for="registration_number">Número de Matrícula en la Cámara Seleccionada *</label>
                            <input id="registration_number" type="text" placeholder="Número de Matricula"
                                name="registration_number" tabindex="17" required />
                        </div>

                        <!--datos para el matriulado en otra camara-->
                        <div class="form-group mb-3 name_legal_representative">
                            <label for="name_legal_representative">Nombre del Respresentante Legal *</label>
                            <input id="name_legal_representative" type="text" placeholder="Respresentante Legal"
                                name="name_legal_representative" tabindex="17" required />
                        </div>
                        <br />
                        <hr />
                        <br />
                        <!--TERMINNOS-->
                        <div class="form-group habeas">
                            <p class="textj" tabindex="19">
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
                            <p class="textj mt-10" tabindex="20">
                                El envío de esta información hace constar que el titular de la información fue informado
                                acerca de las finalidades para las cuales sus datos serán tratados de manera confidencial y
                                con las medidas de seguridad correspondientes.
                            </p>
                            <p class="textj mt-10" tabindex="21">
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
                        <div class="form-group mb-3">
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

                        <div class="form-group mb-3" tabindex="25">
                            <button type="submit" class="button button-primary">ENVIAR SOLICITUD</button>
                            <button type="button" id="back-1" class="button button-secundary mt-3"
                                tabindex="26">VOLVER</button>
                        </div>

                    </form>
                </section>

                <section class="step-company hidden">
                    <h2 class="color-2 font-w-700" tabindex="27">Registra los datos de tu empresa</h2>
                    <p class="mt-10" tabindex="28">
                        Seleccione el método por el cual desea validar su empresa y complete el resto de información
                    </p>
                    <form id="frm_conmatriculaccsm" class="mt-20" method="post"
                        action="{{ route('register.search') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nit">Criterio de búsqueda</label>
                            <select name="search_type" id="search_type" tabindex="28">
                                <option value="NIT">NIT</option>
                                <option value="RAZONSOCIAL">Razón social</option>
                                <option value="MATRICULA">Matrícula mercantil</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">Búsqueda</label>
                            <input id="name" type="text" name="name" placeholder="Búsqueda"
                                tabindex="29" />
                        </div>
                        <div class="form-group habeas">
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
                        <div class="form-group mb-3">
                            <label class="checkbox">
                                <input type="checkbox" name="terms" value="1" tabindex="33" required />
                                <div>
                                    <span>Acepta nuestra</span> <a
                                        href="https://www.ccsm.org.co/proteccion-de-datos-personales.html" target="_blank"
                                        title="politica de privacidad">política de privacidad</a> y nuestros <a
                                        target="_blank" title="terminos y condiciones"
                                        href="{{ env('APP_URL') . '/storage/' . App\helpers::getSettingValue(2) }}">términos y
                                        condiciones</a>
                                </div>
                            </label>
                        </div>
                        <div class="form-group mb-3" tabindex="25">
                            <button type="submit" class="button button-primary">BUSCAR EMPRESA</button>
                            <button type="button" id="back-2" class="button button-secundary mt-3">VOLVER</button>
                        </div>
                    </form>
                </section>

                <div class="c-help-info" tabindex="36">
                    {{ App\helpers::getSettingValue(0) }}
                </div>
            </div>
        </div>
    </div>
    @include('website.mantenimiento.modal_aviso')
    <script>
        $(document).ready(function() {
            $('#start-proccess').click(function() {
                mostrarOpcionesRegistroRUTAC();
            });
            $('#back-1').click(function() {
                $(".step-basic-user").slideUp();
                mostrarOpcionesRegistroRUTAC();
            });
            $('#back-2').click(function() {
                $(".step-company").slideUp();
                mostrarOpcionesRegistroRUTAC();
            });
            $('#department').on('change', function() {
                var deptoID = $(this).val();
                $("#municipality option").hide();
                $("#municipality option[data-depto=" + deptoID + "]").show();
            });
            $('input[name="who"]').change(function() {
                console.log($(this));
                let id = $(this).val();
                console.log(id);
                mostrarFormularioSegunTipoRegistro(id);
            });
            $("#continue-step-2").on('click', function() {
                let id = $("input[name='who']:checked").val();
                if(id != undefined){
                    mostrarFormularioSegunTipoRegistro(id);
                }
            });
            $('#tipoPersonaID').on('change', function() {
                var tipoPersonaID = $(this).val();
                switch (tipoPersonaID) {
                    case "0":
                        mostrarTiposIdNaturales();
                        break;
                    case "1":
                        mostrarTiposIdJuridicas();
                        break;
                    case "2":
                        mostrarTiposIdJuridicas();
                        break;
                    default:
                        break;
                }
            });

            $('#frm_sinmatriculaccsm').submit(function(event) {
                event.preventDefault();
                grecaptcha.ready(function() {
                    grecaptcha.execute('6Lf_1cgUAAAAAE2cF5IC0-s5Bhw-sfkQSHnZSP-X', {
                        action: 'registro_sinmatricula_ccsm'
                    }).then(function(token) {
                        $('#frm_sinmatriculaccsm').prepend(
                            '<input type="hidden" name="token" value="' + token + '">');
                        $('#frm_sinmatriculaccsm').prepend(
                            '<input type="hidden" name="action" value="registro_sinmatricula_ccsm">'
                            );
                        $('#frm_sinmatriculaccsm').unbind('submit').submit();
                    });;
                });
            });

        });

        function abrirFormularioMatriculaOTRACAM() {
            //banner iniciando la ruta
            $("#banner_info_idea").slideUp();
            $(".step-basic-user").slideDown();
            $("#lead-user-type").val(2);
            $("#tipo_registro_rutac").val(3);
            $('#tipoPersonaID option').hide();
            $('#tipoPersonaID option[value="0"]').show();
            $('#tipoPersonaID option[value="0"]').attr("selected", "selected");
            $("#tipoPersonaID").change();
            $("#tipoPersonaID").attr('read-only', false);
            $(".tituloSegunTipo").html("Su Empresa");
            //Datos de Empresa Registrada en Otra Camara
            $(".camara_comercio").show();
            $(".registration_number").show();
            $(".nit_registrado").show();
            $(".name_legal_representative").show();
            $("#registration_number").attr("required", "required");
            $("#name_legal_representative").attr("required", "required");
        }


        function abrirFormularioInformal() {
            $("#banner_info_idea").slideUp();
            $(".step-basic-user").slideDown();
            $("#lead-user-type").val(1);
            $("#tipo_registro_rutac").val(2);
            $('#tipoPersonaID option').hide();
            $('#tipoPersonaID option[value="0"]').show();
            $('#tipoPersonaID option[value="0"]').attr("selected", "selected");
            $("#tipoPersonaID").change();
            $("#tipoPersonaID").attr('read-only', true);
            $(".tituloSegunTipo").html("Su Negocio");
            //Datos de Empresa Registrada en Otra Camara
            $(".camara_comercio").hide();
            $(".registration_number").hide();
            $(".nit_registrado").hide();
            $(".name_legal_representative").hide();
            $("#registration_number").removeAttr("required");
            $("#name_legal_representative").removeAttr("required");
        }

        function abrirFormularioIdea() {
            
            $("#banner_info_idea").slideDown();
            $("#lead-user-type").val(0);
            $("#tipo_registro_rutac").val(1);
            $('#tipoPersonaID option').hide();
            $('#tipoPersonaID option[value="0"]').show();
            $('#tipoPersonaID option[value="0"]').attr("selected", "selected");
            $("#tipoPersonaID").change();
            $("#tipoPersonaID").attr('read-only', true);
            $(".tituloSegunTipo").html("Su Idea de Negocio");
            //Datos de Empresa Registrada en Otra Camara
            $(".camara_comercio").hide();
            $(".registration_number").hide();
            $(".nit_registrado").hide();
            $(".name_legal_representative").hide();
            $(".step-basic-user").slideDown();
            $("#registration_number").removeAttr("required");
            $("#name_legal_representative").removeAttr("required");
        }

        function mostrarFormularioSegunTipoRegistro(tipoRegistroRUTAC) {
            $(".step-2").slideUp();
            switch (tipoRegistroRUTAC) {
                case "1":
                    abrirFormularioIdea();
                    break;
                case "2":
                    abrirFormularioInformal();
                    break;
                case "3":
                    abrirFormularioMatriculaOTRACAM();
                    break;
                case "4":
                    abrirFormularioMatriculaCCSM();
                    break;
                default:
                    break;
            }
        }

        function mostrarTiposIdNaturales() {
            $(".nombreTipoPersonaNATURAL").show();
            $(".nombreTipoPersonaJURIDICA").hide();
            $(".tipoIdentificacionOpciones").hide();
            $(".tipoIdentificacionNATURAL").show();
            //
        }

        function mostrarTiposIdJuridicas() {
            $(".nombreTipoPersonaNATURAL").hide();
            $(".nombreTipoPersonaJURIDICA").show();
            $(".tipoIdentificacionOpciones").hide();
            $(".tipoIdentificacionJURIDICA").show();
        }

        function mostrarOpcionesRegistroRUTAC() {
            $(".step-1").slideUp();
            $(".step-2").slideDown();
        }

        function abrirFormularioMatriculaCCSM() {
            $(".step-basic-user").slideUp();
            $(".step-company").slideDown();
            $("#lead-user-type").val(3);
            $("#tipo_registro_rutac").val(4);
            $('#tipoPersonaID option').hide();
            $('#tipoPersonaID option[value="0"]').show();
            $('#tipoPersonaID option[value="0"]').attr("selected", "selected");
            $("#tipoPersonaID").change();
            $("#tipoPersonaID").attr('read-only', false);
            $(".tituloSegunTipo").html("Su Empresa");
            //Datos de Empresa Registrada en Otra Camara
            $(".camara_comercio").hide();
            $(".registration_number").hide();
            $(".nit_registrado").hide();
            $(".name_legal_representative").hide();
            $("#registration_number").removeAttr("required");
            $("#name_legal_representative").removeAttr("required");



        }
    </script>
@endsection
