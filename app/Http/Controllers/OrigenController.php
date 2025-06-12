<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Origen;
use Inertia\Inertia;
use App\Traits\RegistraOperacion; // ← Importa el Trait

class OrigenController extends Controller
{
    use RegistraOperacion; // ← Usa el Trait

    public function index()
    {
        $origenes = Origen::all();
        return Inertia::render('origenes/Index', [
            'origenes' => $origenes
        ]);
    }

    public function create()
    {
        return Inertia::render('origenes/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pais' => 'required|string|max:255'
        ]);
        $origen = Origen::create($validated);

        // Bitácora: registro de creación
        $this->registraOperacion(
            'alta',
            'origenes',
            $origen->origen_id, // Cambia a $origen->origen_id si aplica
            'Creación de origen: ' . $origen->pais
        );

        return redirect()->route('admin.origenes.index')->with('success', 'Origen creado correctamente.');
    }

    public function show(string $id)
    {
        $origen = Origen::findOrFail($id);
        return Inertia::render('origenes/Show', compact('origen'));
    }

    public function edit(Origen $origen)
    {
        return Inertia::render('origenes/Edit', [
            'origen' => $origen
        ]);
    }

    public function update(Request $request, Origen $origen)
    {
        $validated = $request->validate([
            'pais' => 'required|string|max:255',
        ]);
        $origen->update($validated);

        // Bitácora: registro de modificación
        $this->registraOperacion(
            'modificacion',
            'origenes',
            $origen->origen_id, // Cambia a $origen->origen_id si aplica
            'Modificación de origen: ' . $origen->pais
        );

        return redirect()->route('admin.origenes.index')->with('success', 'Origen actualizado correctamente.');
    }

    public function destroy(Origen $origen)
    {
        $pais = $origen->pais;
        $id = $origen->id; // Cambia a $origen->origen_id si aplica

        $origen->delete();

        // Bitácora: registro de baja
        $this->registraOperacion(
            'baja',
            'origenes',
            $id,
            'Eliminación de origen: ' . $pais
        );

        return redirect()->route('admin.origenes.index')->with('success', 'Origen eliminado correctamente.');
    }
}
