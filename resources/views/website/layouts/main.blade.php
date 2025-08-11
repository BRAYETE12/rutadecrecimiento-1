<!DOCTYPE HTML>
<html lang="es">
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8"/>
        <meta name="description" content="@yield('description')"/>
        <meta name="keywords" content="@yield('keywords')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
        <meta name="robots" content="index, follow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="canonical" href="{{ URL::current() }}"/>
        @yield('meta')
        <link rel="icon" type="image/png" href="{!! URL::asset('/img/commons/favicon.png') !!}">
        <link rel="apple-touch-icon" href="{!! URL::asset('/img/commons/favicon.png') !!}">
        <link rel="stylesheet" href="{!! URL::asset('/css/style.css?v=47-07-23') !!}" type="text/css" media="screen"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        @yield('css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/01ae7d183b.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    </head>
    <body>
        <div id="page">
            @include('website.layouts.header')
            <div id="center">
                @yield('content')
            </div>
            @include('website.layouts.alert')
            @include('website.layouts.footer')
            <div class="c-controls-size">
                <button id="increase"> A+ </button>
                <button id="reduce"> A- </button>
            </div>
        </div>
        <script>
        $(document).ready(function () {
            $('#header .mobile-action').click(function (e) {
                e.preventDefault();
                $("#header .mobile-shadow").toggleClass('mobile-shadow-active');
                $("#header .menu").toggleClass('menu-active');
            });
            // button ckick
            $('#increase').click(function (e) {
                applyFontSizeChange(2);
            });
            $('#reduce').click(function (e) {
                applyFontSizeChange(-2);
            });
            // Boton para lectura de texto en voz
            $('.c-audio-action').click(function (e) {
                var target = $(this).attr('audio-target');
                var audio = document.querySelector('[audio-tag="' + target + '"]');
                var texto = audio.textContent;
                if ('speechSynthesis' in window) {
                    const synth = window.speechSynthesis;
                    const utterance = new SpeechSynthesisUtterance(texto);
                    synth.speak(utterance);
                } else {
                    alert('Navegador no compatible');
                }
            });
        });

        // Auemento y reduccion de tamaño de letra
        function applyFontSizeChange(changeAmount) {
            var allElements = $('body, body *');
            allElements = allElements.not('#increase, #reduce');
            $(allElements).each(function () {
                var currentSize = parseInt($(this).css('font-size'));
                var newSize = currentSize + changeAmount;
                $(this).css('font-size', newSize + 'px');
            });
        }
        </script>
        @yield('js')




        <!-- Google tag (gtag.js) general -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-7SF3H243L5"></script>
        <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
      dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-7SF3H243L5');
        </script>

    <!-- Google tag (gtag.js) para WWW -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-V5G1JQLRYD"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-V5G1JQLRYD');
    </script>


    <!-- Google tag (gtag.js) para subdomino APP -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4C0RHP4T19"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-4C0RHP4T19');
    </script>


<!-- Hotjar Tracking Code for https://rutadecrecimiento.com/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:6383364,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>



        <a href="https://wa.me/573218150243?text=Me%20gustaría%20saber%20........." class="whatsapp" target="_blank"> <i class="fa fa-whatsapp whatsapp-icon"></i></a>


    </body>
</html>
