
<?php $__env->startSection('title','Ruta C Dashboard'); ?>
<?php $__env->startSection('description',''); ?>

<?php $__env->startSection('content'); ?>

    <div class="info c-dashboard">
        <?php echo $__env->make('website.layouts.header_company', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main>
            <div id="dashboard" class="container" >

                <div class="p-3 shadow bg-white mt-3">
                    <div class="row">
                        <div class="col col-md">
    
                            <div class="company-card text-center p-3">
                                <div class="card-body">
                                    <img height="100" style="margin: 0 auto;"
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
                            
                                
                                    <h5 class="card-title pt-4"> <b><?php echo e($company->business_name); ?></b> </h5>
                                    <p class="card-text">NIT: <?php echo e($company->nit); ?></p>
                                </div>
                            </div>
    
                        </div>
                        <div class="col col-md-8 d-flex align-items-center">
                            <div class="w-100" >
    
                                <div audio-tag="info_program_info" >
                                    <h3>
                                        <b>Historial de diagnósticos</b>
                                    </h3>
        
                                    <hr class="my-4" >
                                    <p class="desc">
                                        
                                    </p>
        
                                </div>
    
                                <?php echo $__env->make('website.layouts.button_audio', ['target' => 'info_program_info'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-3 shadow bg-white mt-3">
                    <div class="row" >
                    
                        <div class="col-12 col-md-6">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold">Fecha</th>
                                            <th class="fw-bold">Puntaje</th>
                                            <th class="fw-bold">Etapa</th>
                                            <th class="fw-bold">Acciones</th> <!-- Añadido para describir la columna de acciones -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $company->diagnosticos()->orderBy('fecha_creacion', 'desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($Diag->fecha_creacion); ?></td>
                                            <td><?php echo e($Diag->resultado_puntaje); ?></td>
                                            <td><?php echo e($Diag->etapa->name ?? 'Etapa no definida'); ?></td>
                                            <td>
                                                <a class="btn btn-link" href="/historialDiagnosticos/<?php echo e($Diag->resultado_id); ?>">
                                                    Detalles
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <br><br>          
                            <?php echo $__env->make('website.company.barra_historicos_diagnosticos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                        </div>

                        <div class="col-12 text-center mt-4">

                            <a class="btn btn-link" href="/dashboard" class="btn btn-primary">
                                Regresar al Dashboard
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('website.layouts.main_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/company/historial_diagnosticos.blade.php ENDPATH**/ ?>