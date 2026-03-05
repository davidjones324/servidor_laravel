<?php

namespace App\Http\Controllers;

use App\Models\ContactoEmpresa;
use App\Models\Empresa;
use Illuminate\Http\Request;

class ContactoEmpresaController extends Controller
{
    public function index()
    {
        $contactos = ContactoEmpresa::with('empresa')->paginate(10);
        return view('contactos.index', compact('contactos'));
    }

    public function create(Request $request)
    {
        $empresas = Empresa::all();
        $selected_empresa_id = $request->query('empresa_id');
        return view('contactos.create', compact('empresas', 'selected_empresa_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:150',
            'dni' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'telefono' => 'required|string|max:20',
            'puesto' => 'nullable|string|max:100',
        ]);

        // Map 'email' from form to 'correo' for database
        $data = $validated;
        $data['correo'] = $validated['email'] ?? null;
        unset($data['email']);

        ContactoEmpresa::create($data);

        return redirect()->route('empresas.show', $request->empresa_id)->with('success', 'Contacto creado correctamente.');
    }

    public function edit(ContactoEmpresa $contacto)
    {
        $empresas = Empresa::all();
        return view('contactos.edit', compact('contacto', 'empresas'));
    }

    public function update(Request $request, ContactoEmpresa $contacto)
    {
        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:150',
            'dni' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'telefono' => 'required|string|max:20',
            'puesto' => 'nullable|string|max:100',
        ]);

        // Map 'email' from form to 'correo' for database
        $data = $validated;
        $data['correo'] = $validated['email'] ?? null;
        unset($data['email']);

        $contacto->update($data);

        return redirect()->route('empresas.show', $contacto->empresa_id)->with('success', 'Contacto actualizado correctamente.');
    }

    public function destroy(ContactoEmpresa $contacto)
    {
        $empresaId = $contacto->empresa_id;
        $contacto->delete();
        return redirect()->route('empresas.show', $empresaId)->with('success', 'Contacto eliminado correctamente.');
    }
}
