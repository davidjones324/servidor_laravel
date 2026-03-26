<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumno::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', $search . '%')
                    ->orWhere('apellidos', 'LIKE', $search . '%');
            });
        }

        if ($request->filled('ciclo')) {
            $query->where('ciclo', $request->input('ciclo'));
        }

        if ($request->filled('grupo')) {
            $query->where('grupo', $request->input('grupo'));
        }

        if ($request->filled('curso')) {
            $query->where('curso', $request->input('curso'));
        }

        $alumnos = $query->orderBy('apellidos')->paginate(10)->withQueryString();

        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'dni' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'curso' => 'required|string|max:20',
            'grupo' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'domicilio' => 'required|string|max:255',
            'localidad' => 'nullable|string|max:150',
            'codigo_postal' => 'nullable|string|max:10',
            'provincia' => 'nullable|string|max:100',
            'numero_ss' => 'nullable|string|max:20',
            'seguro_escolar' => 'boolean',
            'ciclo' => 'nullable|string|max:255',
            'anio_ciclo' => 'nullable|string|max:50',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:150|unique:alumnos,email',
            'carnet_conducir' => 'boolean',
            'coche_propio' => 'boolean',
            'estudios_anteriores' => 'nullable|string',
            'practicas_pasadas' => 'nullable|string|max:255',
            'apto_ffoe' => 'boolean',
            'motivo_exclusion' => 'nullable|string|max:255',
            'residencia' => 'nullable|string|max:150',
            'segunda_residencia' => 'nullable|string|max:255',
            'ha_realizado_fct_anterior' => 'boolean',
            'empresa_fct_anterior' => 'nullable|string|max:150',
            'localidad_fct_anterior' => 'nullable|string|max:150',
            'observaciones' => 'nullable|string',
        ]);

        Alumno::create($validated);

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente.');
    }

    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        $alumno->load('matriculas');
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'dni' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'curso' => 'required|string|max:20',
            'grupo' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'domicilio' => 'required|string|max:255',
            'localidad' => 'nullable|string|max:150',
            'codigo_postal' => 'nullable|string|max:10',
            'provincia' => 'nullable|string|max:100',
            'numero_ss' => 'nullable|string|max:20',
            'seguro_escolar' => 'boolean',
            'ciclo' => 'nullable|string|max:255',
            'anio_ciclo' => 'nullable|string|max:50',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:150|unique:alumnos,email,' . $alumno->id,
            'carnet_conducir' => 'boolean',
            'coche_propio' => 'boolean',
            'estudios_anteriores' => 'nullable|string',
            'practicas_pasadas' => 'nullable|string|max:255',
            'apto_ffoe' => 'boolean',
            'motivo_exclusion' => 'nullable|string|max:255',
            'residencia' => 'nullable|string|max:150',
            'segunda_residencia' => 'nullable|string|max:255',
            'ha_realizado_fct_anterior' => 'boolean',
            'empresa_fct_anterior' => 'nullable|string|max:150',
            'localidad_fct_anterior' => 'nullable|string|max:150',
            'observaciones' => 'nullable|string',
        ]);

        // Lógica para historial de matrículas automático
        $academicFields = ['ciclo', 'anio_ciclo', 'grupo', 'curso'];
        $changed = false;
        foreach ($academicFields as $field) {
            if ($alumno->$field != $request->$field) {
                $changed = true;
                break;
            }
        }

        if ($changed) {
            // Guardamos el estado anterior como una matrícula histórica
            \App\Models\Matricula::create([
                'alumno_id' => $alumno->id,
                'anio_academico' => $alumno->curso, // En Alumno 'curso' suele ser el año (2023/24)
                'ciclo' => $alumno->ciclo,
                'curso' => $alumno->anio_ciclo, // En Alumno 'anio_ciclo' es el curso (1º, 2º)
                'grupo' => $alumno->grupo,
            ]);
        }

        $alumno->update($validated);

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}
