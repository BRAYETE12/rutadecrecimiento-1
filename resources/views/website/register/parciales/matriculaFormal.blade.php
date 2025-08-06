<section class="w-100 hidden" id="matriculaFormal">
        
    <form class="row" id="matriculaFormalForm">

        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label">Seleccione la Cámara de Comercio a la que pertenece *</label>
            <select class="form-select" id="camara_comercio" name="camara_comercio" required>
                <option value="0">Seleccione una opción</option>
                @foreach ($camaras as $camara)
                    <option value="{{ $camara->camaraCODIGO }}">{{ $camara->camaraNOMBRE }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label">Número de Matrícula en la Cámara Seleccionada *</label>
            <input type="text" class="form-control" placeholder="Número de Matricula" name="registration_number" id="registration_number" />
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label">Número de Identificación Tributraria [NIT] *</label>
            <input type="text" class="form-control" id="nit_registrado" name="nit_registrado" placeholder="Número de Identificación Tributraria" />
        </div>

        <div class="col-12 col-md-12 form-group mb-3 name_legal_representative">
            <label class="form-label">Nombre del Respresentante Legal *</label>
            <input type="text" class="form-control" placeholder="Respresentante Legal" name="name_legal_representative" id="name_legal_representative" />
        </div>
        

        <div class="col-12 col-md-12 my-3">
            <button type="submit" id="matriculaFormalBtn" class="button button-primary">CONTINUAR</button>
            <button type="button" id="matriculaFormalVolver" class="button button-secundary mt-3">VOLVER</button>
        </div>

    </form>
</section>

<script>
    $(document).ready(function () {
    
        $('#matriculaFormalForm').on('submit', function (e) {
            e.preventDefault();

            $("#matriculaFormal").slideUp();
            $("#infoUnidad").slideDown();            
        });

        $('#matriculaFormalVolver').on('click', function () {

            let tipoRegistroRUTAC = $('input[name="tipoRegistroRUTAC"]:checked').val();

            $("#matriculaFormal").slideUp();

            if(tipoRegistroRUTAC === '4')
            {
                $("#matriculaCCSM").slideDown();
            }
            else{
                $("#tipoRegistro").slideDown();
            }
        });

    });
</script>