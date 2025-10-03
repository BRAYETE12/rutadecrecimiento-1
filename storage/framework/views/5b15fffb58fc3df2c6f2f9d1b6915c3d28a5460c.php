<header data-step="1" data-title="Bienvenido a Ruta C" data-intro="En este menú encontrará las diferentes opciones de nuestra plataforma de clientes." style="width: 80px; overflow-y: auto;">
    <ul>
        <li>
            <a class="logo" href="<?php echo e(route('company.dashboard')); ?>">
                <img src="<?php echo e(asset('/img/commons/logo-ruta-c.svg')); ?>" alt="Ruta C">
            </a>
        </li>
        <li data-step="2" data-intro="Esta opción te permite regresar a la página principal de tu panel de cliente">
            <a class="dashboard" href="<?php echo e(route('company.dashboard')); ?>">
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="tip">Dashboard</div>
            </a>
        </li>
           <li data-step="4" data-intro="Esta opción te permite visualizar e inscribirte en los programas de Ruta C">
            <a class="programs" href="<?php echo e(route('company.programs')); ?>">
                <div class="icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <div class="tip">Programas</div>
            </a>
        </li>
        
        <li data-step="5" data-intro="Esta opción te permite visualizar las cápsulas de capacitación de Ruta C">
            <a class="capsules" href="<?php echo e(route('company.capsules')); ?>">
                <div class="icon">
                    <i class="fab fa-youtube"></i>
                </div>
                <div class="tip">Capsulas</div>
            </a>
        </li>
        
        <li data-step="5" data-intro="Esta opción te permite visualizar las cápsulas de capacitación de Ruta C">
            <a class="capsules" href="<?php echo e(route('company.historialDiagnosticos')); ?>">
                <div class="icon">
                    <i class="fa fa-history"></i>
                </div>
                <div class="tip">Historial de diagnósticos</div>
            </a>
        </li>
        
        <li data-step="3" data-intro="Esta opción te permite cambiar de empresa o registrar una nueva">
            <a class="profile" href="<?php echo e(route('company.select')); ?>">
                <div class="icon">
                    <i class="fa fa-refresh"></i>
                </div>
                <div class="tip">Cambiar de empresa</div>
            </a>
        </li>
        
        <li data-step="3" data-intro=Estamos en construcción">
            <a class="profile" href="/indicadores">
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="tip">Tablero de indicadores</div>
            </a>
        </li>
           
        <li data-step="3" data-intro="Esta opción te permite regresar, visualizar y actualizar tu perfil corporativo">
            <a class="profile" href="<?php echo e(route('company.profile')); ?>">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="tip">Perfil</div>
            </a>
        </li>

        <li data-step="6" data-intro="Esta opción te permite cerrar sesión">
            <a href="<?php echo e(route('company.logout')); ?>">
                <div class="icon">
                    <i class="fa fa-sign-out"></i>
                </div>
                <div class="tip">Salir</div>
            </a>
        </li>

    </ul>
</header>
<?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/layouts/header_company.blade.php ENDPATH**/ ?>