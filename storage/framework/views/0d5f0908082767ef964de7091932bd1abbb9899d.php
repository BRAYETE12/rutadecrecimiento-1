<?php if(session()->has('error') || session()->has('success')): ?>
    <button class="c-alert">
        <?php $__currentLoopData = ['error', 'success']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(Session::has($key)): ?>
                <div class="message message-<?php echo e($key); ?>">
                    <div class="icon">
                        <?php if($key == 'success'): ?>
                            <i class="far fa-check-circle"></i>
                        <?php else: ?>
                            <i class="fas fa-exclamation-circle"></i>
                        <?php endif; ?>
                    </div>
                    <p>
                        <?php echo e(Session::get($key)); ?>

                    </p>
                    <div class="close">X</div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </button>
    <script>
        $('.c-alert').click(function (e) {
            e.preventDefault()
            $(this).fadeOut();
        });
    </script>
<?php endif; ?>
<?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/layouts/alert.blade.php ENDPATH**/ ?>