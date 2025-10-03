
<?php $__env->startSection('title','Ruta C Dashboard'); ?>
<?php $__env->startSection('description',''); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.1.0/introjs.min.css"/>
<style>
.slick-track{
    height: 460px;
    padding: 2rem 0;
}
.slick-prev:before, 
.slick-next:before{
    color: black !important;
    font-size: 2rem;
}
.slick-next{
  right: -15px;
}
</style>

<div class="c-dashboard">
    <?php echo $__env->make('website.layouts.header_company', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main>
        <div id="dashboard">
            <div class="wrap wrap-large">
                <div class="info">
                    <?php echo $__env->make('website.company.panel_inicial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

                    <div class="p-4">
                        <h4>
                            <b>Programas abiertos</b>
                        </h4>
                        <div class="row carrucelProgramas">

                           <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col d-flex align-items-stretch">
                                <a class="card shadow h-100 m-3" title="Ver detalles" href="<?php echo e(route('company.program.show', ['id' => $program->convocatoria_id])); ?>" >
                                                                        
                                    <img 
                                    src="<?php echo e(asset('' . $program->logo)); ?>" 
                                    class="card-img-top" 
                                    alt="<?php echo e($program->nombre); ?>" 
                                    style="object-fit: contain; width: 100%; height: 200px;">
                                                                    <div class="card-body overflow-auto">
                                        <h5 class="card-title">
                                            <b><?php echo e($program->nombre); ?></b>
                                        </h5>
                                        <div class="card-text mb-2" style="font-size: 1rem; color: black;">
                                            <?php echo $program->descripcion; ?>

                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>

                    <div class="p-4">
                        <h4>
                            <b>Teniendo en cuenta el diagnóstico de tu empresa, te recomendamos las siguientes cápsulas de capacitación</b>
                        </h4>
                        <div class="row carrucelCapculas">

                           <?php $__currentLoopData = $capsulas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capsule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col d-flex align-items-stretch">
                                <a class="h-100" href="<?php echo e($capsule->url_video); ?>" target="_blank">
                                <div class="card shadow h-100 m-3" >
                                    <img src="<?php echo e(asset( ''.$capsule->imagen )); ?>" class="card-img-top" alt="<?php echo e($capsule->nombre); ?>">
                                    <div class="card-body overflow-auto">
                                        <h5 class="card-title">
                                            
                                            <b><?php echo e($capsule->nombre); ?></b>
                                        </h5>
                                        <div class="card-text mb-2" style="font-size: 1rem; color: black;">
                                            <?php echo e($capsule->descripcion); ?>


                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.1.0/intro.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div id="stage-<?php echo e($stage->etapa_id); ?>" class="hidden c-stage-description">
    <h2 class="bold textl"><?php echo e($stage->name); ?></h2>
    <p class="mt-20"><?php echo nl2br($stage->description); ?></p>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!--una encuesta sobre el producto-->
<hr />
<hr />
<?php if($company->show_poll == 1): ?>
<div id="dashboard-company-comments" class="hidden">
    <h2 class="size-xl color-2 font-w-700">Bienvenido al Panel para empresas de Ruta C</h2>
    <h3 class="size-l color-2 font-w-700 mt-20">¡Agradecemos tu dedicación en completar el proceso de
        registro!</h3>
    <p class="mt-20">
        Si deseas puedes dejar algún comentario adicional que nos ayude a entender más aspectos sobre tu negocio
    </p>
    <form>
        <div class="row">
            <textarea class="mt-20"></textarea>
        </div>
        <ul>
            <li>
                <button data-fancybox-close class="button button-secundary">OMITIR ESTE PASO</button>
            </li>
            <li>
                <input type="submit" name="send" value="ENVIAR COMENTARIOS" class="button button-primary">
            </li>
        </ul>
    </form>
</div>


<?php ( \App\Http\Services\UnidadProductivaService::disablePoll() ); ?>
<?php endif; ?>

<?php echo $__env->make('website.layouts.helper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>    
    $('.carrucelCapculas').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        autoplaySpeed: 5000,
        autoplay: true,
        responsive: [
            {
                breakpoint: 767,
                settings: { slidesToShow: 1 }
            }
        ]
    }); 

    $('.carrucelProgramas').slick({
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        autoplaySpeed: 5000,
        autoplay: true,
        responsive: [
            {
                breakpoint: 767,
                settings: { slidesToShow: 1 }
            }
        ]
    }); 

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('website.layouts.main_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/company/dashboard.blade.php ENDPATH**/ ?>