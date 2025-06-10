<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia; // ← Asegúrate de incluir esto

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        Categoria::create($validated);

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(\App\Models\Categoria $categoria)
    {
        return Inertia::render('categorias/Edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $categoria->update($validated);

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría eliminada correctamente.');
    }
}
