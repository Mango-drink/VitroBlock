<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
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
        return Inertia::render('productos/Index', [
            'productos' => $productos
        ]);


    }

    public function indexCliente()
    {
        $productos = \App\Models\Producto::with(['categoria', 'origen'])->get();
        return Inertia::render('productos/ProductosCliente', [
            'productos' => $productos
        ]);
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
            // Cambia a validación de imagen:
            'imagen_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'categoria_id' => 'required|exists:categorias,categoria_id',
            'origen_id' => 'required|exists:origenes,origen_id',
        ]);

        // Guardar la imagen si se subió:
        if ($request->hasFile('imagen_url')) {
            $path = $request->file('imagen_url')->store('imagenes', 'public');
            $validated['imagen_url'] = $path; // Guarda solo el path relativo (ej: 'imagenes/xyz.jpg')
        }

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
            'imagen_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
        // Borra la imagen física si existe
        if ($producto->imagen_url && Storage::disk('public')->exists($producto->imagen_url)) {
            Storage::disk('public')->delete($producto->imagen_url);
        }

        // Borra el producto de la base de datos
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
