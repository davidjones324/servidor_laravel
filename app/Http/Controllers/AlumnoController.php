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
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', $search . '%')
                    ->orWhere('apellidos', 'LIKE', $search . '%');
            });
        }

        if ($request->filled('ciclo')) {
            $query->where('ciclo', $request->input('ciclo'));
        }

        $alumnos = $query->paginate(10)->withQueryString();

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
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:150|unique:alumnos,email',
            'carnet_conducir' => 'boolean',
            'coche_propio' => 'boolean',
            'estudios_anteriores' => 'nullable|string',
            'practicas_pasadas' => 'nullable|string|max:255',
            'apto_ffoe' => 'boolean',
            'motivo_exclusion' => 'nullable|in:no_prl,matricula_incompleta,otros',
            'residencia' => 'nullable|string|max:150',
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
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:150|unique:alumnos,email,' . $alumno->id,
            'carnet_conducir' => 'boolean',
            'coche_propio' => 'boolean',
            'estudios_anteriores' => 'nullable|string',
            'practicas_pasadas' => 'nullable|string|max:255',
            'apto_ffoe' => 'boolean',
            'motivo_exclusion' => 'nullable|in:no_prl,matricula_incompleta,otros',
            'residencia' => 'nullable|string|max:150',
        ]);

        $alumno->update($validated);

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}
