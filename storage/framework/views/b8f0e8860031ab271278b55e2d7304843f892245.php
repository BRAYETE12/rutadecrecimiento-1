
<div class="p-4 shadow mt-3">
    <div class="row">
        <div class="col col-md">

            <div class="company-card text-center p-3">
                <div class="card-body">
                    <img height="150" style="margin: 0 auto;"
                        src="
                            <?php if(!empty($company->logo)): ?>
                            <?php echo e(asset('' . $company->logo)); ?>

                            <?php else: ?>
                                <?php if($company->unidadtipo_id == 1): ?>
                                    https://rutadecrecimiento.com/img/registro/idea_negocio.png
                                <?php elseif($company->unidadtipo_id == 2): ?>
                                    https://rutadecrecimiento.com/img/registro/informal_negocio_en_casa.png
                                <?php elseif($company->unidadtipo_id == 3): ?>
                                    https://rutadecrecimiento.com/img/registro/registrado_fuera_ccsm.png
                                <?php elseif($company->unidadtipo_id == 4): ?>
                                    https://rutadecrecimiento.com/img/registro/registrado_ccsm.png
                                <?php endif; ?>
                            <?php endif; ?>
                        " 
                        class="company-image" alt="Imagen de la empresa">
            
                
                    <h5 class="card-title pt-4"> <b><?php echo e($company->business_name); ?></b> </h5>
                    <!-- Condicional para mostrar el NIT solo para unidadtipo_id 3 o 4 -->
        <?php if($company->unidadtipo_id == 3 || $company->unidadtipo_id == 4): ?>
        <p class="card-text">NIT: <?php echo e($company->nit); ?></p>
    <?php endif; ?>
                </div>
            </div>

        </div>
        <div class="col col-md-8 d-flex align-items-center">
            <div class="w-100">
                <ul class="w-100">
                    <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
                    <li class="etapaAnimacionEntrada <?php echo e($stage->etapa_id == $company->etapa_id ? 'active' : null); ?> <?php echo e($stage->etapa_id < $company->etapa_id ? 'completed' : null); ?>" style="animation-delay: <?php echo e($stage->etapa_id - 1); ?>s; z-index: <?php echo e(99 - $stage->etapa_id); ?>;" >
                        <button data-fancybox="dialog" data-src="#stage-<?php echo e($stage->etapa_id); ?>"
                                <?php if($stage->etapa_id == 1): ?> data-step="8"
                            data-intro="Puedes hacer clic sobre las etapas para obtener mayor información" <?php endif; ?>>
                            <img src="<?php echo e(asset('img/content/'.$stage->image)); ?>" alt="Ruta C">
                            <h4 class="mayus"><?php echo e($stage->name); ?></h4>
                        </button>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <hr class="my-4" >

                <div>
                    Clasificación basada en el último diagnóstico <b>[<?php echo e($company->diagnosticos->last()->fecha_creacion); ?>]</b> con un <b>puntaje
                    de <?php echo e(number_format($company->diagnosticos->last()->resultado_puntaje, 2, ',', ',')); ?></b>.
                </div>
                
                <?php if($activarDIAGVOLUNTARIO): ?>
                 <div>¿Quieres realizar el diagnostico de madurez nuevamente? <a style="font-size: 1rem;" href="<?php echo e(route('company.diagnostic', [$company->id])); ?>">click aquí</a></div>
                <?php endif; ?>

                <a style="font-size: 1rem;" href="<?php echo e(route('company.historialDiagnosticos')); ?>">
                    Ver historial de diagnósticos
                </a>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/company/panel_inicial.blade.php ENDPATH**/ ?>