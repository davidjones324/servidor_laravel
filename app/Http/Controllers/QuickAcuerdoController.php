<?php

namespace App\Http\Controllers;

use App\Models\Acuerdo;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\TutorDual;
use App\Models\EstadoAcuerdo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuickAcuerdoController extends Controller
{
    public function getData()
    {
        try {
            $alumnos = Alumno::with(['acuerdos', 'matriculas', 'respuestaFormulario'])->get()->map(function ($a) {
                $latestMatricula = $a->matriculas->sortByDesc('anio_academico')->first();
                return [
                'id' => $a->id,
                'nombre' => $a->nombre . ' ' . $a->apellidos,
                'ciclo' => $latestMatricula->ciclo ?? $a->ciclo,
                'curso' => $latestMatricula->anio_academico ?? $a->curso, // En QuickAcuerdo 'curso' suele ser el año académico
                'grupo' => $latestMatricula->grupo ?? $a->grupo,
                'anio_ciclo' => $latestMatricula->curso ?? $a->anio_ciclo, // En QuickAcuerdo 'anio_ciclo' es 1 o 2
                'localidad' => $a->localidad,
                'residencia' => $a->residencia,
                'segunda_residencia' => $a->segunda_residencia,
                'numero_ss' => $a->numero_ss,
                'seguro_escolar' => (bool)$a->seguro_escolar,
                'acuerdos_count' => $a->acuerdos->count(),
                'has_empresa' => $a->acuerdos->count() > 0,
                'incompleto' => empty($a->numero_ss) || !$a->seguro_escolar,
                'empresa_deseada' => $a->respuestaFormulario->empresa_pensada_nombre ?? null,
                'localidad_deseada' => $a->respuestaFormulario->empresa_pensada_localidad ?? null,
                ];
            });

            $empresas = Empresa::with('contactos')->get()->map(function ($e) {
                return [
                'id' => $e->id,
                'razon_social' => $e->razon_social,
                'localidad' => $e->poblacion,
                'ciclos' => is_array($e->ciclos) ? $e->ciclos : [],
                'contactos' => $e->contactos->map(function ($c) {
                        return [
                        'id' => $c->id,
                        'nombre' => $c->nombre . ' ' . $c->apellidos
                        ];
                    }
                    )
                    ];
                });

            $tutores = TutorDual::all()->map(function ($t) {
                return [
                'id' => $t->id,
                'nombre' => $t->nombre . ' ' . $t->apellidos,
                'ciclos' => is_array($t->ciclos) ? $t->ciclos : [],
                'cursos' => is_array($t->cursos) ? $t->cursos : [],
                'grupos' => is_array($t->grupos) ? $t->grupos : [],
                ];
            });


            // Opciones únicas para filtros
            $ciclos = collect(['DAM', 'ASIR', 'SMR']); // Hardcoded based on user request "dam, asir o smr"
            $cursos = ['1º', '2º'];

            $estados = EstadoAcuerdo::all()->map(function ($e) {
                return ['id' => $e->id, 'nombre' => $e->nombre];
            });

            return response()->json([
                'alumnos' => $alumnos,
                'empresas' => $empresas,
                'tutores' => $tutores,
                'estados' => $estados,
                'options' => [
                    'ciclos' => $ciclos,
                    'cursos' => $cursos
                ]
            ]);
        }
        catch (\Exception $e) {
            \Log::error('QuickAcuerdo API Array Data Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'empresa_id' => 'required|exists:empresas,id',
            'tutor_dual_id' => 'required|exists:tutor_duals,id',
        ]);

        try {
            $alumno = Alumno::findOrFail($request->alumno_id);
            $empresa = Empresa::with('contactos')->findOrFail($request->empresa_id);

            // Seleccionar representante legal automáticamente
            $representante = $empresa->contactos->where('is_representante_legal', true)->first() ?? $empresa->contactos->first();

            // Seleccionar contacto automáticamente (priorizar tutor laboral FCT)
            $contacto = $empresa->contactos->where('es_tutor_laboral_fct', true)->first() ?? $empresa->contactos->first();

            // Determinar el grupo para el acuerdo
            $grupoFinal = $alumno->grupo ?? 'A';
            $tutor = TutorDual::find($request->tutor_dual_id);
            if ($tutor && is_array($tutor->grupos) && !empty($alumno->curso) && isset($tutor->grupos[$alumno->curso])) {
                $grupoFinal = $tutor->grupos[$alumno->curso];
            }

            $estadoPendiente = EstadoAcuerdo::where('nombre', 'Pendiente')->first();

            $latestMatricula = $alumno->matriculas->sortByDesc('anio_academico')->first();

            $acuerdo = Acuerdo::create([
                'alumno_id' => $alumno->id,
                'empresa_id' => $empresa->id,
                'tutor_dual_id' => $request->tutor_dual_id,
                'representante_id' => $representante ? $representante->id : null,
                'contacto_empresa_id' => $contacto ? $contacto->id : null,
                'nombre_acuerdo' => 'Acuerdo ' . $alumno->nombre . ' - ' . $empresa->razon_social,
                'localidad' => $empresa->poblacion ?? 'Pendiente',
                'estado_id' => $estadoPendiente ? $estadoPendiente->id : null,
                'horas_totales' => 400,
                'curso' => $latestMatricula->curso ?? $alumno->anio_ciclo ?? '2º',
                'ciclo' => $latestMatricula->ciclo ?? $alumno->ciclo ?? 'S/C',
                'ano_academico' => $latestMatricula->anio_academico ?? $request->ano_academico ?: $this->getCurrentAcademicYear(),
                'grupo' => $grupoFinal,
                'tiene_seguro' => (bool)($request->tiene_seguro ?? $alumno->seguro_escolar),
            ]);

            return response()->json([
                'success' => true,
                'redirect' => route('acuerdos.index')
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'acuerdos' => 'required|array',
            'acuerdos.*.alumno_id' => 'required|exists:alumnos,id',
            'acuerdos.*.empresa_id' => 'required|exists:empresas,id',
            'acuerdos.*.tutor_dual_id' => 'required|exists:tutor_duals,id',
        ]);

        $count = 0;
        DB::beginTransaction();
        try {
            foreach ($request->acuerdos as $data) {
                $alumno = Alumno::find($data['alumno_id']);
                $empresa = Empresa::with('contactos')->find($data['empresa_id']);

                // Representante legal
                $representante = $empresa->contactos->where('is_representante_legal', true)->first() ?? $empresa->contactos->first();

                // Tutor laboral
                $contacto = $empresa->contactos->where('es_tutor_laboral_fct', true)->first() ?? $empresa->contactos->first();

                // Determinar el grupo para el acuerdo
                $grupoFinal = $alumno->grupo ?? 'A';
                $tutor = TutorDual::find($data['tutor_dual_id']);
                if ($tutor && is_array($tutor->grupos) && !empty($alumno->curso) && isset($tutor->grupos[$alumno->curso])) {
                    $grupoFinal = $tutor->grupos[$alumno->curso];
                }

                $estadoPendiente = EstadoAcuerdo::where('nombre', 'Pendiente')->first();

                $latestMatricula = $alumno->matriculas->sortByDesc('anio_academico')->first();

                Acuerdo::create([
                    'alumno_id' => $alumno->id,
                    'empresa_id' => $empresa->id,
                    'tutor_dual_id' => $data['tutor_dual_id'],
                    'representante_id' => $representante ? $representante->id : null,
                    'contacto_empresa_id' => $contacto ? $contacto->id : null,
                    'nombre_acuerdo' => 'Acuerdo ' . $alumno->nombre . ' - ' . $empresa->razon_social,
                    'localidad' => $empresa->poblacion ?? 'Pendiente',
                    'estado_id' => $estadoPendiente ? $estadoPendiente->id : null,
                    'horas_totales' => 400,
                    'curso' => $latestMatricula->curso ?? $alumno->anio_ciclo ?? '2º',
                    'ciclo' => $latestMatricula->ciclo ?? $alumno->ciclo ?? 'S/C',
                    'ano_academico' => $latestMatricula->anio_academico ?? $data['ano_academico'] ?? $this->getCurrentAcademicYear(),
                    'grupo' => $grupoFinal,
                    'tiene_seguro' => (bool)($data['tiene_seguro'] ?? $alumno->seguro_escolar),
                ]);
                $count++;
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => "Se han creado $count acuerdos correctamente."]);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function updateAlumnoStatus(Request $request, Alumno $alumno)
    {
        $request->validate([
            'numero_ss' => 'nullable|string|max:50',
            'seguro_escolar' => 'required|boolean'
        ]);

        $alumno->update([
            'numero_ss' => $request->numero_ss,
            'seguro_escolar' => $request->seguro_escolar
        ]);

        return response()->json(['success' => true]);
    }

    private function getCurrentAcademicYear()
    {
        $month = date('n');
        $year = date('Y');
        if ($month < 9) {
            return ($year - 1) . '/' . substr($year, -2);
        }
        return $year . '/' . substr($year + 1, -2);
    }
}
