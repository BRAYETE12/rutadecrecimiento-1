 
<?php $__env->startSection('title','Ruta C Seleccionar'); ?>
<?php $__env->startSection('description',''); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5 mt-5">
    <div class="my-5 mt-5 d-flex flex-column" id="register">
        <div class="row mt-5 justify-content-center">
            <div class="col-12 my-2 text-center">
                <h3>Seleccione una unidad productiva para continuar</h3>
                <a href="/registro" class="button button-primary w-auto" style="float: left;">
                    Crear unidad productiva
                </a>
            </div>
        
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($company->etapa_intervencion != 'TRANSFORMADA'): ?>
                <div class="col-12 col-md-6 col-lg-4 my-2">
                    <div class="card h-100 shadow-sm company-card text-center p-3">
                        <div class="company-image-container">
                            <img 
                            src="
                                <?php if(!empty($company->logo)): ?>
                               <?php echo e(asset( $company->logo)); ?>

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
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($company->business_name); ?></h5>
                            <p class="card-text">
                                <?php if($company->unidadtipo_id != 1 && $company->unidadtipo_id != 2): ?>
                                    NIT: <?php echo e($company->nit); ?><br>
                                <?php endif; ?>
                                Etapa: <?php echo e($company->etapa->name ?? ' - '); ?>

                            </p>
                            
                            
                            <a href="/seleccionarEmpresa?unidadproductiva=<?php echo e($company->unidadproductiva_id); ?>" class="btn btn-primary">Seleccionar</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($companies->where('etapa_intervencion', 'TRANSFORMADA')->isNotEmpty()): ?>
        <div class="row mt-5 justify-content-center">
            <div class="col-12 my-2 text-center">
                <h3>Unidades productivas transformadas</h3>
            </div>
        
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($company->etapa_intervencion == 'TRANSFORMADA'): ?>
                <div class="col-12 col-md-6 col-lg-4 my-2">
                    <div class="card h-100 shadow-sm company-card text-center p-3" style="background-color: #eee;">
                        <div class="company-image-container">
                            <img 
                            src="
                                <?php if(!empty($company->logo)): ?>
                               <?php echo e(asset( $company->logo)); ?>

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
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($company->business_name); ?></h5>
                            <p class="card-text">
                                <?php if($company->unidadtipo_id != 1 && $company->unidadtipo_id != 2): ?>
                                    NIT: <?php echo e($company->nit); ?><br>
                                <?php endif; ?>
                                Etapa: <?php echo e($company->etapa->name ?? ' - '); ?>

                            </p>
                            
                            
                            <button class="btn btn-primary" disabled>Seleccionar</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<style>
/* Asegurarnos de que el contenido esté centrado y no desborde */
.container {
    max-width: 1200px; /* Ancho máximo para que el contenido esté más centrado */
}

.row {
    margin-left: 0 !important;
    margin-right: 0 !important;
    width: 100% !important;
}

/* Eliminar desbordamiento en body y html */
html, body {
    overflow-x: hidden;
    padding: 0;
    margin: 0;
    max-width: 100%;
}

/* Botón */
.button-primary {
    max-width: 100%;
}


.company-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    overflow: hidden;
    padding: 15px;
    max-width: 100%;
    box-sizing: border-box;
}

.company-image-container {
    display: flex;
    justify-content: center;
    margin-bottom: 15px;
}


.company-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    max-width: 100%;
}


.company-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}


.company-card .card-title {
    font-size: 1.1rem;
    font-weight: 600;
}


.company-card .btn-primary {
    background-color: #007bff;
    border: none;
}

.company-card .btn-primary:hover {
    background-color: #0056b3;
}


body {
    width: 100% !important;
    overflow-x: hidden !important;
}
</style>

<?php echo $__env->make('website.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/company/select_company.blade.php ENDPATH**/ ?>