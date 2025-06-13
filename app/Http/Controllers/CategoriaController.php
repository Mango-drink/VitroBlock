<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Traits\RegistraOperacion; // ← Importa el Trait

class CategoriaController extends Controller
{
    use RegistraOperacion; // ← Usa el Trait

    public function index()
    {
        $categorias = Categoria::all();
        return Inertia::render('categorias/Index', compact('categorias'));
    }

    public function create()
    {
        return Inertia::render('categorias/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            // otros campos…
        ]);

        $categoria = Categoria::create($validated);

        // Bitácora: registro de creación
        $this->registraOperacion(
            'alta',
            'categorias',
            $categoria->id, // Cambia a $categoria->categoria_id si tu PK se llama así
            'Creación de categoría: ' . $categoria->nombre
        );

        return redirect()->route('admin.categorias.index')
                         ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return Inertia::render('categorias/Edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $categoria->update($validated);

        // Bitácora: registro de modificación
        $this->registraOperacion(
            'modificacion',
            'categorias',
            $categoria->id, // Cambia a $categoria->categoria_id si aplica
            'Modificación de categoría: ' . $categoria->nombre
        );

        return redirect()->route('admin.categorias.index')
                         ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $nombre = $categoria->nombre;
        $id = $categoria->id; // Cambia a $categoria->categoria_id si aplica

        $categoria->delete();

        // Bitácora: registro de baja
        $this->registraOperacion(
            'baja',
            'categorias',
            $id,
            'Eliminación de categoría: ' . $nombre
        );

        return redirect()->route('admin.categorias.index')
                         ->with('success', 'Categoría eliminada correctamente.');
    }
}
