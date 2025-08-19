<section class="w-100 hidden" id="contacto">
    <h2 class="color-2 font-w-700">
        Datos de la Persona de Contacto
    </h2>

    <form class="row" id="contactoform" >
        
        <div class="col-12 col-md-12 form-group mb-3">
            <label class="form-label">Nombre completo *</label>
            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Nombres" required />
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">Cargo *</label>
            <select class="form-select" id="contact_position" name="contact_position" required>
                <option value="">Seleccione una opción</option> 
                <?php $__currentLoopData = $listaCargos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cargo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cargo->vinculoCargoTITULO); ?>"><?php echo e($cargo->vinculoCargoTITULO); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label">Sexo *</label>
            <select class="form-select" name="contact_sexo" id="contact_sexo" required>
                <option value="">Seleccione una opción</option>
                <option value="MASCULINO" >MASCULINO</option>
                <option value="FEMENINO" >FEMENINO</option>
            </select>
        </div>

        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label">E-mail *</label>
            <input type="email" class="form-control" id="contact_email"  name="contact_email" placeholder="E-mail" required />
        </div>
        <div class="col-12 col-md-6 form-group mb-3">
            <label class="form-label">Teléfono *</label>
            <input type="tel" class="form-control" id="contact_phone" name="contact_phone" placeholder="Teléfono" maxlength="15" required />
        </div>

        <div class="col-12 col-md-12 mb-3">
            <button type="submit" id="contactoMBtn" class="button button-primary">CONTINUAR</button>
            <button type="button" id="contactoMVolver" class="button button-secundary mt-3">VOLVER</button>
        </div>

    </form>
</section>

<script>
    $(document).ready(function () {

        $('#contactoform').on('submit', function (e) {            
            e.preventDefault();

            resumen();
            $("#contacto").slideUp();
            $("#resumen").slideDown();
        });

        function resumen(){
            let tipoRegistroRUTAC = $('input[name="tipoRegistroRUTAC"]:checked').val();

            if(tipoRegistroRUTAC === '4')
            {
                let unidadHTML = $('input[name="unidadSeleccionada"]:checked').closest('label').prop('outerHTML');

                $("#infoResumen").html(unidadHTML);
            }
            else
            {
                let nombre = $("#business_name").val();
                let nit = $("#nit_registrado").val(); 
                let fecha = $("#registration_date").val();

                let resumen = `Nombre: <b>${nombre}</b><br>`;
    
                if (nit && nit.trim() !== "") {
                    resumen += `NIT: <b>${nit}</b><br>`;
                }

                resumen += `Fecha inicio: <b>${fecha}</b>`;

                $('#infoResumen').html(resumen);
            }

            let typeHTML = $('input[name="tipoRegistroRUTAC"]:checked').closest('ul.question-1').prop('outerHTML');
            $("#tipoRegistroResumen").html(typeHTML);


            let user_identification = $("#user_identification").val();
            let user_name = $("#user_name").val();
            let user_lastname = $("#user_lastname").val();
            let user_email = $("#user_email").val();

            $('#usuarioResumen').html(`
                N° de identificación: <b>${user_identification}</b><br>
                Nombres: <b>${user_name} ${user_lastname}</b><br>
                Email <b>${user_email}</b>
            `);

            let contact_person = $("#contact_person").val();
            let contact_position = $("#contact_position").val();
            let contact_sexo = $("#contact_sexo").val();
            let contact_email = $("#contact_email").val();
            let contact_phone = $("#contact_phone").val();

            $('#contactoResumen').html(`
                Nombre: <b>${contact_person}</b><br>
                Cargo: <b>${contact_position}</b><br>
                Sexo: <b>${contact_sexo}</b><br>
                Email <b>${contact_email}</b><br>
                Teléfono <b>${contact_phone}</b>
            `);
        }

        $('#contactoMVolver').on('click', function () {
            let tipoRegistroRUTAC = $('input[name="tipoRegistroRUTAC"]:checked').val();

            $("#contacto").slideUp();
            $("#infoUnidad").slideDown();
        });

    });
</script><?php /**PATH D:\Proyectos de Desarrollo\RUTAC\PROPUESTA_REGISTRO_LOGIN\rutadecrecimiento-1\resources\views/website/register/parciales/contacto.blade.php ENDPATH**/ ?>