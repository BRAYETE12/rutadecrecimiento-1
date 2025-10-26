@extends('website.layouts.main') 
@section('title','Ruta C Seleccionar')
@section('description','')

@section('content')
<div class="container my-5 mt-5">
    <div class="my-5 mt-5 d-flex flex-column" id="register">
        <div class="row mt-5 justify-content-center">
            <div class="col-12 my-2 text-center">
                @if($companies->where('etapa_intervencion', '!=', 'TRANSFORMADA')->isEmpty())
                    <h3>Cree su primera unidad productiva</h3>
                @else
                    <h3>Seleccione una unidad productiva para continuar</h3>
                @endif
                <a href="/registro" class="button button-primary w-auto" style="float: left;">
                    Crear unidad productiva
                </a>
            </div>
        
            @foreach($companies as $company)
                @if($company->etapa_intervencion != 'TRANSFORMADA')
                <div class="col-12 col-md-6 col-lg-4 my-2">
                    <div class="card h-100 shadow-sm company-card text-center p-3">
                        <div class="company-image-container">
                            <img 
                            src="
                                @if(!empty($company->logo))
                               {{ asset( $company->logo) }}
                                @else
                                    @if($company->unidadtipo_id == 1)
                                        https://rutadecrecimiento.com/img/registro/idea_negocio.png
                                    @elseif($company->unidadtipo_id == 2)
                                        https://rutadecrecimiento.com/img/registro/informal_negocio_en_casa.png
                                    @elseif($company->unidadtipo_id == 3)
                                        https://rutadecrecimiento.com/img/registro/registrado_fuera_ccsm.png
                                    @elseif($company->unidadtipo_id == 4)
                                        https://rutadecrecimiento.com/img/registro/registrado_ccsm.png
                                    @endif
                                @endif
                            " 
                            class="company-image" alt="Imagen de la empresa">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$company->business_name}}</h5>
                            <p class="card-text">
                                @if($company->unidadtipo_id != 1 && $company->unidadtipo_id != 2)
                                    NIT: {{$company->nit}}<br>
                                @endif
                                Etapa: {{$company->etapa->name ?? ' - '}}
                            </p>
                            
                            
                            <a href="/seleccionarEmpresa?unidadproductiva={{$company->unidadproductiva_id}}" class="btn btn-primary">Seleccionar</a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        @if($companies->where('etapa_intervencion', 'TRANSFORMADA')->isNotEmpty())
        <div class="row mt-5 justify-content-center">
            <div class="col-12 my-2 text-center">
                <h3>Unidades productivas transformadas</h3>
            </div>
        
            @foreach($companies as $company)
                @if($company->etapa_intervencion == 'TRANSFORMADA')
                <div class="col-12 col-md-6 col-lg-4 my-2">
                    <div class="card h-100 shadow-sm company-card text-center p-3" style="background-color: #eee;">
                        <div class="company-image-container">
                            <img 
                            src="
                                @if(!empty($company->logo))
                               {{ asset( $company->logo) }}
                                @else
                                    @if($company->unidadtipo_id == 1)
                                        https://rutadecrecimiento.com/img/registro/idea_negocio.png
                                    @elseif($company->unidadtipo_id == 2)
                                        https://rutadecrecimiento.com/img/registro/informal_negocio_en_casa.png
                                    @elseif($company->unidadtipo_id == 3)
                                        https://rutadecrecimiento.com/img/registro/registrado_fuera_ccsm.png
                                    @elseif($company->unidadtipo_id == 4)
                                        https://rutadecrecimiento.com/img/registro/registrado_ccsm.png
                                    @endif
                                @endif
                            " 
                            class="company-image" alt="Imagen de la empresa">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$company->business_name}}</h5>
                            <p class="card-text">
                                @if($company->unidadtipo_id != 1 && $company->unidadtipo_id != 2)
                                    NIT: {{$company->nit}}<br>
                                @endif
                                Etapa: {{$company->etapa->name ?? ' - '}}
                            </p>
                            
                            
                            <button class="btn btn-primary" disabled>Seleccionar</a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Modal para completar registro -->
@if($show_complete_registration_modal)
<div class="modal fade" id="completeRegistrationModal" tabindex="-1" aria-labelledby="completeRegistrationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeRegistrationModalLabel">Completar Registro</h5>
            </div>
            <div class="modal-body">
                <p class="mb-3">Para continuar, necesitamos saber cómo te enteraste de Ruta C:</p>
                <form id="completeRegistrationForm">
                    @csrf
                    <div class="mb-3">
                        <label for="como_se_entero" class="form-label">¿Cómo te enteraste de Ruta C?</label>
                        <select class="form-select" id="como_se_entero" name="como_se_entero" required>
                            <option value="">Seleccione una opción</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="correo_electronico">Correo Electrónico</option>
                            <option value="mensaje_texto">Mensaje de Texto</option>
                            <option value="llamada_telefonica">Llamada Telefónica</option>
                            <option value="redes_sociales">Redes Sociales</option>
                            <option value="evento">Evento</option>
                            <option value="asesor">Asesor</option>
                            <option value="otro">Otro</option>
                        </select>
                        <div class="text-danger" id="como_se_entero-error" style="text-align: left; margin-top: 5px;"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitRegistrationBtn">Completar Registro</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Mostrar el modal automáticamente
    $('#completeRegistrationModal').modal('show');
    
    $('#submitRegistrationBtn').on('click', function() {
        const comoSeEntero = $('#como_se_entero').val();
        const comoSeEnteroError = $('#como_se_entero-error');
        
        // Limpiar mensajes anteriores
        comoSeEnteroError.text('');
        
        // Validaciones
        if (!comoSeEntero) {
            comoSeEnteroError.text('Por favor selecciona cómo te enteraste de Ruta C.');
            return;
        }
        
        // Deshabilitar botón y mostrar loading
        const submitBtn = $('#submitRegistrationBtn');
        submitBtn.prop('disabled', true);
        submitBtn.text('Completando...');
        
        $.ajax({
            url: '{{ route("google.complete-registration.modal") }}',
            method: 'POST',
            data: $('#completeRegistrationForm').serialize(),
            success: function(response) {
                if (response.success) {
                    $('#completeRegistrationModal').modal('hide');
                    // Recargar la página para actualizar el estado
                    location.reload();
                } else {
                    comoSeEnteroError.text(response.message || 'Error al completar el registro.');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                comoSeEnteroError.text(response && response.message ? response.message : 'Error al completar el registro. Por favor intenta nuevamente.');
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.text('Completar Registro');
            }
        });
    });
});
</script>
@endif
@endsection

<style>
/* Asegurarnos de que el contenido esté centrado y no desborde */
.container {
    max-width: 1200px; /* Ancho máximo para que el contenido esté más centrado */
}

.row {
    margin-left: 0 !important;
    margin-right: 0 !important;
    width: 100% !important;
}

/* Eliminar desbordamiento en body y html */
html, body {
    overflow-x: hidden;
    padding: 0;
    margin: 0;
    max-width: 100%;
}

/* Botón */
.button-primary {
    max-width: 100%;
}


.company-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    overflow: hidden;
    padding: 15px;
    max-width: 100%;
    box-sizing: border-box;
}

.company-image-container {
    display: flex;
    justify-content: center;
    margin-bottom: 15px;
}


.company-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    max-width: 100%;
}


.company-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}


.company-card .card-title {
    font-size: 1.1rem;
    font-weight: 600;
}


.company-card .btn-primary {
    background-color: #007bff;
    border: none;
}

.company-card .btn-primary:hover {
    background-color: #0056b3;
}


body {
    width: 100% !important;
    overflow-x: hidden !important;
}
</style>
