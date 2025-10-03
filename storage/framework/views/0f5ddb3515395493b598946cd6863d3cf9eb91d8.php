
<?php $__env->startSection('title','Ruta C Dashboard'); ?>
<?php $__env->startSection('description',''); ?>

<?php $__env->startSection('content'); ?>
    <div class="c-dashboard">
        <?php echo $__env->make('website.layouts.header_company', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main>
            <div id="capsules" class="container">

                <div class="p-4 shadow bg-white mt-3">
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
                                    <p class="card-text">NIT: <?php echo e($company->nit); ?></p>
                                </div>
                            </div>
    
                        </div>
                        <div class="col col-md-8 d-flex align-items-center">
                            <div class="w-100">
    
                                <div audio-tag="info_program_info" >
                                    <h3>
                                        Te encuentras en la etapa de <b><?php echo e($nombreEtapa); ?></b>
                                    </h3>
        
                                    <hr class="my-4" >
                                    <p class="desc">
                                        Teniendo en cuenta el diagnóstico de tu empresa, te recomendamos las siguientes cápsulas de capacitación
                                    </p>
                                </div>
    
                                <?php echo $__env->make('website.layouts.button_audio', ['target' => 'info_program_info'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrap wrap-large textl">
                    
                    <ul class="mt-40">
                        <?php $__currentLoopData = $capsules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capsule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a class="h-100" href="<?php echo e($capsule->url_video); ?>" target="_blank">
                                    <div class="img" style="background-image: url('<?php echo e(asset( ''.$capsule->imagen )); ?>')"></div>
                                    <div class="info">
                                        <h2><?php echo e($capsule->nombre); ?></h2>
                                        <p>
                                            <?php echo e($capsule->descripcion); ?>

                                        </p>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </main>
        <?php echo $__env->make('website.layouts.helper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function () {
            $('header .capsules').addClass('active');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('website.layouts.main_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/capsule/index.blade.php ENDPATH**/ ?>