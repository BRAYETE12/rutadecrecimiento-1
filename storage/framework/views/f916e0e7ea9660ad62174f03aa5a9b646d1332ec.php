<footer class="<?php echo $__env->yieldContent('header-class'); ?>">
    <div class="social-media">
        <ul>
            <li>
                <div class="h6 font-s-medium">Síguenos en</div>
            </li>
            <li>
                <a href="https://web.facebook.com/camcomercioSM/?_rdc=1&_rdr">
                    <img src="<?php echo e(asset('img/icons/facebook.svg')); ?>" alt="Facebook">
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/camcomerciosm/">
                    <img src="<?php echo e(asset('img/icons/instagram.svg')); ?>" alt="Instagram">
                </a>
            </li>
            <li>
                <a href="https://www.linkedin.com/company/camcomerciosm/mycompany/">
                    <img src="<?php echo e(asset('img/icons/linkedin.svg')); ?>" alt="linkedin">
                </a>
            </li>
            <li>
                <a href="https://twitter.com/i/flow/login?redirect_after_login=%2FCamComercioSM">
                    <img src="<?php echo e(asset('img/icons/twitter.svg')); ?>" alt="twitter">
                </a>
            </li>
            <li>
                <a href="https://www.youtube.com/CamaraComercioSantaMarta">
                    <img src="<?php echo e(asset('img/icons/youtube.svg')); ?>" alt="Youtube">
                </a>
            </li>
        </ul>
    </div>
    <div class="wrap wrap-medium">
        <div class="footer">
            <a href="https://www.ccsm.org" target="_blank" aria-label="Camara de comercio (opens in a new tab)">
                <img src="<?php echo e(asset(''.$footer->footer_logo_ally)); ?>" alt="Camara comercio">
            </a>
            <div class="logo">
                <img src="<?php echo e(asset(''.$footer->footer_logo_rutac)); ?>" alt="Ruta C Logo footer">
            </div>
            <div class="info">
                <ul>
                    <li class="textl">
                        <span class="font-s-small">Más información en</span>
                        <span class="block font-s-small" > <a class="font-s-small"  href="https://wa.me/<?php echo e($footer->whatsapp); ?>?text=Me%20gustar%C3%ADa%20saber%20........."><img src="<?php echo e(asset('img/icons/whatsapp.png')); ?>" alt="WhatsApp" style="max-width: 32px; float: left;" /></a> WhatsApp <?php echo e($footer->whatsapp); ?> </span>
                        <a class="font-s-small" href="https://<?php echo e($footer->footer_ally_page); ?>" target="_blank" aria-label="<?php echo e($footer->footer_ally_page); ?> (opens in a new tab)"><?php echo e($footer->footer_ally_page); ?></a>
                        <span class="block font-s-small">Llámanos a <?php echo e($footer->footer_number_contact); ?></span>
                        
                        <span class="block font-s-small">Escríbenos a <?php echo e($footer->footer_email_contact); ?></span>
                        <p class="font-s-small">Dirección: <?php echo e($footer->footer_address); ?><br /><?php echo e($footer->ubicacion_ciudad); ?></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pp mt-40">
            <ul>
                <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($link->type == 0): ?>
                        <li>
                            <a class="font-s-small"  href="<?php echo e($link->value); ?>" target="_blank" aria-label="<?php echo e($link->name); ?> (opens in a new tab)"><?php echo e($link->name); ?></a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a class="font-s-small"  href="<?php echo e(asset(''.$link->value)); ?>" target="_blank" aria-label="<?php echo e($link->name); ?> (opens in a new tab)"><?php echo e($link->name); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a class="font-s-small"  href="<?php echo e(route('site.map')); ?>" target="_blank" aria-label="Mapa de sitio (opens in a new tab)">Mapa de sitio</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/layouts/footer.blade.php ENDPATH**/ ?>