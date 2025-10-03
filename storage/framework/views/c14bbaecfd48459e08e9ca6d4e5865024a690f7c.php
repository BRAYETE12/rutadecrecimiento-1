
<?php $__env->startSection('title', 'Ruta C Dashboard'); ?>
<?php $__env->startSection('descripcion', ''); ?>

<?php $__env->startSection('content'); ?>
<div class="c-dashboard">
    <?php echo $__env->make('website.layouts.header_company', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main class="bg-light">

        <div id="programs" class="container">

            <div class="p-4 shadow bg-white mt-3">
                <div class="row">
                    <div class="col col-md">

                        <div class="company-card text-center p-3">
                            <div class="card-body">
                                <img height="150" style="margin: 0 auto;"
                                    src="
                                        <?php if(!empty($unidadProductiva->logo)): ?>
                                           <?php echo e(asset( $unidadProductiva->logo)); ?>

                                        <?php else: ?>
                                            <?php if($unidadProductiva->unidadtipo_id == 1): ?>
                                                https://rutadecrecimiento.com/img/registro/idea_negocio.png
                                            <?php elseif($unidadProductiva->unidadtipo_id == 2): ?>
                                                https://rutadecrecimiento.com/img/registro/informal_negocio_en_casa.png
                                            <?php elseif($unidadProductiva->unidadtipo_id == 3): ?>
                                                https://rutadecrecimiento.com/img/registro/registrado_fuera_ccsm.png
                                            <?php elseif($unidadProductiva->unidadtipo_id == 4): ?>
                                                https://rutadecrecimiento.com/img/registro/registrado_ccsm.png
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    " 
                                    class="company-image" alt="Imagen de la empresa">
                        
                            
                                <h5 class="card-title pt-4"> <b><?php echo e($unidadProductiva->business_name); ?></b> </h5>
                                <p class="card-text">NIT: <?php echo e($unidadProductiva->nit); ?></p>
                            </div>
                        </div>

                    </div>
                    <div class="col col-md-8 d-flex align-items-center">
                        <div class="w-100" >

                            <div audio-tag="info_program_info" >
                                <h3>
                                    Te encuentras en la etapa de <b><?php echo e($nombreEtapa); ?></b>
                                </h3>
    
                                <hr class="my-4" >
                                <p class="desc">
                                    Teniendo en cuenta el diagnóstico de tu empresa, puedes visualizar todos los programas pero solo podrás aplicar a los que cumplan con tu nivel de calificación.
                                </p>
    
                            </div>

                            <?php echo $__env->make('website.layouts.button_audio', ['target' => 'info_program_info'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">

                <?php if($programas_inscrito): ?>
                    <div class="container text-center mb-4">

                        <div class="row justify-content-center">

                            <div class="col-12">
                                <h1 class="display-1 mb-3">Estás inscrito en....</h1>
                            </div>

                            <?php $__currentLoopData = $programas_inscrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col mb-4">
                                    <ul>
                                        <li audio-tag="info_program_li_<?php echo e($key); ?>">
                                            <a href="<?php echo e(route('company.program.show', ['id' => $program->convocatoria_id])); ?>" class="tarjeta_info_programa">
                                                <?php if(date('Y-m-d', strtotime($program->fecha_cierre_convocatoria)) >= date('Y-m-d')): ?>
                                                    <h3>Registrado</h3>
                                                <?php else: ?>
                                                    <h3>Registrado - Cerrado el <?php echo e(date('Y-m-d', strtotime($program->fecha_cierre_convocatoria))); ?></h3>
                                                <?php endif; ?>
                                                <div class="logo">
                                                    <img src="<?php echo e(asset('/' . $program->programa->logo)); ?>" alt="">
                                                </div>
                                                <div class="info" style="max-height: 300px; overflow-y: auto;">
                                                    <div class="title">
                                                        <h2>
                                                            <?php echo e($program->programa->nombre); ?> <br>
                                                            <small><?php echo e($program->nombre); ?></small>
                                                        </h2>
                                                    </div>
                                                    <div class="text-dark">
                                                        <?php echo $program->programa->descripcion; ?>

                                                    </div>
                                                    <div class="more">Ver más información</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="container text-center mb-4">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="alert alert-success" role="alert">
                                    <h1 class="alert-heading">¡Inscríbete en nuestros programas!</h1>
                                    <p>Aún no estás inscrito en nuestros programas. Te invitamos a explorar nuestro catálogo de programas habilitados para ti.</p>
                                    <hr>
                                    <p class="mb-0 small">Si necesitas más información, no dudes en contactarnos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="mt-3">

                <div class="container text-center mb-4">
    
                    <div class="row justify-content-center">

                        <div class="col-12">
                            <h1 class="display-1 mb-3">Te recomendamos inscribirte en.....</h1>
                        </div>  

                        <?php $__currentLoopData = $programs_recommend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($noencontrado = true); ?>
                            <?php $__currentLoopData = $programas_inscrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $program2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($program->convocatoria_id == $program2->convocatoria_id): ?>
                                    <?php ($noencontrado = false); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                            <?php if($noencontrado): ?>
                                <div class="col mb-4">
                                    <ul>
                                        <li audio-tag="info_program_li_<?php echo e($key); ?>">
                                            <a href="<?php echo e(route('company.program.show', [$program->convocatoria_id])); ?>" class="tarjeta_info_programa">
                                                <h3>Recomendado</h3>
                                                <div class="logo">
                                                    <img src="<?php echo e(asset(''.$program->programa->logo)); ?>" alt="">
                                                </div>
                                                <div class="info" style="max-height: 300px; overflow-y: auto;">
                                                    <div class="title"> 
                                                        <h2>
                                                            <?php echo e($program->programa->nombre); ?> <br>
                                                            <small><?php echo e($program->nombre); ?></small>
                                                        </h2>
                                                    </div>
                                                    <div class="text-dark">
                                                        <?php echo $program->programa->descripcion; ?>

                                                    </div>
                                                    <div class="more">Ver más información</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

            </div>

            <div class="mt-3">
                <div class="container text-center mb-4">

                    <div class="row justify-content-center">
                        <div class="col-12 mb-3">
                            <h1 class="display-1">...Más programas de otras etapas.</h1>
                        </div>
                    </div>
                    
                    <!-- Otros programas -->
                    <div class="row justify-content-center mt-3">
                        <?php $__currentLoopData = $programas_otros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            <?php ($noencontrado = true); ?>
                            <?php $__currentLoopData = $programas_inscrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $program2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
                                <?php if( $program->convocatoria_id == $program2->convocatoria_id ): ?>
                                    <?php ($noencontrado = false); ?>
                                <?php endif; ?>                                                                        
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <?php if($noencontrado): ?> 
                            <div class="col mb-4">
                                <ul class="">
                                    <li audio-tag="info_program_li_<?php echo e($key); ?>" class="">
                                        <a href="<?php echo e(route('company.program.show', [$program->convocatoria_id])); ?>" class="tarjeta_info_programa">                                    
                                            <div class="logo">
                                                <img src="<?php echo e(asset($program->programa->logo )); ?>" alt="">
                                            </div>
                                            <div class="info" style="max-height: 300px; overflow-y: auto;">
                                                <div class="title">
                                                    <h2>
                                                        <?php echo e($program->programa->nombre); ?> <br>
                                                        <small><?php echo e($program->nombre); ?></small>
                                                    </h2>
                                                </div>
                                                <div class="text-dark">
                                                    <?php echo $program->programa->descripcion; ?>

                                                </div>
                                                <div class="more">Ver más información</div>
                                            </div>
                                        </a>
                                        <!--<?php echo $__env->make('website.layouts.button_audio', ['target' => 'info_program_li_'.$key], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>-->
                                    </li>
                                </ul>
                            </div>         
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                
             

                 

                </div>
            </div>

        </div>
        
    </main>
    <?php echo $__env->make('website.layouts.helper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>


<style>
    .tarjeta_info_programa{
        background: white !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script>
    $(document).ready(function () {
        $('header .programs').addClass('active');
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('website.layouts.main_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/program/index.blade.php ENDPATH**/ ?>