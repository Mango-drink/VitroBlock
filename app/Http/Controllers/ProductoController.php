<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('productos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('productos.create');
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
            'diseno' => 'nullable|string',
            'color' => 'nullable|string',
            'dimensiones' => 'nullable|string',
            'piezas_por_caja' => 'required|integer|min:1',
            'm2_por_caja' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|image|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // Guardar imagen si se subió
        if ($request->hasFile('imagen_url')) {
            // tu lógica aquí
        }

        // Crear el producto
        $producto = producto::create($validated);

        // Puedes redirigir o devolver JSON
        return redirect()->route('productos.create')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
