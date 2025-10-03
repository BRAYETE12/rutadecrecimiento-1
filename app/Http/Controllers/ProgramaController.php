<?php

namespace App\Http\Controllers;

use App\Exports\InscripcionConvocatoriaRespuestasExport;
use App\Http\Services\CommonService;
use App\Http\Services\SICAM32;
use App\Http\Services\UnidadProductivaService;
use App\Models\ProgramaConvocatoria;
use App\Models\Etapa;
use Illuminate\Http\Request;
use App\Models\ConvocatoriaInscripcion;
use App\Models\ConvocatoriaRespuesta;
use App\Models\InscripcionesRequisitos;
use App\Models\RequisitosOpciones;
use Maatwebsite\Excel\Facades\Excel;

class ProgramaController extends Controller
{
    public function index()
    {
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
        $fechaActual = date('Y-m-d');
        
        $programas_inscrito = ProgramaConvocatoria::with('programa')
            ->whereHas('inscripciones', function ($query) use ($unidadProductiva) {
                $query->where('unidadproductiva_id', $unidadProductiva->unidadproductiva_id);
            })
            ->where('fecha_apertura_convocatoria', '<=', $fechaActual)
            ->get();
    
        $programs_recommend = $this->getRecomendados($unidadProductiva, $fechaActual);

        $programas_otros = ProgramaConvocatoria::with('programa')
            ->whereHas('programa', function ($query) use ($unidadProductiva) {
                $query->whereDoesntHave('etapas', function ($q) use ($unidadProductiva) {
                    $q->where('etapas.etapa_id', $unidadProductiva->etapa_id);
                });
            })
            ->where('fecha_apertura_convocatoria', '<=', $fechaActual)
            ->where('fecha_cierre_convocatoria', '>=', $fechaActual)->get();
    
 
        $helper_default = [
            'title' => 'Bienvenido',
            'message' => 'Te invitamos a seleccionar una opción del panel lateral izquierdo. En el menú principal, puedes seleccionar entre visualizar perfil, programas, cápsulas o cerrar sesión.',
        ];
       
        $data = [
            'footer' => CommonService::footer(),
            'links' => CommonService::links(),
            'helper_notifications' => CommonService::notificaciones($helper_default),
            'programas_inscrito' => $programas_inscrito,
            'programas_otros' => $programas_otros,
            'programs_recommend' => $programs_recommend,
      
            'unidadProductiva' => $unidadProductiva,
            'nombreEtapa' => $unidadProductiva->etapa?->name, 
        ];
        
        return view('website.program.index', $data);
    }

    public function programShow(Request $request)
    {
        
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();        
        $convocatoria = ProgramaConvocatoria::join('programas', 'programas.programa_id', '=', 'programas_convocatorias.programa_id')
            ->where('convocatoria_id', $request->id)
            ->with('programa')->first();
        
        if (!$convocatoria) {
            return redirect()->route('programas.index')
                ->withErrors(['error' => 'El programa no fue encontrado.']);
        }

        $fechaActual = date('Y-m-d');
        $programs_recommend = $this->getRecomendados($unidadProductiva, $fechaActual);
        
        $can_apply = false;
        $already_subscribed = false;

        $program_validation = $programs_recommend->where('convocatoria_id', $convocatoria->convocatoria_id);
        $can_apply = count($program_validation) > 0;
    
        $inscripcion = ConvocatoriaInscripcion::where('convocatoria_id', $convocatoria->convocatoria_id)
            ->where('unidadproductiva_id', $unidadProductiva->unidadproductiva_id)
            ->latest()->first();
        $states = [0, 1, 3, 2, 4, 5]; // Estados en los cuales no puede volver a inscribirse en un programa
 
        if ($inscripcion && in_array($inscripcion->inscripcionestado_id, $states)) {
            $already_subscribed = true;
        }

        if($can_apply == true)
        {
            $indicadores = $convocatoria->requisitosIndicadores()->count();
            $requisitos = $convocatoria->requisitos()->count();
            
            $can_apply = ($indicadores + $requisitos) > 0;
        }
        
        $data = [
            'footer'=> CommonService::footer(),
            'links'=> CommonService::links(),
            'unidadProductiva'=> $unidadProductiva,
            'convocatoria'=> $convocatoria,
            'helper_notifications'=> CommonService::notificaciones(),
            'already_subscribed'=> $already_subscribed,
            'inscripcion'=> $inscripcion,
            'can_apply'=> $can_apply,
        ];

        return view('website.program.show', $data);
    }

    public function programRegister(Request $request)
    {
        $company =  UnidadProductivaService::getUnidadProductiva();
        $program = ProgramaConvocatoria::find($request->id);
        
        $inscripcion = $company->inscripciones()->where('convocatoria_id', $program->convocatoria_id)->first();
        
        if ( $inscripcion != null && $inscripcion->activarPreguntas != true ) {
            return redirect()->back()->with('error', 'Ya estas INSCRITO para este programa.');
        }

        if( $inscripcion == null )
        {
            //valide si la empresa ya se encuentra inscrita en alguno de los estados donde ya no puede volverse a inscribir en un programa
            // Deshabilitado temporalmente
            $exists = $company->inscripciones->whereIn('inscripcionestado_id', [1, 2]);
            if (count($exists) > 5) {
                return redirect()->back()->with('error', 'Ya hay cinco solicitudes activas para diferentes programas. No puede inscribirse en más de dos programas');
            }

            if ($program->con_matricula == "1") 
            {
                $api = SICAM32::consultarExpedienteMercantilporIdentificacion($company->nit);
                $values = $api->DATOS;

                if(!$values){
                    return redirect()->back()->with('error', 'No se encontró expediente mercantil asociado al nit ' . $company->nit);
                }
                UnidadProductivaService::validarRenovacion($values->fecharenovacion, $company->unidadproductiva_id);
                UnidadProductivaService::validarSiguienteRenovacion($values->fechamatricula, $values->fecharenovacion, $company->unidadproductiva_id);

                //Validamos que la API haya respondido de manera correcta
                if ($api->RESPUESTA != 'EXITO')
                    return redirect()->back()->with('error', 'No se pudo validar en este momento. Espere unos minutos e intente nuevamente');

                if ($values->estado != 'MA' && $values->estado != 'IA') {
                    // Si la empresa no tiene el estado MA, quiere decir que no ha renovado su matricula. Y debe crearse una alerta.
                    UnidadProductivaService::crearAlerta(0, $company->unidadproductiva_id);
                    return redirect()->back()->with('error', 'No se puede inscribir en este programa. La matrícula de su empresa no se encuentra activa');
                }
            }
        }

        $indicadores = $program->requisitosIndicadores()->get();
        $requisitos = $program->requisitos()->get();

        $variables = $indicadores->merge($requisitos);
        
        if (count($variables) == 0) {
            return redirect()->back()->with('error', 'No hay variables vinculadas al programa');
        }

        
        if( $inscripcion == null )
        {
            $fecha = now()->subMonth();

            /*
            * Recorremos las variables para saber si ya han sido respondidas anteriormente
            * Si encontramos que el usuario ha respondido esa misma variable, validamos el tiempo de respuesta.
            * Si es menor a 30 dias, eliminamos esa variable de la collection
            */
            foreach ($variables as $key => $variable) {
                $answer = ConvocatoriaRespuesta::
                    whereHas('inscripcion', function ($q) use($company){
                        $q->where('unidadproductiva_id', $company->unidadproductiva_id);
                    })
                    ->where('requisito_id', $variable->requisito_id)
                    ->where('fecha_creacion', '>=', $fecha)
                    ->get()->last();

                if ($answer == null)
                    continue;

                //Agrego el id de la variable ya respondida al array y remuevo variable de la collection
                $variables->forget($key);
            }
        }
        
        $data = [
            'footer'=> CommonService::footer(),
            'links'=> CommonService::links(),
            'program'=> $program,
            'variables'=> $variables,
            'volverApreguntar'=> $inscripcion != null && $inscripcion->activarPreguntas == true,
        ];
        
        return view('website.company.program_questions', $data);
    }

    public function applicationSave(Request $request) {

        $company =  UnidadProductivaService::getUnidadProductiva();
        $program = ProgramaConvocatoria::find($request->program);
        
        $fecha = now();
        
        $inscripcion = $company->inscripciones()
            ->where('convocatoria_id', $program->convocatoria_id)
            ->where('activarPreguntas', true)->first();

        if($inscripcion == null)
        {
            $inscripcion = New ConvocatoriaInscripcion();
            $inscripcion->unidadproductiva_id = $company->unidadproductiva_id;
            $inscripcion->convocatoria_id = $program->convocatoria_id;
            $inscripcion->inscripcionestado_id = 1;
            $inscripcion->comentarios = "Solicitud de registro enviada";
            $inscripcion->save();
        }

        $indicadores = $program->requisitosIndicadores()->get();
        $requisitos = $program->requisitos()->get();

        $variables = $indicadores->merge($requisitos);
        $fechaMenos1Mes = now()->subMonth();

        if($inscripcion != null && $inscripcion->activarPreguntas != true)
        {
            foreach ($variables as $key => $variable) {
                
                $answer = ConvocatoriaRespuesta::
                    whereHas('inscripcion', function ($q) use($company){
                        $q->where('unidadproductiva_id', $company->unidadproductiva_id);
                    })
                    ->where('requisito_id', $variable->requisito_id)
                    ->where('fecha_creacion', '>=', $fechaMenos1Mes)
                    ->get()->last();

                if ($answer != null)
                {
                    $respuesta = New ConvocatoriaRespuesta();
                    $respuesta->value = $answer->value;
                    $respuesta->inscripcion_id = $inscripcion->inscripcion_id;
                    $respuesta->requisito_id = $answer->requisito_id;
                    $respuesta->fecha_respuesta = $fecha;
                    $respuesta->save();
                }
            }
        }

        foreach ($request->all() as $key => $value) 
        {
            if( str_starts_with($key, 'variable-') )
            {
                $pregunta_id = str_replace('variable-', '', $key);

                $respuesta = New ConvocatoriaRespuesta();
                $pregunta = InscripcionesRequisitos::find($pregunta_id);
                
                if($pregunta->tipo->preguntatipo_opciones)
                {
                    $opcion = RequisitosOpciones::find($value);
                    $respuesta->value = $opcion->opcion_variable_response ?? $value;
                }
                else{
                    $respuesta->value = $value;
                }
                
                $respuesta->inscripcion_id = $inscripcion->inscripcion_id;
                $respuesta->requisito_id = $pregunta->requisito_id;
                $respuesta->fecha_respuesta = $fecha;
                $respuesta->save();
            }
        }

        $mensaje = 'Su solicitud se ha enviado correctamente';

        if($inscripcion != null && $inscripcion->activarPreguntas == true)
        {
            $inscripcion->activarPreguntas = false;
            $inscripcion->save();

            $mensaje = 'Gracias por sus respuestas';
        }
        
        return redirect()->route('company.program.show', ['id' => $program->convocatoria_id])
            ->with('success', $mensaje);
    }

    public function exportarPreguntasInscripcionConvocatoria($id)
    {
        return Excel::download(new InscripcionConvocatoriaRespuestasExport($id), 'inscripcion-respuestas.xlsx');
    }
    
    public function capsulas() {
        
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();
    
        // Get the current stage of the unit and its name
        $etapa = Etapa::find($unidadProductiva->etapa_id);
        $nombreEtapa = $etapa ? $etapa->name : 'Etapa no encontrada';
        
        $helper_default = [
            'title' => 'Recomendación para la sección de cápsulas',
            'message' => 'Visualiza las cápsulas que sean de mayor interés para tu empresa. Nuestras cápsulas te ayudarán a mejorar tu desempeño en el proceso de crecimiento',
        ];
    
        $data = [
            'company' => $unidadProductiva,
            'capsules' => CommonService::capsulas(),
            'helper_notifications' => CommonService::notificaciones($helper_default),
            'nombreEtapa' => $nombreEtapa, // Pass the stage name to the view
        ];
    
        return view('website.capsule.index', $data);
    }

    private function getRecomendados($unidadProductiva, $fechaActual)
    {
        $programs_recommend1 = ProgramaConvocatoria::query()
            ->where('fecha_apertura_convocatoria', '<=', $fechaActual)
            ->where('fecha_cierre_convocatoria', '>=', $fechaActual)
            ->where('con_matricula', 1)
            ->where(function ($query) use ($unidadProductiva) {

                if (is_null($unidadProductiva->registration_number)||$unidadProductiva->registration_number='') {
                    $query->where('con_matricula', -1);
                }

                $query->whereHas('programa', function ($q) use ($unidadProductiva) {
                    $q->whereHas('etapas', function ($subQuery) use ($unidadProductiva) {
                        $subQuery->where('etapas.etapa_id', $unidadProductiva->etapa_id);
                    })
                    ->where(function ($q) use ($unidadProductiva) {
                        $q->whereNotNull('sector_id')
                        ->where('sector_id', $unidadProductiva->sector_id)
                        ->orWhereNull('sector_id');
                    });
                });
            })
            ->with('programa')->get();

        $programs_recommend2 = ProgramaConvocatoria::query()
            ->where('fecha_apertura_convocatoria', '<=', $fechaActual)
            ->where('fecha_cierre_convocatoria', '>=', $fechaActual)
            ->where('con_matricula', '!=', 1)
            ->where(function ($query) use ($unidadProductiva) {
                
                $query->whereHas('programa', function ($q) use ($unidadProductiva) {
                    $q->whereHas('etapas', function ($subQuery) use ($unidadProductiva) {
                        $subQuery->where('etapas.etapa_id', $unidadProductiva->etapa_id);
                    })
                    ->where(function ($q) use ($unidadProductiva) {
                        $q->whereNotNull('sector_id')
                        ->where('sector_id', $unidadProductiva->sector_id)
                        ->orWhereNull('sector_id');
                    });
                });
                
            })
            ->with('programa')->get();

        return $programs_recommend1->merge($programs_recommend2);
    }

   
}
