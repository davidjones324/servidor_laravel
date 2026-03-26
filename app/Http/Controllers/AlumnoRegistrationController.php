<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\RespuestaFormularioAlumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlumnoRegistrationController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        $alumno = $user->alumno ?? new Alumno();
        $respuesta = $alumno->respuestaFormulario ?? new RespuestaFormularioAlumno();

        return view('alumno.registro', compact('alumno', 'respuesta'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedRespuesta = $request->validate([
            'desplazamiento' => 'required|string|max:255',
            'observaciones_desplazamiento' => 'nullable|string',
            'segunda_residencia' => 'nullable|string',
            'ciclo_distinto' => 'required|string|max:255',
            'ha_hecho_fct_antes' => 'boolean',
            'empresa_fct_anterior' => 'nullable|string|max:255',
            'poblacion_fct_anterior' => 'nullable|string|max:255',
            'interes_practicas' => 'nullable|in:mucho,normal,poco,muy_poco',
            'interes_seguir_estudiando' => 'nullable|in:mucho,normal,poco,muy_poco',
            'interes_quedarse_empresa' => 'nullable|in:mucho,normal,poco,muy_poco',
            'interes_compartir_empresa' => 'nullable|in:mucho,normal,poco,muy_poco',
            'miedo_practicas' => 'nullable|in:mucho,normal,poco,muy_poco',
            'actitud_practicas' => 'nullable|in:mucho,normal,poco,muy_poco',
            'empresa_destino_practicas' => 'nullable|string',
            'tiene_empresa_pensada' => 'nullable|in:si,no,si_sin_contacto',
            'empresa_pensada_nombre' => 'nullable|string|max:255',
            'empresa_pensada_localidad' => 'nullable|string|max:150',
            'empresa_pensada_telefono' => 'nullable|string|max:20',
            'empresa_pensada_contacto' => 'nullable|string|max:150',
            'otras_empresas_interes' => 'nullable|string',
            'observaciones_empresas' => 'nullable|string',
        ]);

        DB::transaction(function () use ($user, $validatedRespuesta) {
            $alumno = $user->alumno;

            // Si no está vinculado, intentar buscar por email que pasaremos desde seneca
            if (!$alumno) {
                $alumno = Alumno::where('email', $user->email)->first();
                if ($alumno) {
                    $alumno->update(['user_id' => $user->id]);
                }
                else {
                    // Si el profesor aún no lo ha subido de séneca, lo creamos vacío por ahora para que no falle.
                    $alumno = Alumno::create([
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'nombre' => $user->name ?? 'Pendiente Seneca',
                        'apellidos' => 'Pendiente Seneca',
                        'fecha_nacimiento' => now(),
                        'curso' => '2025/2026',
                        'grupo' => 'Pendiente',
                        'direccion' => 'Pendiente Seneca',
                        'telefono' => 'Pendiente',
                    ]);
                }
            }

            $alumno->respuestaFormulario()->updateOrCreate(
            ['alumno_id' => $alumno->id],
                $validatedRespuesta
            );

            // Sincronizar campos relevantes con la tabla alumnos
            $desplazamiento = $validatedRespuesta['desplazamiento'] ?? null;
            $alumnoSyncData = [
                'segunda_residencia' => $validatedRespuesta['segunda_residencia'] ?? null,
                'ha_realizado_fct_anterior' => !empty($validatedRespuesta['ha_hecho_fct_antes']),
                'empresa_fct_anterior' => $validatedRespuesta['empresa_fct_anterior'] ?? null,
                'localidad_fct_anterior' => $validatedRespuesta['poblacion_fct_anterior'] ?? null,
            ];

            // Mapear desplazamiento a campos de transporte del alumno
            $mapDesplazamientoToTransporte = [
                'coche_y_carnet' => ['carnet_conducir' => true, 'coche_propio' => true, 'transporte' => 'carnet_y_coche'],
                'solo_coche' => ['carnet_conducir' => false, 'coche_propio' => true, 'transporte' => 'carnet_y_coche'],
                'solo_carnet' => ['carnet_conducir' => true, 'coche_propio' => false, 'transporte' => 'carnet_y_coche'],
                'transporte_escolar' => ['carnet_conducir' => false, 'coche_propio' => false, 'transporte' => 'transporte_publico'],
                'no_puedo' => ['carnet_conducir' => false, 'coche_propio' => false, 'transporte' => 'sin_desplazamiento'],
            ];

            if (isset($mapDesplazamientoToTransporte[$desplazamiento])) {
                $alumnoSyncData = array_merge($alumnoSyncData, $mapDesplazamientoToTransporte[$desplazamiento]);
            }

            $alumno->update($alumnoSyncData);
        });

        return redirect()->route('dashboard')->with('success', 'Tu perfil y encuesta han sido actualizados correctamente.');
    }
}
