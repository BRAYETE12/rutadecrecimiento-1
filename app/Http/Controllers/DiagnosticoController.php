<?php

namespace App\Http\Controllers;

use App\Http\Services\CommonService;
use App\Http\Services\UnidadProductivaService;
use App\Models\Diagnostico;
use App\Models\DiagnosticoPregunta;
use App\Models\DiagnosticoRespuesta;
use App\Models\DiagnosticoResultado;
use App\Models\PreguntaOpcion;
use App\Models\VentasAnuales;
use App\Models\PreguntaGrupo;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{

    public function index(Request $request)
    {
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();

        if ($request->anual_sales != null) {
            $unidadProductiva->anual_sales = $request->anual_sales;
            $unidadProductiva->save();
        }

        $data = [
            'footer' => CommonService::footer(),
            'links' => CommonService::links(),
            'company' => $unidadProductiva,
            'arranquePOR' => UnidadProductivaService::validarDiagnostico($unidadProductiva),
        ];

        if ($unidadProductiva->anual_sales != null) {
            $diagnostico = Diagnostico::where([
                ['diagnostico_etapa_id', $unidadProductiva->etapa_id],
                ['diagnostico_conventas', $unidadProductiva->anual_sales]
            ])->first();

            if ($diagnostico == null) {
                $diagnostico = Diagnostico::where([
                    ['diagnostico_etapa_id', null],
                    ['diagnostico_conventas', $unidadProductiva->anual_sales == 1]
                ])->first();
            }

            if ($diagnostico->diagnostico_conventas) {
                $data['preguntas'] =
                    DiagnosticoPregunta::where('pregunta_rango_ventas', 1)
                    ->union(
                        DiagnosticoPregunta::whereNull('diagnostico_id')->where('pregunta_rango_ventas', '!=', 1)
                    )
                    ->union(
                        DiagnosticoPregunta::where('diagnostico_id', $diagnostico->diagnostico_id)
                    )
                    ->get();
            } else {
                $data['preguntas'] = DiagnosticoPregunta::whereNull('diagnostico_id')->where('pregunta_rango_ventas', '!=', 1)
                    ->union(
                        DiagnosticoPregunta::where('diagnostico_id', $diagnostico->diagnostico_id)
                    )
                    ->get();
            }

            $data['preguntas']->load('opciones');

            if ($diagnostico->diagnostico_conventas) {
                $sector = $unidadProductiva->sector()->first();
                $opciones = VentasAnuales::where('sectorCODIGO',  $sector->sectorCODIGO)->get();

                if (isset($data['preguntas'][0]) && isset($data['preguntas'][0]->opciones)) {
                    $data['preguntas'][0]->setRelation('opciones', collect([]));
                }

                foreach ($opciones as $opcion) {
                    $item = new PreguntaOpcion();
                    $item->opcion_id = $opcion->VentasAnualesOpcionID;
                    $item->opcion_variable_response = $opcion->ventasAnualesNOMBRE;

                    $data['preguntas'][0]->opciones->push($item);
                }
            }

            $data['diagnosticoId'] = $diagnostico->diagnostico_id;
        }

        return view('website.company.diagnostic', $data);
    }

    public function store(Request $request)
    {
        $unidadProductiva = UnidadProductivaService::getUnidadProductiva();

        $diagnostico = new DiagnosticoResultado();
        $diagnostico->unidadproductiva_id = $unidadProductiva->unidadproductiva_id;
        $diagnostico->resultado_puntaje = 0;
        $diagnostico->save();

        $unidadProductiva->etapa_id = 1;
        $grupos = PreguntaGrupo::all();
        $suma_grupos = [];
        $ventaanual_id = 1;

        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'variable-')) {
                $pregunta_id = str_replace('variable-', '', $key);

                $pregunta = DiagnosticoPregunta::find($pregunta_id);
                $opcion = PreguntaOpcion::find($value);

                $respuesta = new DiagnosticoRespuesta();
                $respuesta->resultado_id = $diagnostico->resultado_id;
                $respuesta->pregunta_id = $pregunta->pregunta_id;
                $respuesta->diagnosticorespuesta_valor = $opcion->opcion_variable_response;
                $respuesta->diagnosticorespuesta_porcentaje = $opcion->opcion_percentage;
                $respuesta->save();

                if (!isset($suma_grupos[$pregunta->preguntagrupo_id])) {
                    $suma_grupos[$pregunta->preguntagrupo_id] = 0;
                }

                $suma_grupos[$pregunta->preguntagrupo_id] += ($pregunta->pregunta_porcentaje / 100) * ($opcion->opcion_percentage);

                if ($pregunta->pregunta_rango_ventas) {
                    $ventaanual_id = $opcion->opcion_id;
                }
            }
        }

        if ($unidadProductiva->anual_sales == 1) {
            $unidadProductiva->ventaanual_id = $ventaanual_id;

            $venta = VentasAnuales::find($ventaanual_id);
            $unidadProductiva->tamano_id = $venta->tamano_id;
        }

        $resultado_puntaje = 0;
        foreach ($grupos as $grupo) {
            $resultado_puntaje += $suma_grupos[$grupo->preguntagrupo_id] * ($grupo->preguntagrupo_peso / 100);
        }

        $unidadProductiva->etapa_id = UnidadProductivaService::getEtapa($resultado_puntaje);
        $diagnostico->resultado_puntaje = $resultado_puntaje;
        $diagnostico->etapa_id = $unidadProductiva->etapa_id;
        $diagnostico->save();

        if ($unidadProductiva->forzar_diagnostico == 1)
            $unidadProductiva->forzar_diagnostico = 0;

        $unidadProductiva->complete_diagnostic = 1;
        $unidadProductiva->save();

        // Enviar correo de diagnóstico completado
        if ($unidadProductiva->user_id) {
            $user = \App\Models\User::find($unidadProductiva->user_id);
            if ($user) {
                $nombreUsuario = $user->name . ' ' . $user->lastname;
                $etapa = \App\Models\Etapa::find($unidadProductiva->etapa_id);
                $nombreEtapa = $etapa ? $etapa->name : 'Etapa no definida';
                
                \App\Http\Services\EmailService::enviarCorreoDiagnosticoCompletado(
                    $unidadProductiva->registration_email, 
                    $nombreUsuario, 
                    $unidadProductiva->business_name, 
                    $resultado_puntaje, 
                    $nombreEtapa
                );
            }
        }

        return redirect()->route('company.dashboard');
    }
}
