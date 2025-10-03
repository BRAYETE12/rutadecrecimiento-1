
<?php $__env->startSection('title','Ruta C Dashboard'); ?>
<?php $__env->startSection('description',''); ?>

<?php $__env->startSection('content'); ?>
    <div class="c-dashboard">
        <?php echo $__env->make('website.layouts.header_company', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main>
            <div id="programs-show">
                <div class="resume textl">
                    <img class="logo" src="<?php echo e(asset(''.$convocatoria->programa->logo)); ?>" alt="">
                    <div audio-tag="info_program_info_show">
                        <h1 class="mt-4">
                            <?php echo e($convocatoria->programa->nombre); ?>

                        </h1>
                        <h2 class="mt-3">
                            <?php echo e($convocatoria->nombre_convocatoria); ?>

                        </h2>
                        <h4 class="mt-3">
                            Desde <b><?php echo e(\Carbon\Carbon::parse($convocatoria->fecha_apertura_convocatoria)->translatedFormat('j \d\e F \d\e Y')); ?></b> hasta  <b><?php echo e(\Carbon\Carbon::parse($convocatoria->fecha_cierre_convocatoria)->translatedFormat('j \d\e F \d\e Y')); ?></b>
                        </h4>
                        
                        <?php if($already_subscribed): ?>
                            <div class="already-subscribed mt-20">
                                <h3 class="font-w-700">Ya hay una inscripción activa</h3>
                                <span class="block mt-5 title">El estado de su inscripción es</span>
                                <span class="state font-w-700">
                                    <?php echo e($inscripcion->estado->inscripcionEstadoNOMBRE); ?>

                                </span>
                                <?php if($inscripcion->comments != null): ?>
                                    <p class="mt-20 comments">
                                        Comentarios: <?php echo e($inscripcion->comments); ?>

                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php if($can_apply): ?>
                                <?php if(isset($inscripcion) && $inscripcion->inscripcionestado_id == 3): ?>
                                    <p class="mt-20 comments">
                                        Su última solicitud no ha sido admitida. Sin embargo, puede volver a presentar su solicitud de inscripción.
                                    </p>
                                <?php endif; ?>
                                <h1 class="can-apply mt-20">Cumple con requisitos para inscripción.</h1>
                                <?php if(date('Y-m-d', strtotime($convocatoria->fecha_cierre_convocatoria)) >= date('Y-m-d')): ?>
                                    <a class="button button-primary mt-10" href="<?php echo e(route('company.program.register', [$convocatoria->convocatoria_id])); ?>">Validar e inscribirme</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                    </div>
                    <?php echo $__env->make('website.layouts.button_audio', ['target' => 'info_program_info_show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="info" audio-tag="info_program_info_show_content">
                    <div class="wrap wrap-large textl">

                        <?php if($inscripcion): ?>
                            <div class="shadow-sm p-4 mb-4">

                                <div class="row d-flex">
                                    <div class="col-12 col-md-6">

                                        <h2 style="text-align: center;"> <b>Estados del proceso</b> </h2>

                                        <div class="timeline">

                                            <?php $__currentLoopData = $inscripcion->historial()->orderBy('fecha_creacion', 'desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="timeline-event">
                                                <div class="timeline-content">
                                                    <h3><b><?php echo e($item->estado->inscripcionEstadoNOMBRE); ?></b></h3>
                                                    <p> 
                                                        <?php echo e($item->comentarios); ?>

                                                        <?php if($inscripcion->file != null): ?>
                                                            <br>
                                                            <a href="<?php echo e(Storage::url($inscripcion->file)); ?>" target="_blank" title="ver archivo adjunto">ver archivo adjunto</a>                                  
                                                        <?php endif; ?>
                                                        
                                                    </p>
                                                    <span class="date"><?php echo e($item->fecha_creacion); ?></span>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <h2>
                                            <b>Preguntas</b>
                
                                            <div style="float: right;padding-top: .2rem;">
                                                <a class="btn btn-sm py-0 btn-info"  href="/exportarPreguntasInscripcionConvocatoria/<?php echo e($inscripcion->inscripcion_id); ?>">
                                                    Exportar
                                                </a>
                                            </div>
                                        </h2>

                                        <ul class="list-group list-group-flush mt-4" style="max-height: 325px; overflow-y: auto;">
                                            <?php $__currentLoopData = $inscripcion->respuestas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold"><?php echo e($resp->requisito->requisito_titulo); ?></div>
                                                        <?php echo e($resp->value); ?>

                                                    </div>
                                                    <span class="badge bg-primary rounded-pill"><?php echo e($resp->fecha_respuesta); ?></span>
                                                </li>
                                                
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                        </ul>

                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Ver detalles del programa
                            </button>

                        <?php endif; ?>

                        <div class="collapse <?php echo e(!$inscripcion ? 'show' : ''); ?> mt-4" id="collapseExample">
                           
                            <div class="row d-flex">
                                <div class="col col-md-12 mb-4">
                                    <h2>Beneficios</h2>
                                    <p> <?php echo $convocatoria->programa->beneficios; ?> </p>
                                </div>
                                <div class="col col-md-12 mb-4">
                                    <h2>Requisitos</h2>
                                    <p> <?php echo $convocatoria->programa->requisitos; ?> </p>
                                </div>

                                <div class="col col-md-4 mb-4">
                                    <h2>Modalidad</h2>
                                    <p> <?php echo e($convocatoria->programa->es_virtual == 0 ? 'Presencial' : ($convocatoria->programa->es_virtual == 1 ? 'Virtual' : 'Presencial y Virtual')); ?> </p>
                                </div>
                                <div class="col col-md-4 mb-4">
                                    <h2>Dimensión</h2>
                                    <p> <?php echo $convocatoria->programa->determinantes; ?> </p>
                                </div>
                                <div class="col col-md-4 mb-4">
                                    <h2>Aporte</h2>
                                    <p> <?php echo $convocatoria->programa->informacion_adicional; ?> </p>
                                </div>

                                <div class="col col-md-12 mb-5">
                                    <h2>El objetivo que se desea lograr</h2>
                                    <p> <?php echo $convocatoria->programa->objetivo; ?> </p>
                                </div>

                                <div class="col col-md-6 mb-4">
                                    <h2>Duración del programa</h2>
                                    <p> <?php echo $convocatoria->programa->duracion; ?> </p>
                                </div>

                                <div class="col col-md-6 mb-4">
                                    <h2>Dirigido a</h2>
                                    <p> <?php echo $convocatoria->programa->dirigido_a; ?> </p>
                                </div>

                                
                                <?php if(!empty($convocatoria->programa->procedimiento_imagen)): ?>
                                <div class="col col-md-12 mb-5">
                                    <h2 class="text-center">Procedimiento</h2>
                                    <img class="w-100" src="<?php echo e(asset(''.$convocatoria->programa->procedimiento_imagen)); ?>" alt="">
                                </div>
                            <?php endif; ?>
                            

                                <div class="col col-md-12 mb-4">
                                    <h2>Información adicional</h2>
                                    <p> <?php echo $convocatoria->programa->herramientas_requeridas; ?> </p>
                                </div>

                                <div class="col col-md-12 mb-4">
                                    <a href="<?php echo e($convocatoria->programa->sitio_web); ?>" target="_blank">
                                        <?php echo e($convocatoria->programa->sitio_web); ?>

                                    </a>
                                </div>

                                <div class="col col-md-12 mb-4">
                                    <hr>
                                </div>


                                <div class="col col-md-12 mb-4">
                                    <h2 class="mt-40">Mayor información</h2>
                                    <ul class="links">
                                        <li>
                                            Persona de contacto
                                            <b><?php echo e($convocatoria->persona_encargada); ?></b>
                                        </li>
                                        <li>
                                            Email de contacto
                                            <b><?php echo e($convocatoria->correo_contacto); ?></b>
                                        </li>
                                        <li>
                                            Teléfono de contacto
                                            <b><?php echo e($convocatoria->telefono); ?></b>
                                        </li>
                                    </ul> 
                                </div>
                                
                            </div>
                           
                            <?php echo $__env->make('website.layouts.button_audio', ['target' => 'info_program_info_show_content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </main>
    </div>


<style>
/* Estilos generales para la línea de tiempo */
.timeline {
  position: relative;
  margin: 20px auto;
  padding: 10px;
  width: 100%;
  max-width: 800px;
  border-left: 3px solid #3498db; /* Línea vertical */
}

.timeline-event {
  position: relative;
  padding-left: 20px;
  margin-bottom: 20px;
}

.timeline-event::before {
  content: '';
  position: absolute;
  left: -5px;
  top: 43%;
  width: 20px;
  height: 20px;
  background-color: #3498db;
  border-radius: 50%;
  border: 3px solid white; /* Borde blanco para resaltar el punto */
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

/* Contenido de cada evento en la línea de tiempo */
.timeline-content {
  padding: 10px 15px;
  background-color: #f9f9f9;
  border-radius: 6px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 100%;
}

.timeline-content h3 {
  margin-top: 0;
  color: #3498db;
}

.timeline-content p {
  margin: 10px 0;
  color: #333;
}

.date {
  font-size: 12px;
  color: #888;
  display: block;
  margin-top: 10px;
  text-align: right;
}

.timeline-event:nth-child(odd) {
    padding-left: 30px; /* Desplazar los eventos impares hacia la derecha */
}

.timeline-event:nth-child(odd) .timeline-content {
    padding-left: -30px; /* Alinear contenido hacia la izquierda */
}

/* Estilos responsivos */
@media  screen and (max-width: 768px) {
  .timeline {
    padding: 10px;
  }
  
  .timeline-event {
    margin-left: 0;
  }
  
  .timeline-event::before {
    left: 50%;
    transform: translateX(-50%);
  }

  .timeline-content {
    width: 90%;
    margin-left: 0;
  }
}

</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('website.layouts.main_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/program/show.blade.php ENDPATH**/ ?>