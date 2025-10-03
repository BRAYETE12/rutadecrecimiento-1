<!DOCTYPE HTML>
<html lang="es">
<head>
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta charset="UTF-8"/>
    <meta name="description" content="<?php echo $__env->yieldContent('description'); ?>"/>
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo e(URL::current()); ?>"/>
    <?php echo $__env->yieldContent('meta'); ?>
    <link rel="icon" type="image/png" href="<?php echo URL::asset('/img/commons/favicon.png'); ?>">
    <link rel="apple-touch-icon" href="<?php echo URL::asset('/img/commons/favicon.png'); ?>">           
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo URL::asset('/css/style.css?v=07-01-21'); ?>" type="text/css" media="screen"/>

        <?php echo $__env->yieldContent('css'); ?>
        
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/01ae7d183b.js" crossorigin="anonymous"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        
</head>
<body>
<div id="page">
    <div id="center">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php echo $__env->make('website.layouts.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php echo $__env->yieldContent('js'); ?>
<script>
    // Boton para lectura de texto en voz
    $('.c-audio-action').click(function (e) {
        var target = $(this).attr('audio-target');
        var audio = document.querySelector('[audio-tag="' + target + '"]');
        var texto = audio.textContent;

        if ('speechSynthesis' in window) {
            const synth = window.speechSynthesis;

            // Verificar si ya se está reproduciendo el mismo texto
            if (synth.speaking) {
                synth.cancel();
            } else {
                const utterance = new SpeechSynthesisUtterance(texto);
                synth.speak(utterance);
            }
        } else {
            alert('Navegador no compatible');
        }
    });
</script>







<?php echo $__env->make('website.mantenimiento.modal_aviso', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

        <a href="https://wa.me/573218150243?text=Me%20gustaría%20saber%20........." class="whatsapp" target="_blank"> <i class="fa fa-whatsapp whatsapp-icon"></i></a>
</body>
</html>
<?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/layouts/main_dashboard.blade.php ENDPATH**/ ?>