<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\RespuestaFormularioAlumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormularioAlumnoController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $alumno = $user->alumno;

        if (!$alumno) {
            return redirect()->route('alumno.registro');
        }

        $respuesta = $alumno->respuestaFormulario ?? new RespuestaFormularioAlumno();

        return view('alumno.registro', compact('alumno', 'respuesta'));
    }

    public function show(Alumno $alumno)
    {
        $respuesta = $alumno->respuestaFormulario;

        if (!$respuesta) {
            return redirect()->back()->with('error', 'Este alumno aún no ha respondido el cuestionario.');
        }

        return view('alumno.respuestas', compact('alumno', 'respuesta'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $alumno = $user->alumno;

        if (!$alumno) {
            return redirect()->route('alumno.registro');
        }

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

        return redirect()->route('dashboard')->with('success', 'Formulario actualizado correctamente.');
    }
}
