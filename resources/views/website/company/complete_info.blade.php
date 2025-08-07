@extends('website.layouts.main')
@section('header-class','without-header')
@section('title','Ruta C')
@section('description','')

@section('content')
<div id="register">
    <div class="container">
        <section class="step-1 mt-40 mb-40">
            <div>                                        
                <h1>Bienvenid@, <b>{{$company->business_name}}</b> [{{$company->nit}}]!.</h1>                    
            </div>
            <h2 class="size-l color-2 font-w-700">Verifica los datos registrados</h2>
            <p class="mt-5">
                Lo invitamos a completar la siguiente información corporativa. Una vez termine de completar los campos, presione el botón de "Continuar"
            </p>
            <form method="post" action="{{route('company.complete_info.save')}}">
                @csrf

                <div class="row d-flex group">
                    
                    <div class="col-12 col-md-12">
                        <h2>Información de la empresa</h2>
                    </div>

                    <div class="col-12 col-md-6 mt-3">
                        <label>Celular *</label>
                        <input type="text" name="mobile" value="{{$company->mobile}}" required/>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label>Teléfono (opcional)</label>
                        <input type="text" name="telephone" value="{{$company->telephone}}"  />
                    </div>

                    <div class="col-12 col-md-6 mt-3">
                        <label>Seleccione un departamento *</label>
                        <select id="department" name="department" required>
                            <option value="">Seleccione un departamento</option>
                            @foreach($departments as $department)                                
                                <option value="{{$department->id}}" >{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label>Seleccione un municipio *</label>
                        <select id="municipality" name="municipality" required>
                            <option>Seleccione primero un departamento</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-12 mt-3">
                        <label>Dirección *</label>
                        <input type="text" name="address" value="{{$company->address}}" required  style="text-transform: uppercase;" />
                    </div>

                    <div class="col-12 col-md-6 mt-3">
                        <label>Sector *</label>
                        <select id="sector" name="sector_id" required>
                            <option value="">Seleccione un sector *</option> 
                            @foreach($sectores as $item)
                                <option  value="{{$item->sector_id}}">{{$item->sectorNOMBRE}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mt-3">
                        <label>Sección </label>
                        <select id="seccion" name="seccion">
                            <option>Seleccione un sector</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-12 mt-3">
                        <label>Actividad economica </label>
                        <select id="actividad" name="ciiuactividad_id">
                            <option>Seleccione una sección</option>
                        </select>
                    </div>

                </div>

                <div class="row d-flex group mt-4">

                    <div class="col-12 col-md-12">
                        <h2>Persona de contacto</h2>
                    </div>

                    <div class="col-12 col-md-6 mt-3">
                        <label>Nombre *</label>
                        <input type="text" name="contact_person" value="{{$company->contact_person}}" required  style="text-transform: uppercase;" />
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label>Cargo *</label>
                        <select id="list_contacto_position" required onchange="actualizarNombreCargoContacto(this);">
                            <option value="">SELECCIONE UNO</option> 
                            @foreach($listaCargos as $cargo)
                            <option 
                                @if($cargo->vinculoCargoTITULO == $company->contact_position )    
                                selected
                                @endif
                                value="{{$cargo->vinculoCargoTITULO}}">{{$cargo->vinculoCargoTITULO}}</option>
                            @endforeach
                        </select>
                        <input type="text" id="contact_position" name="contact_position" value="{{$company->contact_position}}" required  style="text-transform: uppercase;display:none;"/>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label>Email *</label>
                        <input type="text" name="contact_email" value="{{$company->registration_email}}" required/>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label>Celular *</label>
                        <input type="text" name="contact_phone" value="{{$company->mobile}}" required/>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-3">
                            <label>Sexo *</label>
                            <select name="contact_sexo" required>
                                <option value="">SELECCIONE UNO</option>
                                <option value="MASCULINO" @if($company->contact_sexo == 'MASCULINO') selected @endif>MASCULINO</option>
                                <option value="FEMENINO" @if($company->contact_sexo == 'FEMENINO') selected @endif>FEMENINO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row d-flex group mt-4">

                    <div class="col-12 col-md-12">
                        <h2>Información adicional</h2>
                    </div>

                    <div class="col-12 col-md-6 mt-3">
                        <label>URL del Sitio Web (Opcional)</label>
                        <input type="text" name="website" value="{{$company->website}}" />
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label>Instagram (Opcional)</label>
                        <input type="text" name="social_instagram" value="{{$company->social_instagram}}" />
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label>Facebook (Opcional)</label>
                        <input type="text" name="social_facebook" value="{{$company->social_facebook}}" />
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label>LinkedIn (Opcional)</label>
                        <input type="text" name="social_linkedin" value="{{$company->social_linkedin}}" />
                    </div>
                </div>


                <style>
                    .cuadro_datos_usuarios {

                        padding: 10px;
                        margin-top: 20px;
                        margin-bottom: 20px;

                        border: 1px inset #000000;
                        border-radius: 11px;

                        background: #FFFFFF;
                        background: -moz-radial-gradient(center, #FFFFFF 0%, #D3D7DA 100%, #EEEEEE 100%);
                        background: -webkit-radial-gradient(center, #FFFFFF 0%, #D3D7DA 100%, #EEEEEE 100%);
                        background: radial-gradient(ellipse at center, #FFFFFF 0%, #D3D7DA 100%, #EEEEEE 100%);

                        -webkit-box-shadow: 0px 0px 6px 2px #000000;
                        box-shadow: 0px 0px 6px 2px #000000;
                    }
                </style>
                <div class="cuadro_datos_usuarios " style=" " >
                    <h2 style="text-align:center">Estos son los datos de tu usuario:</h2>
                    <p style="text-align:center">Nombre de usuario:&nbsp; <strong>{{$company->registration_email}}</strong></p>
                    <p style="text-align:center">Contrase&ntilde;a Temporal: <strong>{{$company->identificacion}}</strong></p>
                    <h3 style="text-align:center">Por seguridad Le recomendamos cambiar la contrase&ntilde;a cuando ingrese .</h3>
                </div>

                <hr />

                <input type="submit" class="button button-primary mt-20 margin-center" value="Continuar"/>
            </form>
        </section>
    </div>
</div>
@endsection

@section('js')
<script>

    function actualizarNombreCargoContacto(seleccionable) {
            var cargo = $(seleccionable).find(":selected").val();
            $("#contact_position").val(cargo);
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

    $('document').ready(function () {
        $('#department').on('change', function () {
            let id = $(this).val();
            initselect('/municipios/listado', id, '#municipality');
        });

        $('#sector').on('change', function () {
        // Limpiar los selects de sección y actividad
        $('#seccion').html('<option value="">Seleccione un sector</option>');
        $('#actividad').html('<option value="">Seleccione una sección</option>');
        
        // Obtener el ID del sector seleccionado y cargar las secciones correspondientes
        let id = $(this).val();
        if (id) {
            initselect('/secciones/listado', id, '#seccion');
        }
    });

        $('#seccion').on('change', function () {
            let id = $(this).val();
            initselect('/actividades/listado', id, '#actividad');
        });

        $("#department").val('{{$company->department_id}}');
        $("#sector").val('{{$company->sector_id}}');

        initselect('/municipios/listado', {{$company->department_id ?? 0}}, '#municipality', '{{$company->municipality_id}}');
                
        @if ($company->ciiuActividad()->first() != null)
            initselect('/secciones/listado', {{$company->sector_id}}, '#seccion', '{{$company->ciiuActividad->ciiuSeccionID}}');
            initselect('/actividades/listado', {{$company->ciiuActividad->ciiuSeccionID}}, '#actividad', '{{$company->ciiuActividad->ciiuactividad_id}}');
        @endif

    })
</script>
@endsection
