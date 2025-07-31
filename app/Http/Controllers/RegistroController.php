<?php

namespace App\Http\Controllers;

use App\Http\Services\CommonService;
use App\Http\Services\CrearUnidadService;
use App\Http\Services\reCAPTCHAv3;
use App\Http\Services\SICAM32;
use App\Http\Services\UnidadProductivaService;
use App\Http\Services\UsuarioService;
use App\Models\Sector;
use App\Models\UnidadProductiva;
use App\Models\UnidadProductivaPersona;
use App\Models\UnidadProductivaTipo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    private const MENSAJE_EXISTE_UNIDAD = "La empresa ya se encuentra registrada. Utilice la opción de iniciar sesión";
    private const MENSAJE_EXISTE_USUARIO = "El correo electrónico ya se encuentra registrado. Utilice la opción de iniciar sesión";
    private const MENSAJE_NO_ENCONTRO_UNIDAD = "No se encontraron empresas según el tipo de búsqueda. Valide los datos e intente nuevamente.";
    private const MENSAJE_NO_VALIDADA = "No pudimos validar su empresa. Intente nuevamente.";


    public function index()
    {
        $data = [
            'section' => CommonService::section(),
            'footer' => CommonService::footer(),
            'links' => CommonService::links(),
            'camaras' => SICAM32::listadoCamarasComercio(),
            'tiposIdentificacion' => SICAM32::listadoTiposIdentificacion(),
            'departamentos' => CommonService::departamentos(),
            'municipios' => CommonService::municipios(),
            'listaCargos'=> SICAM32::listadoViculosCargos(),
            'sectores'=> Sector::get(),
        ];

        $view = Auth::check() ? 'website.register.create_company' : 'website.register.indexp';
        return view($view, $data);
    }

    // Buscar unidad en CCMS
    public function search(Request $request)
    {
        $api = SICAM32::buscarRegistroMercantil($request->search_type, $request->search_name);

        if (empty($api) || $api->RESPUESTA !== 'EXITO' || count($api->DATOS->expedientes) === 0) {
            return [ 'success'=> false, 'mensaje'=> self::MENSAJE_NO_ENCONTRO_UNIDAD ];
        }

        $resultado = $api->DATOS->expedientes[0];

        if ($this->existeNitUnidad($resultado->nit) || $this->existeNombreUnidad($resultado->nombre)) {
            return [ 'success'=> false, 'mensaje'=> self::MENSAJE_EXISTE_UNIDAD ];
        }

        return [
            'success'=> true,
            'nombre'=> $resultado->nombre,
            'nit'=> $resultado->nit,
            'email'=> \App\helpers::maskPartialInfo($resultado->emailcom),
        ];
    }

    public function searchUsuario(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();

        return [
            'success' => $exists,
            'mensaje' => $exists ? self::MENSAJE_EXISTE_USUARIO : null,
        ];
    }


    public function store(Request $request)
    {
        /*
        if (!reCAPTCHAv3::validar($request->token))
            return redirect()->back()
                    ->with('error', 'No PASATE EL FILTRO DE SEGURIDAD ANTIROBOTS. Intentalo nuevamente');
        */

        // Validación si el usuario existe
        if (!Auth::check() && User::where('email', $request->user_email)->first() != null)
        {
           return [ 'success' => false, 'mensaje' => self::MENSAJE_EXISTE_USUARIO ];
        }

        // Creación del usuario y contraseña para acceder al sistema
        $user = UsuarioService::crearUsuario($request);

        if($request->tipo_registro_rutac == '4')
        {
            return $this->storeFormalCCSM($request, $user);
        }
        
        return $this->storeLead($request, $user);
    }

    // Registro del formal Magdalena
    private function storeFormalCCSM(Request $request, $user)
    {
        $api = SICAM32::consultarExpedienteMercantilporIdentificacion($request->search_nit);

        if (!is_object($api) || $api->RESPUESTA !== 'EXITO' || empty($api->DATOS)) {
            $error = $api->MENSAJE ?? self::MENSAJE_NO_VALIDADA;

            return [ 'success' => false, 'mensaje' => $error ];
        }

        $values = $api->DATOS;

        if ($this->existeNitUnidad($values->nit) || $this->existeNombreUnidad($values->nombre)) {
            return [ 'success' => false, 'mensaje' => self::MENSAJE_EXISTE_UNIDAD ];
        }

        // Crear unidad
        $company = CrearUnidadService::crearDesdeAPI($values, $request, $user->id);

        UnidadProductivaService::validarRenovacion($values->fecharenovacion, $company->unidadproductiva_id);
        UnidadProductivaService::validarSiguienteRenovacion($values->fechamatricula, $values->fecharenovacion, $company->unidadproductiva_id);

        //Registra la unidad en ruta C
        $this->registarUnidadProductivaRutaC($company);

        return [ 'success' => true ];
    }

    // Registro no formales y camara externa
    public function storeLead(Request $request, $user)
    {
        // Validación si ya existe el nit o el nombre
        if( ( $request->tipo_registro_rutac == 3 && $this->existeNitUnidad($request->nit_registrado)) || $this->existeNombreUnidad($request->business_name) ){
            return [ 'success' => false, 'mensaje' => self::MENSAJE_EXISTE_UNIDAD ];
        }
        
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            $unidad = $user->unidadesProductivas()->first();

            $request->merge([
                'tipoPersonaID' => $unidad->identificacion ? 0 : 2,
                'tipo_identificacion' => $unidad->identificacion ? 1 : 2,
                'document' => $unidad->identificacion ?? $unidad->nit,
                'personaRAZONSOCIAL' => $unidad->name_legal_representative,
                'personaNOMBRES' => $unidad->name_legal_representative,
                'personaAPELLIDOS' => '',
            ]);
        }

        $tipoPersona = UnidadProductivaPersona::where('tipoPersonaCODIGO', $request->tipoPersonaID)->first();
        $tipoRegistro = UnidadProductivaTipo::where('unidadtipo_id', $request->tipo_registro_rutac)->first();

        // Crear unidad
        $company = CrearUnidadService::crearDesdeLead($request, $tipoPersona, $tipoRegistro, $user);

        //Registra la unidad en ruta C
        $this->registarUnidadProductivaRutaC($company);

        return [ 'success' => true ];
    }

    // Registrar la unidad productiva en ruta c
    private function registarUnidadProductivaRutaC($company)
    {
        $datos = CrearUnidadService::datosRegistroRutaC($company);
        $UnidadProductiva = SICAM32::registarNuevaUnidadProductiva($datos);

        SICAM32::actualizarIdRelacionadoUnidadProductiva($UnidadProductiva->unidadProductivaID, $company->unidadproductiva_id);

        return $UnidadProductiva;
    }

    // validar si existe la unidad productiva por el nit
    private function existeNitUnidad($nit): bool
    {
        return UnidadProductiva::where('nit', 'like', "%$nit%")->exists();
    }

    // validar si existe la unidad productiva por el nombre
    private function existeNombreUnidad($name): bool
    {
        return UnidadProductiva::where('business_name', 'like', "%$name%")->exists();
    }

}
