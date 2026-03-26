<?php

namespace App\Http\Controllers;

use App\Models\TutorDual;
use Illuminate\Http\Request;

class TutorDualController extends Controller
{
    public function index(Request $request)
    {
        $query = TutorDual::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'LIKE', $search . '%');
        }

        if ($request->filled('ciclo')) {
            $query->whereJsonContains('ciclos', $request->input('ciclo'));
        }

        if ($request->filled('curso')) {
            $query->whereJsonContains('cursos', $request->input('curso'));
        }

        if ($request->filled('grupo')) {
            $grupoSearch = $request->input('grupo');
            $query->where(function ($q) use ($grupoSearch) {
                $q->where('grupo', 'LIKE', '%' . $grupoSearch . '%')
                    ->orWhere('grupos', 'LIKE', '%' . $grupoSearch . '%');
            });
        }

        $tutores = $query->paginate(10)->withQueryString();

        return view('tutor_duals.index', compact('tutores'));
    }

    public function create()
    {
        return view('tutor_duals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:20',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'telefono' => 'required|string|max:20',
            'ciclos' => 'required|array',
            'ciclos.*' => 'in:ASIR,SMR,DAM',
            'cursos' => 'nullable|array',
            'grupo' => 'nullable|string|max:50',
            'grupos' => 'nullable|array',
        ]);

        TutorDual::create($validated);

        return redirect()->route('tutores.index')->with('success', 'Tutor Dual creado correctamente.');
    }

    public function show(TutorDual $tutor)
    {
        return view('tutor_duals.show', compact('tutor'));
    }

    public function edit(TutorDual $tutor)
    {
        return view('tutor_duals.edit', compact('tutor'));
    }

    public function update(Request $request, TutorDual $tutor)
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:20',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'telefono' => 'required|string|max:20',
            'ciclos' => 'required|array',
            'ciclos.*' => 'in:ASIR,SMR,DAM',
            'cursos' => 'nullable|array',
            'grupos' => 'nullable|array',
        ]);

        $tutor->update($validated);

        return redirect()->route('tutores.index')->with('success', 'Tutor Dual actualizado correctamente.');
    }

    public function destroy(TutorDual $tutor)
    {
        $tutor->delete();
        return redirect()->route('tutores.index')->with('success', 'Tutor Dual eliminado correctamente.');
    }
}
