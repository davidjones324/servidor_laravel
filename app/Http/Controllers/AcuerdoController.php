<?php

namespace App\Http\Controllers;

use App\Models\Acuerdo;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\TutorDual;
use App\Models\Responsable;
use App\Models\ContactoEmpresa;
use Illuminate\Http\Request;

class AcuerdoController extends Controller
{
    public function index(Request $request)
    {
        $query = Acuerdo::with(['alumno', 'empresa', 'tutorDual', 'responsable', 'contactoEmpresa']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('empresa', function ($sq) use ($search) {
                $sq->where('razon_social', 'LIKE', $search . '%');
            });
        }

        if ($request->filled('estado_convenio')) {
            $query->where('estado_convenio', $request->input('estado_convenio'));
        }

        if ($request->filled('avisado')) {
            $query->where('avisado', $request->input('avisado'));
        }

        $acuerdos = $query->paginate(10)->withQueryString();

        return view('acuerdos.index', compact('acuerdos'));
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $empresas = Empresa::with('contactos')->get();
        $tutores = TutorDual::all();
        $responsables = Responsable::all();
        return view('acuerdos.create', compact('alumnos', 'empresas', 'tutores', 'responsables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'empresa_id' => 'required|exists:empresas,id',
            'contacto_empresa_id' => 'nullable|exists:contacto_empresas,id',
            'tutor_dual_id' => 'required|exists:tutor_duals,id',
            'responsable_id' => 'required|exists:responsables,id',
            'localidad' => 'required|string|max:150',
            'nombre_acuerdo' => 'required|string|max:255',
            'estado_convenio' => 'required|in:pendiente,hecho_pendiente_firma,firmado',
            'horario' => 'nullable|string',
            'horas_totales' => 'required|integer',
            'grupo' => 'required|string|max:20',
            'curso' => 'required|string|max:20',
            'ano' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        Acuerdo::create($validated);

        return redirect()->route('acuerdos.index')->with('success', 'Acuerdo creado correctamente.');
    }

    public function show(Acuerdo $acuerdo)
    {
        $acuerdo->load(['alumno', 'empresa', 'tutorDual', 'responsable', 'contactoEmpresa']);
        return view('acuerdos.show', compact('acuerdo'));
    }

    public function edit(Acuerdo $acuerdo)
    {
        $alumnos = Alumno::all();
        $empresas = Empresa::with('contactos')->get();
        $tutores = TutorDual::all();
        $responsables = Responsable::all();
        return view('acuerdos.edit', compact('acuerdo', 'alumnos', 'empresas', 'tutores', 'responsables'));
    }

    public function update(Request $request, Acuerdo $acuerdo)
    {
        $validated = $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'empresa_id' => 'required|exists:empresas,id',
            'contacto_empresa_id' => 'nullable|exists:contacto_empresas,id',
            'tutor_dual_id' => 'required|exists:tutor_duals,id',
            'responsable_id' => 'required|exists:responsables,id',
            'localidad' => 'required|string|max:150',
            'nombre_acuerdo' => 'required|string|max:255',
            'estado_convenio' => 'required|in:pendiente,hecho_pendiente_firma,firmado',
            'horario' => 'nullable|string',
            'horas_totales' => 'required|integer',
            'grupo' => 'required|string|max:20',
            'curso' => 'required|string|max:20',
            'ano' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $acuerdo->update($validated);

        return redirect()->route('acuerdos.index')->with('success', 'Acuerdo actualizado correctamente.');
    }

    public function destroy(Acuerdo $acuerdo)
    {
        $acuerdo->delete();
        return redirect()->route('acuerdos.index')->with('success', 'Acuerdo eliminado correctamente.');
    }
}
