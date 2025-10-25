<?php

namespace App\Http\Services;

use App\Models\CiiuActividad;
use App\Models\Municipio;
use App\Models\UnidadProductiva;
use App\Models\UnidadProductivaPersona;

class CrearUnidadService
{
    public static function datosApi($values)
    {
        $comercial_activity = substr($values->ciiu1, 1);
        $activity = CiiuActividad::where('ciiuActividadCODIGO', $comercial_activity)->first();
        
        $data = [
            'business_name' => $values->nombre,
            'razon_social' => $values->nombre,
            'nit_registrado' => $values->nit,
            'registration_number' => $values->matricula,
            'registration_date' => date("Y-m-d", strtotime($values->fechamatricula)),
            'registration_email' => $values->emailcom ?? null,

            'address' => $values->dircom,
            'mobile' => $values->telcom1 ?? $values->telcom2 ?? $values->telcom3,
            'telephone'=> $values->telcom3 ?? $values->telcom2 ?? $values->telcom1,
            'comercial_activity' => $comercial_activity,
            'tamano_id' => $values->tamanoempresa,
            'camara_comercio' => 32,
            'tamano_id' => $values->tamanoempresa,

            'sector_id' => "{$activity->macroSectorID}", 
            'ciiuactividad_id' => "{$activity->ciiuactividad_id}", 
            'seccion' => "{$activity->ciiuSeccionID}"

        ];

        $tipoPersona = match ($values->organizacion) {
            '01' => UnidadProductivaPersona::where('tipopersona_id', 1)->first(),
            '02' => UnidadProductivaPersona::where('tipopersona_id', 2)->first(),
            default => UnidadProductivaPersona::where('tipopersona_id', 3)->first(),
        };

        $data['tipo_identificacion'] = SICAM32::codigoTIpoIdentificon($values->organizacion === '01' ? $values->idclase : $values->idclaserl);
        $data['identificacion'] = $values->organizacion === '01' ? $values->identificacion : $values->identificacionrl;
        $data['name_legal_representative'] = $values->organizacion === '01' ? $values->nombre : $values->nombrerl;
        $data['tipopersona_id'] = $tipoPersona->tipopersona_id;
        $data['type_person'] = $tipoPersona->tipoPersonaCODIGO;

        $municipio = Municipio::where('municipioCODIGODANE', $values->muncom)->first();
        $data['department_id'] = "{$municipio->departamentoID}";
        $data['municipality_id'] = "{$municipio->municipio_id}";

        $data['contact_person'] = $data['name_legal_representative'];
        $data['contact_email'] = $data['registration_email'];
        $data['contact_phone'] = $data['mobile'];

        return $data;
    }

    public static function crear($request, $tipoPersona, $tipoRegistro): UnidadProductiva
    {
        $company = new UnidadProductiva();

        $company->fill([
            'camara_comercio' => $request->camara_comercio,
            'nit' => $request->nit_registrado ?? "-",
            'business_name' => $request->business_name,
            'description' => $request->description,
            'registration_number' => $request->registration_number,
            'registration_date' => $request->registration_date,
            'registration_email' => $request->registration_email ?? $request->contact_email,
            'address' => $request->address,
            'telephone' => $request->telephone,  
            'mobile' => $request->mobile, 
            
            'sector_id' => $request->sector_id, 
            'ciiuactividad_id' => $request->ciiuactividad_id, 
            
            'municipality_id' => $request->municipality_id,
            'municipality_viejo' => $request->municipality_id,
            'department_id' => $request->department_id,
            'department_viejo' => $request->department_id,   
            
            'geolocation' => UnidadProductivaService::localizacion($request->department_id, $request->municipality_id, $request->address),
            
            'name_legal_representative' => $request->name_legal_representative ?? $request->contact_person,
            'affiliated' => 0,
            'user_id' => $request->user_id,
            
            'tipo_identificacion' => $request->tipo_identificacion,
            'identificacion' => $request->identificacion,
            
            'unidadtipo_id' => $tipoRegistro->unidadtipo_id,
            'tipo_registro_rutac' => $tipoRegistro->unidadtipo_nombre,
            'tipopersona_id' => $tipoPersona->tipopersona_id,
            'type_person' => $tipoPersona->tipoPersonaCODIGO,
            'logo' => UnidadProductiva::getLogo($tipoRegistro->unidadtipo_id),
            
            'contact_person' => $request->contact_person,
            'contact_position' => $request->contact_position,
            'contact_sexo' => $request->contact_sexo,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,

            'website' => $request->website,
            'social_instagram' => $request->social_instagram,
            'social_facebook' => $request->social_facebook,
            'social_linkedin' => $request->social_linkedin,
        ]);

        if ($request->tipo_registro_rutac == 1) {
            $company->anual_sales = 0;
        }

        $company->update_info = 1;

        $company->save();

        // Enviar correo de unidad productiva creada
        if ($company->user_id) {
            $user = \App\Models\User::find($company->user_id);
            if ($user) {
                $nombreUsuario = $user->name . ' ' . $user->lastname;
                \App\Http\Services\EmailService::enviarCorreoUnidadProductiva($company->registration_email, $nombreUsuario, $company->business_name);
            }
        }

        return $company;
    }

    public static function datosRegistroRutaC($company): array
    {
        $municipio = Municipio::where('municipio_id', $company->municipality_id)->first();
        $tipoPersona = UnidadProductivaPersona::where('tipopersona_id', $company->tipopersona_id)->first();

        return [
            'personaNIT' => $company->nit,
            'tipoPersonaRUTAC' => $tipoPersona->tipopersona_id,
            'tipoPersonaCODIGO' => $tipoPersona->tipoPersonaNOMBRE,
            'tipoIdentificacionCODIGO' => $company->tipo_identificacion,
            
            'personaIDENTIFICACION' => $company->identificacion,
            'personaRAZONSOCIAL' => $company->business_name,
            'personaNOMBRES' => $company->name_legal_representative,
            'personaAPELLIDOS' => '',
            'correoDIRECCION' => $company->registration_email,
            'telefonoNUMEROCELULAR' => $company->mobile,
            'direccionCOMERCIAL' => $company->address,
            
            'unidadProductivaTIPOREGISTRORUTAC' => $company->tipo_registro_rutac,
            'unidadProductivaTIPOREGISTRORUTACID' => $company->unidadtipo_id,
            'unidadProductivaFCHINICIO' => $company->registration_date->format('Y-m-d'),
            'unidadProductivaTITULO' => $company->business_name,
            'unidadProductivaDESCRIPCION' => $company->description,
            'unidadProductivaEMAIL' => $company->registration_email,
            'unidadProductivaENLACE' => $company->address,
            'unidadProductivaTELEFONO' => $company->mobile,
            'municipioCODIGODANE' => $municipio->municipioCODIGODANE,
            'unidadProductivaDIRECCION' => $company->address,

            'unidadProductivaCONTACTONOMBRE' => $company->contact_person,
            'unidadProductivaCONTACTOEMAIL' => $company->contact_email,
            'unidadProductivaCONTACTOTELEFONO' => $company->contact_phone,

            'unidadProductivaCAMARADECOMERCIO' => $company->camara_comercio,
            'unidadProductivaMATRICULA' => $company->registration_number,
            'unidadProductivaFCHMATRICULA' => $company->registration_date->format('Y-m-d'),
            'unidadProductivaNIT' => $company->nit,
            'unidadProductivaREPRESENTANTELEGAL' => $company->name_legal_representative,
            'REQUEST1' => $company->toArray(),
        ];
    }

}