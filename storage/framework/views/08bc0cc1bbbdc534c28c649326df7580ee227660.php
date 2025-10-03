
<?php $__env->startSection('title',$section->seo_title); ?>
<?php $__env->startSection('description',$section->seo_description); ?>

<?php $__env->startSection('content'); ?>


<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<style>

    .evento-ho {
        width: 100%;
        max-width: 403px;
        max-height: 267px;
        box-shadow: 0px 2px 5px #0000000a, 0px 9px 28px #d9dadf8c;
        display: block;
        border-radius: 12px;
        margin: 20px;
    }

    .evento-ho > img {
        width: 100%;
        height: 43vw;
        max-height: 185px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }

    .data-evento {
        display: flex;
        width: 100%;
        padding: 7px 13px;
        height: 80px;
    }

    .fecha-evento {
        width: 130px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-right: 1px solid;
        padding-right: 7px;
    }

    .fecha-evento > div:first-child {
        font-weight: bold;
        font-size: 27px;
        color: #173E88;
        line-height: 1em;
    }

    .fecha-evento > div:last-child {
        font-size: 16px;
        color: #A9A9A9;
        text-transform: uppercase;
        letter-spacing: 0.59px;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        width: 100%;
        text-overflow: ellipsis;
    }

    .txt-evento {
        padding: 0 15px;
        display: flex;
    }

    .txt-evento > h2 {
        font-size: 16px;
        color: #173E88;
        font-weight: 600;
        letter-spacing: 0.25px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        text-overflow: ellipsis;
        margin: auto 0;
    }

    .slick-arrow{
        height: 30px;
        width: 30px;
        border-radius: 50%;
        color: white;
        background-color: #173E88;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .slick-arrow:hover{
        transform: scale(1.2);
    }

    .swiper-slide {    
        background-size: auto 100%;        
    }


    @media  screen and (min-width: 48em){
        #home .banner{
            height:660px
        }
    }
    @media  screen and (min-width: 48em){
        #home .banner ul li a .content{
            padding-right:300px;
            width:100%;
            max-width:700px
        }
    }
    @media  screen and (min-width: 48em){
        #home .banner ul li a .content h2{
            font-size:2.4rem
        }
    }

    @media  screen and (max-width: 48em){
        #home .banner ul li{
            background-position:left
        }
    }
    @media  screen and (max-width: 48em){
        #home .banner ul li a .content{
            width:90%;
            margin-right:auto;
            margin-left:auto
        }
    }

    @media (max-width: 768px) {

        #home {
            padding-top: 85px;
        }

        .banner {
            height: 250px !important;
        }
    
        .swiper-slide {
            height: 100%;
            background-size:  100% 100%!important;
        }
        
        .content.textl {
            padding: 10px;
            font-size: 14px;
        }
    }
</style>

<div id="home">
    <section class="banner swiper" tabindex="4">
        <ul class="swiper-wrapper" style="padding: 0px;">
            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="swiper-slide" style="background-image: url('<?php echo e(asset(''.$banner->image)); ?>');background-size: 100% 100%;	background-repeat: no-repeat">
                <a href="<?php echo e($banner->url); ?>" target="_blank">
                    <div class="content textl">
                        <h2><?php echo e($banner->title); ?></h2>
                        <p class="mt-10"><?php echo e($banner->description); ?></p>
                        <button class="button button-primary button-small mt-20"><?php echo e($banner->text_button); ?></button>
                    </div>
                </a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="swiper-pagination"></div>
    </section>
    
    <?php if($Eventos): ?>
    <section class="slider_eventos  margin-section">
        
        
        <h2 class="c-title-1 wrap-smaller margin-center" tabindex="5" audio-tag="seo-h1">
            Eventos
        </h2>
        <?php echo $__env->make('website.layouts.button_audio', ['target' => 'Eventos'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="wrap" style="">

            <div class="col-lg-12 d-block" id="slide" data-aos="fade-up" data-aos-delay="200">
                <?php $__currentLoopData = $Eventos->DATOS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <a class="evento-ho" href="<?php echo e($Evento->url_evento_informacion); ?>">
                    <img src="<?php echo e($Evento->img_evento_appmovil); ?>" alt="<?php echo e($Evento->txt_evento_titulo); ?>">
                    <div class="data-evento">
                        <div class="fecha-evento">
                            <div><?php echo e($Evento->dia_evento_inicio); ?></div>
                            <div><?php echo e($Evento->mes_nombre_evento_inicio); ?>

                            </div>
                        </div>
                        <div class="txt-evento">
                            <h2><?php echo e($Evento->txt_evento_titulo); ?></h2>
                        </div>
                    </div>
                </a>


                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <span class="arrow-left slick-arrow"><i class="fa fa-angle-left"></i></span>
                <span class="arrow-right slick-arrow"><i class="fa fa-angle-right"></i></span>
            </div>

        </div>

    </section>
    <?php endif; ?>

    <section class="video margin-section">
        <h2 class="c-title-1 wrap-smaller margin-center" tabindex="5" audio-tag="seo-h1">
            <?php echo e($section->h1); ?>

        </h2>
        <?php echo $__env->make('website.layouts.button_audio', ['target' => 'seo-h1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="wrap">
            <div class="play margin-center box pad-20 mt-40" tabindex="6">
                <div class="videoWrapper">
                    <iframe src="https://www.youtube.com/embed/<?php echo e(\App\helpers::getYouTubeVideoID($section->video_url)); ?>" title="Ruta C - Etapas" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
            <p class="mt-30 font-s-large" tabindex="7" audio-tag="seo-description">
                <?php echo e($section->seo_description); ?>

            </p>
            <?php echo $__env->make('website.layouts.button_audio', ['target' => 'seo-description'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <a href="<?php echo e(route('register')); ?>" class="mt-30 block">
                <button class="button button-primary margin-center" tabindex="8">Regístrate</button>
            </a>
        </div>
    </section>
    <section class="company margin-section">
        <div class="wrap wrap-small">
            <div audio-tag="histories">
                <h2 class="c-title-1 bold" tabindex="9"><?php echo e($data->histories_title); ?></h2>
                <p class="mt-20 margin-center font-s-large" tabindex="10">
                    <?php echo e($data->histories_description); ?>

                </p>
            </div>
            <?php echo $__env->make('website.layouts.button_audio', ['target' => 'histories'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <ul class="mt-40">
                <?php $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li style="background-image: url('<?php echo e(asset(''.$history->image)); ?>')" tabindex="11">
                    <a data-fancybox data-type="video" href="<?php echo e($history->video_url); ?>">
                        <div class="image"></div>
                        <div class="name">
                            <p class="font-s-medium" ><?php echo e($history->name); ?></p>
                        </div>
                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </section>
    <section class="briefcase margin-section">
        <div class="wrap wrap-medium" style="background-image: url('<?php echo e(asset(''.$data->discover_bg_image)); ?>')">
            <p tabindex="12"><?php echo e($data->discover_title); ?></p>
            <ul>
                <li>
                    <a href="<?php echo e($data->discover_button_1_url); ?>">
                        <button class="button button-primary" tabindex="13"> <?php echo e($data->discover_button_1_label); ?></button>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e($data->discover_button_2_url); ?>">
                        <button class="button button-secundary" tabindex="14"><?php echo e($data->discover_button_2_label); ?></button>
                    </a>
                </li>
            </ul>
        </div>
    </section>
</div>

<?php echo $__env->make('website.mantenimiento.modal_aviso', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
var swiper = new Swiper(".swiper", {
        loop: true,
        speed: 1000,
        autoplay: {
                delay: 60000,
                disableOnInteraction: false,
        },
        pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
                clickable: true,
        },
});
</script>


<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>

$(document).ready(function () {

        $('#slide').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                prevArrow: $(".arrow-left"),
                nextArrow: $(".arrow-right"),
                
                responsive: [
                        {
                                breakpoint: 1024,
                                settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                        infinite: true
                                }
                        },
                        {
                                breakpoint: 600,
                                settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                        infinite: true
                                }
                        },
                        {
                                breakpoint: 480,
                                settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                        infinite: true
                                }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                ]

        });
        
});

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('website.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/home.blade.php ENDPATH**/ ?>