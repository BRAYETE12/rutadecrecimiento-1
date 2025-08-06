<section class="w-100 hidden" id="infoUnidad">
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

    <form class="row mt-4" id="infoUnidadForm" >
                       
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

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label">Desde cuándo tiene su <span class="tituloSegunTipo">...........</span> * </label>
            <input type="date" class="form-control" pattern="\d{4}-\d{2}-\d{2}" id="registration_date" name="registration_date" value="<?= date('Y-m-d') ?>" required />
        </div>

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label">Descripción de su <span class="tituloSegunTipo">...........</span> </label>
            <textarea class="form-control" name="description" id="description" placeholder="Descripción"></textarea>
        </div>


        <div class="col-12 col-md-12">
            <hr>
            <h5>Datos de Ubicación</h5>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Seleccione un departamento *</label>
            <select class="form-select" id="department_id" name="department_id" required>
                <option value="0">Seleccione una opción</option>
                @foreach ($departamentos as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Seleccione un municipio *</label>
            <select class="form-select" id="municipality_id" name="municipality_id" required>
                <option data-depto="0">Seleccione un departamento</option>
            </select>
        </div>

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label" >Dirección *</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Dirección" required />
        </div>

        <div class="col-12 col-md-4 form-group mb-3">
            <label class="form-label" >Email *</label>
            <input type="email" class="form-control" id="registration_email" name="registration_email" placeholder="Correo Electrónico" required>
        </div>
        <div class="col-12 col-md-4 form-group mb-3">
            <label class="form-label" >Celular *</label>
            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Celular" required/>
        </div>
        <div class="col-12 col-md-4 form-group mb-3">
            <label class="form-label" >Teléfono (opcional)</label>
            <input type="text" class="form-control" placeholder="Teléfono" name="telephone" id="telephone" />
        </div>

        <div class="col-12 col-md-12">
            <hr>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label" >Sector *</label>
            <select class="form-select" id="sector_id" name="sector_id" required>
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
            <select class="form-select" id="ciiuactividad_id" name="ciiuactividad_id">
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
            <button type="submit" id="infoUnidadBtn" class="button button-primary"> CONTINUAR </button>
            <button type="button" id="infoUnidadVolver" class="button button-secundary mt-3"> VOLVER </button>
        </div>

    </form>
</section>


<script>
    $(document).ready(function () {

        $('#infoUnidadForm').on('submit', function (e) {
            e.preventDefault();

            $("#infoUnidad").slideUp();
            $("#contacto").slideDown();
        });

        $('#infoUnidadVolver').on('click', function () {
            $("#infoUnidad").slideUp();

            let tipoRegistroRUTAC = $('input[name="tipoRegistroRUTAC"]:checked').val();

            if(tipoRegistroRUTAC === '4' || tipoRegistroRUTAC === '3')
            {
                $("#matriculaFormal").slideDown();
            }
            else{
                $("#tipoRegistro").slideDown();
            }

        });

        $('#department_id').on('change', function() {
            let id = $(this).val();
            initselect('/municipios/listado', id, '#municipality_id');
        });

        $('#sector_id').on('change', function () {
            // Limpiar los selects de sección y actividad
            $('#seccion').html('<option value="">Seleccione un sector</option>');
            $('#ciiuactividad_id').html('<option value="">Seleccione una sección</option>');
            
            // Obtener el ID del sector seleccionado y cargar las secciones correspondientes
            let id = $(this).val();
            if (id) {
                initselect('/secciones/listado', id, '#seccion');
            }
        });

        $('#seccion').on('change', function () {
            let id = $(this).val();
            initselect('/actividades/listado', id, '#ciiuactividad_id');
        });

    });
</script>