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
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    private const MENSAJE_EXISTE_UNIDAD = "La empresa ya se encuentra registrada. Utilice la opción de iniciar sesión";
    private const MENSAJE_EXISTE_USUARIO = "El correo electrónico ya se encuentra registrado. Utilice la opción de iniciar sesión";
    private const MENSAJE_EXISTE_USUARIO_UNIDAD = "El correo electrónico ya se encuentra registrado en una unidad productiva.";
    private const MENSAJE_NO_ENCONTRO_UNIDAD = "No se encontraron empresas según el tipo de búsqueda. Valide los datos e intente nuevamente.";
    private const MENSAJE_NO_VALIDADA = "No pudimos validar su empresa. Intente nuevamente.";

    public function index()
    { 
        $data = [
            'footer' => CommonService::footer(),
            'links' => CommonService::links(),
            'camaras' => SICAM32::listadoCamarasComercio(),
            'tiposIdentificacion' => SICAM32::listadoTiposIdentificacion(),
            'departamentos' => CommonService::departamentos(),
            'listaCargos'=> SICAM32::listadoViculosCargos(),
            'sectores'=> Sector::get(),
            'loguin'=> Auth::check()
        ];

        return view('website.register.index', $data);
    }

    // Buscar unidad en CCMS
    public function search(Request $request)
    {
        $api = SICAM32::buscarRegistroMercantil($request->search_type, $request->search_name);
        
        if (empty($api) || $api->RESPUESTA !== 'EXITO' || count($api->DATOS->expedientes) === 0) {
            return [ 'success'=> false, 'mensaje'=> self::MENSAJE_NO_ENCONTRO_UNIDAD ];
        }

        $listado = [];
        
        foreach($api->DATOS->expedientes as $item)
        {
            if($item->nit && $item->nombre && $item->matricula)
            {
                $listado[] = 
                [ 
                    'nombre'=> $item->nombre, 
                    'nit'=> $item->nit,
                    'matricula'=> $item->matricula,
                    'fechamatricula'=> (DateTime::createFromFormat("Ymd", $item->fechamatricula))->format("Y-m-d"),
                ];
            }
        }

        if (count($listado) === 0) {
            return [ 'success'=> false, 'mensaje'=> self::MENSAJE_NO_ENCONTRO_UNIDAD ];
        }
        
        return [ 'success'=> true, 'listado'=> $listado ];
    }

    // Buscar unidad en CCMS detalles
    public function searchDetail(Request $request)
    {
        //if( $this->existeUnidad($request->search_nit, "") ){
        //    return [ 'success' => false, 'mensaje' => self::MENSAJE_EXISTE_UNIDAD ];
        //}
        
        $api = SICAM32::consultarExpedienteMercantilporIdentificacion($request->search_nit);

        if (!is_object($api) || $api->RESPUESTA !== 'EXITO' || empty($api->DATOS)) {
            $error = $api->MENSAJE ?? self::MENSAJE_NO_VALIDADA;

            return [ 'success' => false, 'mensaje' => $error ];
        }

        $datos = CrearUnidadService::datosApi($api->DATOS);
        
        return [ 'success'=> true, 'datos'=> $datos ];
    }

    // Crear usuario
    public function crearUsuario(Request $request)
    {
        $exists = User::where('email', $request->user_email)->exists();

        if(!$exists)
        {
            $user = UsuarioService::crearUsuario($request);
        }
        
        return [
            'success' => true,
            'existe' => $exists,
            'mensaje' => $exists ? self::MENSAJE_EXISTE_USUARIO : null,
            'user_id' => $user->id ?? null,
        ];
    }

    public function validarUsuario(Request $request)
    {
        $user = User::where('email', $request->user_email)->first();
        
        if ($user != null)
        {
            return [ 'success' => false, 'mensaje' => self::MENSAJE_EXISTE_USUARIO ];
        }

        $user = UnidadProductiva::where('registration_email', $request->user_email)->first();

        if ($user != null)
        {
            return [ 'success' => true, 'unidad' => true, 'mensaje' => self::MENSAJE_EXISTE_USUARIO_UNIDAD ];
        }
        
        return [ 'success' => true ];
    }

    // Guardar registro
    public function store(Request $request)
    {
        /*
        if (!reCAPTCHAv3::validar($request->token))
            return redirect()->back()
                    ->with('error', 'No PASATE EL FILTRO DE SEGURIDAD ANTIROBOTS. Intentalo nuevamente');
        */

        if( $this->existeUnidad($request->nit_registrado, $request->business_name) ){
            return [ 'success' => false, 'mensaje' => self::MENSAJE_EXISTE_UNIDAD ];
        }

        $tipoPersona = UnidadProductivaPersona::where('tipoPersonaCODIGO', $request->tipoPersonaID)->first();
        $tipoRegistro = UnidadProductivaTipo::where('unidadtipo_id', $request->tipo_registro_rutac)->first();

        if (Auth::check())
            $request->merge(['user_id' => auth()->id()]);

        // Crear unidad
        $company = CrearUnidadService::crear($request, $tipoPersona, $tipoRegistro);

        //Registra la unidad en ruta C
        $this->registarUnidadProductivaRutaC($company);

        // loguear al usuario
        $this->loguinUser($request->user_id);
        
        // Set por defecto la unidad creada
        UnidadProductivaService::setUnidadProductiva($company->unidadproductiva_id);

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

    // validar si existe la unidad productiva
    private function existeUnidad($nit, $name): bool
    {
        $query = UnidadProductiva::where(function($q) use ($name, $nit) {
            $q->where('business_name', 'like', "%$name%");
            
            if (!empty($nit)) {
                $q->orWhere('nit', 'like', "%$nit%");
            }
        });

        return $query->exists();
    }

    private function loguinUser($id)
    {
        $user = User::find($id);

        if (!Auth::check())
            Auth::login($user);
    }

}
