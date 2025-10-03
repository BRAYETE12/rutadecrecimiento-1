@extends('website.layouts.main')
@section('header-class', 'without-header')
@section('title', 'Ruta C')
@section('description', '')
@section('content')
    
    <div id="register" class="container-fluid">

        <!-- Overlay de carga en pantalla completa -->
        <div id="screenLoader" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center" style="z-index: 1050;">
            <div class="text-center">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </div>

        <div id="errorMessage" class="alert alert-danger shadow d-none" role="alert">
            <span class="text-black"></span>
            <button type="button" class="btn-close" onclick="ocultarAlerta()"></button>
        </div>

        <div class="row d-flex justify-content-center">

            <div class="col-12 col-md-12">
                @include('website.register.parciales.usuario')
            </div>

            <div class="col-12 col-md-10">                
                @include('website.register.parciales.tipoRegistro')
                @include('website.register.parciales.matriculaCCSM')
                @include('website.register.parciales.matriculaFormal')
                @include('website.register.parciales.infoUnidad')
                @include('website.register.parciales.contacto')
                @include('website.register.parciales.resumen')
            </div>
        </div>
    </div>

<style>
    body{
        padding: 0 !important;
    }
    #errorMessage{
        position: fixed;
        top: 10px;
        z-index: 100;
    }

    form .row{
        display: flex;
        margin-bottom: 0;
    }
    .form-group:has(input[required]),
    .form-group:has(select[required]),
    .form-group:has(textarea[required]) {
        position: relative;
    }

    .form-group:has(input[required]) > .form-label::after,
    .form-group:has(select[required]) > .form-label::after,
    .form-group:has(textarea[required]) > .form-label::after {
        content: " *";
        color: red;
        font-weight: bold;
    }

    .input-readonly, .input-readonly:-webkit-autofill {
        pointer-events: none;
        background-color: #e9ecef !important;
        background: #e9ecef !important;
        -webkit-box-shadow: 0 0 0 50px #e9ecef inset;
    }
</style>
      
<script>

    $(document).ready(function () {

        $('#inicioBtn').on('click', function () {
            $("#inicio").slideUp();
            $("#usuario").slideDown();
        });
    });

    function mostrarAlerta(mensaje) {
        $('#errorMessage').removeClass('d-none').hide().fadeIn();
        $('#errorMessage span').text(mensaje);
    }

    function ocultarAlerta() {
        $('#errorMessage').addClass('d-none');
        $('#errorMessage span').text('');
    }

    function initselect(url, id, selector, idInit = null)
    {
        if(id)
        {
            $(selector).html('<option value="">Cargando...</option>');
            $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'id=' + id,
                    dataType: 'json',
                    cache: false,
                    success: function (result) {
                            var html = '<option value="" dia>Seleccione una opción</option>';
                            for (var i = 0; i < result.length; i++) {
                                    html += '<option value="' + result[i].id + '">' + result[i].name + '</option>';
                            }
                            $(selector).html(html);
                            if(idInit)
                                $(selector).val(idInit);
                    },
            });
        }
    }

    @if ($loguin)
        $("#usuario").addClass("hidden");
        $("#tipoRegistro").removeClass("hidden");        
    @endif

</script>

@endsection
