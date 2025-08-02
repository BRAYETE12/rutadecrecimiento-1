<section class="w-100 hidden" id="matriculaOtras">
    <h2 class="color-2 font-w-700" tabindex="12">Estás comenzando tu ruta de crecimiento</h2>
   
    <div id="banner_info_idea">                    
        <a class="card p-3 mt-20" href="{{ asset('img/content/lead-idea-negocio.jpg') }}" target="_blank" >
            <div class="row">
                <div class="col-12 col-md-4">
                    <img src="{{ asset('img/content/lead-idea-negocio.jpg') }}" alt="">
                </div>
                <div class="col-12 col-md-8">
                    <div class="info">
                        <p>Completa el siguiente formulario y te enviaremos a tu correo algunas guías que te ayudarán a
                            consolidar tu emprendimiento.</p>
                        <span class="mt-20 italic">click para ver guía</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <form class="row mt-4" id="matriculaOtrasForm" >
                       
        <div class="col-12 col-md-12 form-group mb-3">
            <h4>Datos de su <span class="tituloSegunTipo">...........</span></h4>
        </div>

        <div class="col-12 col-md-12 form-group mb-3">
            <div class="form-group">
                <label class="form-label">Tipo de Organización *</label>
                <select class="form-select" id="tipoPersonaID" name="tipoPersonaID" required>
                    <option value="0" selected="" class="selecPersonaNatural">PERSONA NATURAL</option>
                    <!--<option value="1">Establecimentos</option>-->
                    <option value="2" class="selecPersonaJuridica">PERSONA JURÍDICA O EMPRESA</option>
                </select>
            </div>
        </div>
                        
        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label" >Nombre de su <span class="tituloSegunTipo">...........</span> * </label>
            <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Nombre" />
        </div>

        <div class="col-12 col-md-12 form-group mb-3 nit_registrado">
            <label class="form-label">Número de Identificación Tributraria [NIT] *</label>
            <input type="text" class="form-control" id="nit_registrado" name="nit_registrado" placeholder="Número de Identificación Tributraria" />
        </div>

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label">Desde cuándo tiene su <span class="tituloSegunTipo">...........</span> * </label>
            <input type="date" class="form-control" pattern="\d{4}-\d{2}-\d{2}" id="registration_date" name="registration_date" value="<?= date('Y-m-d') ?>" required />
        </div>

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label">Descripción de su <span class="tituloSegunTipo">...........</span> </label>
            <textarea class="form-control" name="description" placeholder="Descripción"></textarea>
        </div>

        <div class="col-12 col-md-12 form-group mb-3 camara_comercio">
            <label class="form-label">Seleccione la Cámara de Comercio a la que pertenece *</label>
            <select class="form-select" name="camara_comercio" required>
                <option value="0">Seleccione una opción</option>
                @foreach ($camaras as $camara)
                    <option value="{{ $camara->camaraCODIGO }}">{{ $camara->camaraNOMBRE }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-12 form-group mb-3 registration_number">
            <label class="form-label">Número de Matrícula en la Cámara Seleccionada *</label>
            <input type="text" class="form-control" placeholder="Número de Matricula" name="registration_number" />
        </div>

        <div class="col-12 col-md-12 form-group mb-3 name_legal_representative">
            <label class="form-label">Nombre del Respresentante Legal *</label>
            <input type="text" class="form-control" placeholder="Respresentante Legal" name="name_legal_representative" />
        </div>

        <div class="col-12 col-md-12">
            <hr>
            <h5>Datos de Ubicación</h5>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Seleccione un departamento *</label>
            <select class="form-select" id="department" name="department" required>
                <option value="0">Seleccione una opción</option>
                @foreach ($departamentos as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Seleccione un municipio *</label>
            <select class="form-select" id="municipality" name="municipality" required>
                <option data-depto="0">Seleccione un departamento</option>
            </select>
        </div>

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label" >Dirección *</label>
            <input type="text" class="form-control" name="address" placeholder="Dirección" required />
        </div>

        <div class="col-12 col-md-4 form-group mb-3">
            <label class="form-label" >Email *</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
        </div>
        <div class="col-12 col-md-4 form-group mb-3">
            <label class="form-label" >Celular *</label>
            <input type="text" class="form-control" name="mobile" placeholder="Celular" required/>
        </div>
        <div class="col-12 col-md-4 form-group mb-3">
            <label class="form-label" >Teléfono (opcional)</label>
            <input type="text" class="form-control" placeholder="Teléfono" name="telephone"/>
        </div>

        <div class="col-12 col-md-12">
            <hr>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Sector *</label>
            <select class="form-select" id="sector" name="sector_id" required>
                <option>Seleccione una opción</option> 
                @foreach($sectores as $item)
                    <option  value="{{$item->sector_id}}">{{$item->sectorNOMBRE}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Sección </label>
            <select class="form-select" id="seccion" name="seccion">
                <option>Seleccione un sector</option>
            </select>
        </div>

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label" >Actividad economica </label>
            <select class="form-select" id="actividad" name="ciiuactividad_id">
                <option>Seleccione una sección</option>
            </select>
        </div>

        
        <div class="col-12 col-md-12">
            <hr>
            <h5>Información adicional</h5>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >URL del Sitio Web (Opcional)</label>
            <input type="text" class="form-control" placeholder="URL del Sitio Web" name="website"/>
        </div>
        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Instagram (Opcional)</label>
            <input type="text" class="form-control" placeholder="Instagram" name="social_instagram"/>
        </div>
        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Facebook (Opcional)</label>
            <input type="text" class="form-control" placeholder="Facebook" name="social_facebook"/>
        </div>
        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >LinkedIn (Opcional)</label>
            <input type="text" class="form-control" placeholder="LinkedIn" name="social_linkedin"/>
        </div>


        <div class="col-12 col-md-12 my-3">
            <button type="submit" id="matriculaOtrasBtn" class="button button-primary"> CONTINUAR </button>
            <button type="button" id="matriculaOtrasVolver" class="button button-secundary mt-3"> VOLVER </button>
        </div>

    </form>
</section>


<script>
    $(document).ready(function () {

        $('#matriculaOtrasForm').on('submit', function (e) {

            e.preventDefault();

            $("#matriculaOtras").slideUp();
            $("#contacto").slideDown();
        });

        $('#matriculaOtrasVolver').on('click', function () {

            $("#matriculaOtras").slideUp();
            $("#tipoRegistro").slideDown();
        });


        function initselect(url, id, selector, idInit = null)
        {
            if(id)
            {
                $(selector).html('<option value="">Cargando...</option>');
                $.ajax({
                        type: 'GET',
                        url: url,
                        data: 'id=' + id,
                        dataType: 'json',
                        cache: false,
                        success: function (result) {
                                var html = '<option value="" dia>Seleccione una opción</option>';
                                for (var i = 0; i < result.length; i++) {
                                        html += '<option value="' + result[i].id + '">' + result[i].name + '</option>';
                                }
                                $(selector).html(html);
                                if(idInit)
                                    $(selector).val(idInit);
                        },
                });
            }
        }

        $('#department').on('change', function() {
            let id = $(this).val();
            initselect('/municipios/listado', id, '#municipality');
        });

        $('#sector').on('change', function () {
            // Limpiar los selects de sección y actividad
            $('#seccion').html('<option value="">Seleccione un sector</option>');
            $('#actividad').html('<option value="">Seleccione una sección</option>');
            
            // Obtener el ID del sector seleccionado y cargar las secciones correspondientes
            let id = $(this).val();
            if (id) {
                initselect('/secciones/listado', id, '#seccion');
            }
        });

        $('#seccion').on('change', function () {
            let id = $(this).val();
            initselect('/actividades/listado', id, '#actividad');
        });

    });
</script>