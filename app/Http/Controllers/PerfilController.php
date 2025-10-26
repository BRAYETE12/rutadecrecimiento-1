<?php

namespace App\Http\Controllers;

use App\Exports\DiagnosticoRespuestasExport;
use App\Http\Services\EmailService;
use App\Http\Services\CommonService;
use App\Http\Services\SICAM32;
use App\Http\Services\UnidadProductivaService;
use App\Models\ProgramaConvocatoria;
use App\Models\ResultadosDiagnostico;
use App\Models\Sector;
use App\Models\UnidadProductiva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class PerfilController extends Controller
{
    public function SeleccionarUnidadProductiva(Request $request) 
    {
        if($request->unidadproductiva && $request->unidadproductiva > 0)
        {
            UnidadProductivaService::setUnidadProductiva($request->unidadproductiva);

            return redirect()->route('company.dashboard');    
        }

        $user = Auth::user();
        $userId = $user->id;

        $data = [
            'footer'=> CommonService::footer(),
            'links'=> CommonService::links(),
            'companies'=> UnidadProductiva::where('user_id', $userId)->orderBy('fecha_creacion', 'desc')->get(),
            'user'=> $user,
            'show_complete_registration_modal' => $user->como_se_entero === null,
        ];
     

        return view('website.company.select_company', $data);
    }

    public function dashboard() 
    {
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
    
        if ($unidadProductiva != null)
        {
            if ($unidadProductiva->update_info == 0)
                return redirect()->route('company.complete_info');

            if ($unidadProductiva->complete_diagnostic == 0 || 
                UnidadProductivaService::validarTiempoDiagnostico($unidadProductiva))
                    return redirect()->route('company.diagnostic');

            $inscripcion = $unidadProductiva->inscripciones()->where('activarPreguntas', true)->first();
            
            if($inscripcion != null)
            {
                return redirect()->route('company.program.register', ['id' => $inscripcion->convocatoria_id]);
            }

            $activarDIAGVOLUNTARIO = UnidadProductivaService::validarTiempoDiagnostico($unidadProductiva, 30);
            
            $fechaActual = date('Y-m-d');

            $programs = ProgramaConvocatoria::query()
            ->join('programas', 'programas.programa_id', '=', 'programas_convocatorias.programa_id')
            ->where('fecha_apertura_convocatoria', '<=', $fechaActual)
            ->where('fecha_cierre_convocatoria', '>=', $fechaActual)
            ->get();
            
            $data = [
                'footer'=> CommonService::footer(),
                'links'=> CommonService::links(),
                'stages'=> CommonService::etapas(),
                'company'=> $unidadProductiva,
                'helper_notifications'=> CommonService::notificaciones(),
                'activarDIAGVOLUNTARIO'=> $activarDIAGVOLUNTARIO,
                'capsulas' => CommonService::capsulas(),
                'programs' => $programs
            ];
            
            return view('website.company.dashboard', $data);
        }
        
        return redirect()->route('company.select');
    }

    public function indicadores()
    {
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
                
        $data = DB::select("
            SELECT c.fecha_respuesta, i.indicador_nombre, c.value
            FROM convocatorias_respuestas c
            INNER JOIN convocatorias_inscripciones ci ON ci.inscripcion_id = c.inscripcion_id and ci.unidadproductiva_id = {$unidadProductiva->unidadproductiva_id}
            INNER JOIN inscripciones_requisitos r ON r.requisito_id = c.requisito_id
            INNER JOIN programa_indicadores i ON i.indicador_id = r.indicador_id
            ORDER BY c.fecha_respuesta
        ");

        $labels = [];
        $datasets = [];

        foreach ($data as $row) {
            $fecha = $row->fecha_respuesta;
            $indicador = $row->indicador_nombre;
            $valor = $row->value;

            // Agregar la fecha a las etiquetas si no existe
            if (!in_array($fecha, $labels)) {
                $labels[] = $fecha;
            }

            // Inicializar el dataset del indicador si no existe
            if (!isset($datasets[$indicador])) {
                $datasets[$indicador] = [
                    'label' => $indicador,
                    'data' => [],
                    'borderWidth' => 1,
                ];
            }

            // Agregar el valor al dataset del indicador
            $datasets[$indicador]['data'][$fecha] = intval($valor);
        }

        // Asegurarse de que todos los datasets tengan los mismos índices
        foreach ($datasets as &$dataset) {
            $dataset['data'] = array_values(array_replace(array_flip($labels), $dataset['data']));
        }

        $datasets = array_values($datasets);

        $dts = [
            'unidadProductiva' => $unidadProductiva,
            'labels' => $labels,
            'datasets' => $datasets,
        ];

        return view('website.company.indicadores', $dts);
    }

    public function historialDiagnosticos(){
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
    
        if ($unidadProductiva) 
        {
            $data = [
                'company' => $unidadProductiva,
            ];
    
            return view('website.company.historial_diagnosticos', $data);
        }
    
        return redirect()->route('home')->with('error', 'No se pudo obtener la información de la empresa');
    }
    
    public function historialDiagnosticoDetalle($id)
    {
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
    
        if ($unidadProductiva) 
        {
            $diagnostico = $unidadProductiva->diagnosticos()->find($id);
                
            if ($diagnostico) 
            {        
                $resultados = ResultadosDiagnostico::where('resultado_id', $diagnostico->resultado_id)->get();
                
                $dimensiones = $resultados->pluck('dimension')->toArray();
                $resultados = $resultados->pluck('valor')->toArray();
    
                $data = [
                    'company' => $unidadProductiva,
                    'diagnostico' => $diagnostico,
                    'dimensions' => json_encode($dimensiones),
                    'results' => $resultados,
                ];
    
                return view('website.company.historial_diagnostico_detalle', $data);
            }
        }
    
        return redirect()->route('company.historialDiagnosticos');
    }
    
    public function exportarPreguntasDiagnostico($id)
    {
        return Excel::download(new DiagnosticoRespuestasExport($id), 'diagnostico-respuestas.xlsx');
    }
    
    public function completarInformacion() 
    {
        $data = [
            'footer'=> CommonService::footer(),
            'links'=> CommonService::links(),
            'departments'=> CommonService::departamentos(),
            'company'=> UnidadProductivaService::getUnidadProductiva(),
            'listaCargos'=> SICAM32::listadoViculosCargos(),
            'sectores'=> Sector::get(),
        ];

        return view('website.company.complete_info', $data);
    }

    public function completarInformacionGuardar(Request $request) 
    {
        $unidad = UnidadProductivaService::getUnidadProductiva();

        $unidad->department_id = $request->department;
        $unidad->municipality_id = $request->municipality;
        $unidad->address = $request->address;
        $unidad->telephone = $request->telephone;
        $unidad->mobile = $request->mobile;

        $unidad->contact_person = $request->contact_person;
        $unidad->contact_position = $request->contact_position;
        $unidad->contact_email = $request->contact_email;
        $unidad->contact_phone = $request->contact_phone;
        $unidad->contact_sexo = $request->contact_sexo;

        $unidad->website = $request->website;
        $unidad->social_instagram = $request->social_instagram;
        $unidad->social_facebook = $request->social_facebook;
        $unidad->social_linkedin = $request->social_linkedin;

        $unidad->geolocation = UnidadProductivaService::localizacion($request->department, $request->municipality, $request->address);

        $unidad->sector_id = $request->sector_id;
        $unidad->ciiuactividad_id = $request->ciiuactividad_id;

        $unidad->update_info = 1;
        $unidad->save();


        // Enviamos notificacion de email al correo corporativo
        $unidad->usuario = $unidad->usuario()->first();
        EmailService::send($unidad->registration_email, 'Solicitud de registro', 'website.mail.company_register', $unidad);

        return redirect()->route('company.diagnostic');
    }

    public function perfil() 
    {
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
        
        if (!$unidadProductiva) {
            abort(404, 'Unidad productiva no encontrada o no asociada al usuario.');
        }
     
        $programas_inscrito = []; 
    
        $data = [
            'footer' => CommonService::footer(),
            'links' => CommonService::links(),
            'helper_notifications' => CommonService::notificaciones(),
            'departments' => CommonService::departamentos(), 
            'municipalities' => CommonService::municipios(), 
            'programas_inscrito' => $programas_inscrito,
            'company' => $unidadProductiva,
            'user' => Auth::user(),
        ];
       
        return view('website.company.profile', $data);
    }
    

    public function actualizarPerfil() 
    {
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
        $listaCargos = SICAM32::listadoViculosCargos();
      
        $data = [
            'footer'=> CommonService::footer(),
            'links'=> CommonService::links(),
            'departments'=> CommonService::departamentos(),
            'municipalities' => CommonService::municipios(), 
            'company'=> $unidadProductiva,
            'listaCargos'=> $listaCargos,
        ];

        return view('website.company.profile_update', $data);
    }

    public function actualizarPerfilGuardar(Request $request) 
    {
        $unidad = UnidadProductivaService::getUnidadProductiva();

        $unidad->description = $request->description;

        $unidad->department_id = $request->department;
        $unidad->municipality_id = $request->municipality;
        $unidad->address = $request->address;
        $unidad->telephone = $request->telephone;
        $unidad->mobile = $request->mobile;

        $unidad->contact_person = $request->contact_person;
        $unidad->contact_position = $request->contact_position;
        $unidad->contact_email = $request->contact_email;
        $unidad->contact_phone = $request->contact_phone;
        $unidad->contact_sexo = $request->contact_sexo;
        
        $unidad->website = $request->website;
        $unidad->social_instagram = $request->social_instagram;
        $unidad->social_facebook = $request->social_facebook;
        $unidad->social_linkedin = $request->social_linkedin;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $name = time() . '-' . $file->getClientOriginalName();
            $file->move('/home/rutacrecimiento/public_html/archivos/storage/logos/', $name);
            $unidad->logo = 'storage/logos/'.$name;
        }
        $unidad->save();

        return redirect()->route('company.profile')->with('success', 'Información actualizada correctamente');
    }

    public function actualizarPassword() 
    {
        return view('website.company.password_update');
    }

    public function actualizarPasswordGuardar(Request $request) 
    {    
        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->password_old, $user->password))
            return redirect()->back()->with('error', 'La contraseña actual no es correcta');

        if ($request->password != $request->password_confirm)
            return redirect()->back()->with('error', "El campo de contraseña y confirmar contraseña, deben ser iguales");

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect(route('company.profile'))->with('success', "Contraseña actualizada correctamente");
    }


    public function grafico($id) 
    {
        if($id != null && $id > 0)
        {
            $unidadProductiva = UnidadProductiva::find($id);
        }
        else
        {
            $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
        }

        if ($unidadProductiva != null)
        {
            $diagnostico = $unidadProductiva->diagnosticos->last();
           
            $resultados = ResultadosDiagnostico::where('resultado_id', $diagnostico->resultado_id)->get();

            $dimensiones = $resultados->pluck('dimension')->toArray();
            $resultados = $resultados->pluck('valor')->toArray();
            
            $data = [
                'company'=> $unidadProductiva,
                'dimensions'=> json_encode($dimensiones),
                'results'=> json_encode($resultados),
            ];
    
            return view('website.company.radial_graphic', $data);
        }
    }

}
