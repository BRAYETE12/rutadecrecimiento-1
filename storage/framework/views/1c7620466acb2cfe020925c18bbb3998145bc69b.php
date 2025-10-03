
<?php $__env->startSection('header-class','without-header'); ?>
<?php $__env->startSection('title','Ruta C'); ?>
<?php $__env->startSection('description',''); ?>

<?php $__env->startSection('content'); ?>


<?php echo $__env->make('website.company.aviso_validaciondatos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div id="diagnostic">
    <div class="wrap">
        
        <h2>Hola, <b><?php echo e($company->business_name); ?></b>!.</h2>
        
        <?php if($arranquePOR == "NUEVO"): ?>
        <h1 class="size-l color-2 font-w-700"> ...ha sido validada y puede continuar el proceso de Diagnóstico de Ruta C...</h1>
        <?php endif; ?>

        <?php if($arranquePOR == "FORZADO"): ?>
        <h1  class="size-l color-2 font-w-700" >Por favor, actualiza tus datos para confirmar tu etapa empresarial.</h1>
        <?php endif; ?>

        <?php if($arranquePOR == "ANUAL"): ?>
        <h1  class="size-l color-2 font-w-700" >Ya ha pasado 1 año desde tu último diagnostico. Vamos a comprobar cuanto hemos crecido durante ese tiempo.</h1>
        <?php endif; ?>

        <?php if(!(isset($preguntas) && $preguntas != null)): ?>
            <section class="step-1">
                <p class="mt-5">A continuación debera indicar si su empresa ha obtenido ventas y responder las preguntas del diagnóstico</p>
                <ul class="mt-40">
                    <li>
                        <form id="frm_completardiagnostico" method="post" action="<?php echo e(route('company.diagnostic.saveVenta')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="anual_sales" value="1" >
                            <button class="button button-primary">Sí he tenido ventas</button>
                        </form>
                    </li>
                    <li>
                        <form id="frm_completardiagnostico" method="post" action="<?php echo e(route('company.diagnostic.saveVenta')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="anual_sales" value="0" >
                            <button class="button button-primary">No tengo ventas</button>
                        </form>
                    </li>
                </ul>
            </section>
        <?php else: ?>
            <form id="frm_completardiagnostico" method="post" action="<?php echo e(route('company.diagnostic.save')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="diagnosticoId" value="<?php echo e($diagnosticoId); ?>" />
                
                <?php $__currentLoopData = $preguntas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <section id="variable-<?php echo e($pregunta->pregunta_id); ?>" class="variable hidden">
                        <h2 class="color-2 font-w-700"><?php echo e($pregunta->pregunta_titulo); ?></h2>
                    
                        <ul style="padding:0" >  
                            <?php $__currentLoopData = $pregunta->opciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>                            
                                    <label class="radio">
                                        <input type="radio" id="variable_<?php echo e($pregunta->pregunta_id); ?>_<?php echo e($item->opcion_id); ?>" name="variable-<?php echo e($pregunta->pregunta_id); ?>" value="<?php echo e($item->opcion_id); ?>"/>
                                        <div class="info font-w-500">
                                            <?php echo e($item->opcion_variable_response); ?>

                                        </div>
                                    </label>                            
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" id="btn_diagnosticosiguiente_sinventas" class="button button-primary mt-20 button-next">Continuar</button>
                        <button type="button" class="button button-secundary mt-10 button-back">Regresar</button>
                    </section>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </form>
        <?php endif; ?>
        
    </div>
</div>
<?php if((isset($preguntas) && $preguntas != null)): ?>
<script>
    $(document).ready(function () {
            $('.button-next').click(function () {
                    pasarSiguientePreguntaDiagnostico($(this).parent().attr('id'), $(this).parent().next().attr('id'));
            });
            $('.button-back').click(function () {
                    $variable = $(this).parent().attr('id');

                    if ($variable == 'variable-4') {
                            window.location.href = "<?php echo e(route('company.diagnostic')); ?>";
                    }

                    $("#" + $variable).slideUp();

                    $before_variable = $(this).parent().prev().attr('id');
                    //console.log($before_variable);

                    $("#" + $before_variable).slideDown();
            });
            $("#frm_completardiagnostico input").change(function () {
                    pasarSiguientePreguntaDiagnostico(
                            $(this).parent().parent().parent().parent().attr('id'),
                            $(this).parent().parent().parent().parent().next().attr('id')
                            );
            });

            $('form').on('keydown', function(event) {
                    if (event.key === 'Enter' || event.keyCode === 13) {
                        event.preventDefault();
                        return false;  
                    }
            });
    });

    function pasarSiguientePreguntaDiagnostico(actualID, siguienteID) {
            $variable = actualID;
            let opcionesRespuesta = $("#" + $variable).find('input[type="radio"]');
            let seleccionado = false;
            
            opcionesRespuesta.each(function (index) {
                    if ($(this).is(':checked')) {
                            seleccionado = true;
                    }
            });

            if (seleccionado) {
                    $("#" + $variable).slideUp();
                    $next_variable = siguienteID;
                    
                    if ($next_variable !== undefined) {
                        $("#" + $next_variable).slideDown();
                    } else {
                        $('form').submit();
                    }
            } else {
                    modalValidacionDatosDiagnostico.show();
            }
    }
</script>

<script>
    $(document).ready(function () {
        $('#variable-<?php echo e($preguntas->first()->pregunta_id); ?>').removeClass('hidden');
    });
</script>

<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('website.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/company/diagnostic.blade.php ENDPATH**/ ?>