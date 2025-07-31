@extends('website.layouts.main')
@section('header-class', 'without-header')
@section('title', 'Ruta C')
@section('description', '')
@section('content')
    
    <div id="register" class="container">

        <!-- Overlay de carga en pantalla completa -->
        <div id="screenLoader" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center" style="z-index: 1050;">
            <div class="text-center">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </div>


        <div class="row d-flex justify-content-center">

            <!-- Alerta de error -->
            <div class="col-12 mb-3">
                <div id="errorMessage" class="alert alert-danger d-none" role="alert"></div>
            </div>

            <div class="col-12 col-md-10">

                <section id="inicio">
                    <h1 class="size-xl color-2 font-w-700">Bienvenido al proceso de registro de Ruta C</h1>
                    <p class="mt-5" >A continuación deberá responder algunas preguntas con el objetivo de identificar el estado de su proyecto</p>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="/" class="button button-secundary w-auto mx-1">Cancelar</a>
                        <button type="button" id="inicioBtn" class="button button-primary w-auto" >Iniciar proceso</button>
                    </div>
                </section>

                @include('website.register.parciales.usuario')
                @include('website.register.parciales.tipoRegistro')
                @include('website.register.parciales.matriculaCCSM')
                @include('website.register.parciales.matriculaOtras')
                @include('website.register.parciales.contacto')
                @include('website.register.parciales.resumen')
            </div>
        </div>
    </div>
      
<script>

    $(document).ready(function () {

        $('#inicioBtn').on('click', function () {
            $("#inicio").slideUp();
            $("#usuario").slideDown();
        });
    });

    function mostrarAlerta(mensaje) {
        const alerta = $('#errorMessage');
        alerta.text(mensaje).removeClass('d-none').hide().fadeIn();
    }
</script>

@endsection
