<div class="c-helper" data-step="9" data-intro="Nuestro ayudante te dara recomendaciones y consejos">
    <?php if(count($helper_notifications) > 0): ?>
    <ul class="from-admin">
        <?php $__currentLoopData = $helper_notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <?php if($notification->url != null): ?>
            <a class="with-link" href="<?php echo e($notification->url); ?>" target="_blank">
                <h6><?php echo e($notification->titulo); ?></h6>
                <p><?php echo e($notification->descripcion); ?></p>
            </a>
            <?php else: ?>
            <a>
                <h6><?php echo e($notification->titulo); ?></h6>
                <p><?php echo e($notification->descripcion); ?></p>
            </a>
            <?php endif; ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php endif; ?>
    <button><span>C</span></button>
</div>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function () {
            $('header .dashboard').addClass('active');

            var notifications = $('.c-helper .from-admin li');
            var length = notifications.length;
            var fechaInicio = new Date(localStorage.getItem('alertas')).getTime();
            var fechaFin = new Date().getTime();
            var diff = fechaFin - fechaInicio;
            console.log(diff);
            if (diff > 86400000 ) {
                    if (length > 0) {
                            $(notifications).each(function (i) {
                                    var $li = $(this);
                                    setTimeout(function () {
                                            if (i > 0) {
                                                    //Ocultamos el LI anterior
                                                    $(".c-helper ul li:nth-child(" + i + ")").find('a').slideToggle('fast');
                                            }

                                            // Si es la ultima notificacion se ejecuta una funcion diferente
                                            i === (length - 1) ? lastNotification($li) : nextNotification($li);

                                    }, 8000 * (i + 1));

                                    localStorage.setItem('alertas', new Date());
                            });

                            function nextNotification($li) {
                                    $li.find('a').slideToggle('fast');
                            }

                            function lastNotification($li) {
                                    $li.find('a').slideToggle('fast').delay(3000).slideToggle('fast');
                            }
                    } else {
                            // Si no tienen nada agregado desde el panel administrativo, al presionar muestra el consejo por defecto
                            //click c-helper button
                            $('.c-helper button').click(function () {
                                    $('.c-helper a').slideToggle();
                            });
                    }
            }
    });
</script>
<?php $__env->stopSection(); ?>
<?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/layouts/helper.blade.php ENDPATH**/ ?>