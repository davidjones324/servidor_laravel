<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $query = Empresa::query();

        if ($request->filled('search')) {
            $query->where('razon_social', 'LIKE', $request->input('search') . '%');
        }

        if ($request->filled('ciclo')) {
            $query->whereJsonContains('ciclos', $request->input('ciclo'));
        }

        $empresas = $query->paginate(10)->withQueryString();

        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'razon_social' => 'required|string|max:255',
            'cif' => 'required|string|max:20|unique:empresas,cif',
            'direccion' => 'required|string|max:255',
            'poblacion' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'ciclos' => 'required|array',
            'observaciones' => 'nullable|string',
            'telefono' => 'nullable|string|max:50',
            'horario' => 'nullable|string|max:255',
        ]);


        Empresa::create($validated);

        return redirect()->route('empresas.index')->with('success', 'Empresa creada correctamente.');
    }

    public function show(Empresa $empresa)
    {
        return view('empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $validated = $request->validate([
            'razon_social' => 'required|string|max:255',
            'cif' => 'required|string|max:20|unique:empresas,cif,' . $empresa->id,
            'direccion' => 'required|string|max:255',
            'poblacion' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'ciclos' => 'required|array',
            'observaciones' => 'nullable|string',
            'telefono' => 'nullable|string|max:50',
            'horario' => 'nullable|string|max:255',
        ]);

        $empresa->update($validated);

        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada correctamente.');
    }
}
