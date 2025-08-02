<?php

namespace App\Http\Services;

use App\Models\CiiuActividad;
use App\Models\Municipio;
use App\Models\UnidadProductiva;
use App\Models\UnidadProductivaPersona;
use App\Models\UnidadProductivaTipo;

class CrearUnidadService
{
    public static function crearDesdeAPI($values, $request, $userId): UnidadProductiva
    {
        $comercial_activity = substr($values->ciiu1, 1);
        $activity = CiiuActividad::where('ciiuActividadCODIGO', $comercial_activity)->first();
        
        $company = new UnidadProductiva();

        $company->fill([
            'business_name' => $values->nombre,
            'nit' => $values->nit,
            'registration_number' => $values->matricula,
            'registration_date' => date("Y-m-d", strtotime($values->fechamatricula)),
            'registration_email' => $values->emailcom ?: $values->email,
            'address' => $values->dircom,
            'mobile' => $values->telcom1,
            'affiliated' => $values->afiliado,
            'comercial_activity' => $comercial_activity,
            'user_id' => $userId,
            'tamano_id' => $values->tamanoempresa,
            'camara_comercio' => 32,

            'sector_id' => $activity->macroSectorID, 
            'ciiuactividad_id' => $activity->ciiuactividad_id, 
        ]);

        $tipoRegistro = UnidadProductivaTipo::where('unidadtipo_id', 4)->first();
        $company->unidadtipo_id = $tipoRegistro->unidadtipo_id;
        $company->tipo_registro_rutac = $tipoRegistro->unidadtipo_nombre;
        $company->logo = UnidadProductiva::getLogo($tipoRegistro->unidadtipo_id);

        $tipoPersona = match ($values->organizacion) {
            '01' => UnidadProductivaPersona::where('tipopersona_id', 1)->first(),
            '02' => UnidadProductivaPersona::where('tipopersona_id', 2)->first(),
            default => UnidadProductivaPersona::where('tipopersona_id', 3)->first(),
        };

        $company->fill([
            'tipo_identificacion' => SICAM32::codigoTIpoIdentificon($values->organizacion === '01' ? $values->idclase : $values->idclaserl),
            'identificacion' => $values->organizacion === '01' ? $values->identificacion : $values->identificacionrl,
            'name_legal_representative' => $values->organizacion === '01' ? $values->nombre : $values->nombrerl,
            'tipopersona_id' => $tipoPersona->tipopersona_id,
            'type_person' => $tipoPersona->tipoPersonaCODIGO,
        ]);

        $municipio = Municipio::where('municipioCODIGODANE', $values->muncom)->first();
        $company->department_id = $municipio->departamentoID;
        $company->municipality_id = $municipio->municipio_id;

        $company->fill([
            'contact_person' => $request->contact_person,
            'contact_position' => $request->contact_position,
            'contact_sexo' => $request->contact_sexo,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
        ]);

        $company->save();

        return $company;
    }

    public static function crearDesdeLead($request, $tipoPersona, $tipoRegistro, $user): UnidadProductiva
    {
        $tipoIdentificacion = SICAM32::codigoTIpoIdentificon($request->tipo_identificacion);

        $company = new UnidadProductiva();

        $company->fill([
            'business_name' => $request->business_name,
            'description' => $request->description,
            'registration_number' => $request->registration_number,
            'registration_date' => $request->registration_date,
            'registration_email' => $request->email,
            'address' => $request->address,
            'telephone' => $request->telephone,  
            'mobile' => $request->mobile, 
            
            'sector_id' => $request->sector_id, 
            'ciiuactividad_id' => $request->ciiuactividad_id, 
            
            'municipality_id' => $request->municipality,
            'municipality_viejo' => $request->municipality,
            'department_id' => $request->department,
            'department_viejo' => $request->department,   
            
            'geolocation' => UnidadProductivaService::localizacion($request->department, $request->municipality, $request->address),
            
            'name_legal_representative' => $request->name_legal_representative,
            'affiliated' => 0,
            'user_id' => $user->id,
            'tipo_identificacion' => $tipoIdentificacion,
            'identificacion' => $request->document,
            
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
        ]);

        $company->nit = $request->nit_registrado;

        if ($request->tipo_registro_rutac == 1) {
            $company->anual_sales = 0;
        }

        $company->save();

        return $company;
    }

    public static function datosRegistroRutaC($company): array
    {
        $municipio = Municipio::where('municipio_id', $company->municipality_id)->first();

        return [
            'personaNIT' => $company->nit,
            'tipoPersonaRUTAC' => $company->tipopersona_id,
            'tipoPersonaCODIGO' => UnidadProductivaPersona::find($company->tipopersona_id)->tipoPersonaNOMBRE,
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
            'unidadProductivaFCHINICIO' => $company->registration_date,
            'unidadProductivaTITULO' => $company->business_name,
            'unidadProductivaDESCRIPCION' => $company->description,
            'unidadProductivaEMAIL' => $company->registration_email,
            'unidadProductivaENLACE' => $company->address,
            'unidadProductivaTELEFONO' => $company->mobile,
            'municipioCODIGODANE' => $municipio->dame, /* COLOCAR CODIGO DANE */
            'unidadProductivaDIRECCION' => $company->address,
            'unidadProductivaCONTACTONOMBRE' => $company->name_legal_representative,
            'unidadProductivaCONTACTOEMAIL' => $company->registration_email,
            'unidadProductivaCONTACTOTELEFONO' => $company->mobile,
            'unidadProductivaCAMARADECOMERCIO' => $company->camara_comercio,
            'unidadProductivaMATRICULA' => $company->registration_number,
            'unidadProductivaFCHMATRICULA' => $company->registration_date,
            'unidadProductivaNIT' => $company->nit,
            'unidadProductivaREPRESENTANTELEGAL' => $company->name_legal_representative,
            'REQUEST1' => $company->toArray(),
        ];
    }

}