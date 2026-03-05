<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    public function index(Request $request)
    {
        $query = Responsable::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', $search . '%')
                    ->orWhere('apellidos', 'LIKE', $search . '%');
            });
        }

        $responsables = $query->paginate(10);
        return view('responsables.index', compact('responsables'));
    }

    public function create()
    {
        return view('responsables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:20|unique:responsables,dni',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|unique:responsables,email',
            'telefono' => 'required|string|max:20',
            'cargo' => 'nullable|string|max:100',
        ]);

        Responsable::create($validated);

        return redirect()->route('responsables.index')->with('success', 'Responsable creado correctamente.');
    }

    public function show(Responsable $responsable)
    {
        return view('responsables.show', compact('responsable'));
    }

    public function edit(Responsable $responsable)
    {
        return view('responsables.edit', compact('responsable'));
    }

    public function update(Request $request, Responsable $responsable)
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:20|unique:responsables,dni,' . $responsable->id,
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|unique:responsables,email,' . $responsable->id,
            'telefono' => 'required|string|max:20',
            'cargo' => 'nullable|string|max:100',
        ]);

        $responsable->update($validated);

        return redirect()->route('responsables.index')->with('success', 'Responsable actualizado correctamente.');
    }

    public function destroy(Responsable $responsable)
    {
        $responsable->delete();
        return redirect()->route('responsables.index')->with('success', 'Responsable eliminado correctamente.');
    }
}
