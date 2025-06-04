<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Origen;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = \App\Models\Producto::with(['categoria', 'origen'])->get();
        return Inertia::render('productos/Index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Catálogos para selects
        $categorias = \App\Models\Categoria::all();
        $origenes = \App\Models\Origen::all();
        return Inertia::render('productos/Create', [
            'categorias' => $categorias,
            'origenes' => $origenes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'diseño' => 'nullable|string',
            'color' => 'nullable|string',
            'dimensiones' => 'nullable|string',
            'piezas_por_caja' => 'required|integer|min:1',
            'm2_por_caja' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            // Si solo usas URL, deja string, si vas a subir archivo, cambia lógica
            'imagen_url' => 'nullable|string|max:255', 
            'categoria_id' => 'required|exists:categorias,categoria_id',
            'origen_id' => 'required|exists:origenes,origen_id',
        ]);

        // Crear el producto
        Producto::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto->load(['categoria', 'origen']);
        return Inertia::render('productos/Show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $origenes = Origen::all();
        return Inertia::render('productos/Edit', [
            'producto' => $producto,
            'categorias' => $categorias,
            'origenes' => $origenes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'diseño' => 'nullable|string',
            'color' => 'nullable|string',
            'dimensiones' => 'nullable|string',
            'piezas_por_caja' => 'required|integer|min:1',
            'm2_por_caja' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|string|max:255', 
            'categoria_id' => 'required|exists:categorias,categoria_id',
            'origen_id' => 'required|exists:origenes,origen_id',
        ]);
        $producto->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
