<div id="header" class="<?php echo $__env->yieldContent('header-class'); ?>">
    <div class="wrap">
        <div class="logo">
            <a href="<?php echo e(route('home')); ?>">
                <img src="https://img.tiendasicam32.net/rutac/rutac_blanco.png" style="max-height: 70px;" alt="Ruta C" />
            </a> 
        </div>
        <button class="mobile-menu mobile-action">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"></path></svg>
            <span class="hidden">Menu</span>
        </button>
        <div class="mobile-shadow mobile-action"></div>
        <nav class="menu">
            <ul>
                <?php if(!\Illuminate\Support\Facades\Auth::user()): ?>
                    <li> 
                        <a class="button button-primary" href="<?php echo e(route('register')); ?>">
                            Regístrate en Ruta C 
                        </a>
                    </li>
                    <li>
                        <a class="button button-primary" href="<?php echo e(route('login')); ?>">
                            Iniciar sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="button button-primary" href="<?php echo e(route('company.dashboard')); ?>">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="button button-primary" href="<?php echo e(route('company.logout')); ?>">
                            Cerrar sesión
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/layouts/header.blade.php ENDPATH**/ ?>