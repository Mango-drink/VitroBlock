<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Origen;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Traits\RegistraOperacion; // Asegúrate de que este trait esté correctamente definido
use Illuminate\Support\Facades\Log;


class ProductoController extends Controller
{
    use RegistraOperacion;

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
        Log::info('Update de producto', $request->all());
        
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

        // Guardar la imagen si se subió:
        if ($request->hasFile('imagen_url')) {
            $path = $request->file('imagen_url')->store('imagenes', 'public');
            $validated['imagen_url'] = $path;
        }

        $producto = Producto::create($validated); // <-- Importante: guarda el producto en variable

        // Bitácora: registro de creación
        $this->registraOperacion(
            'alta',
            'productos',
            $producto->id,
            'Creación de producto: ' . $producto->nombre,
            $producto->stock_actual
        );

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
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
        Log::info('Request recibido en update:', $request->all());
        Log::info('¿Archivo imagen_url recibido?', [$request->hasFile('imagen_url')]);
        Log::info('Archivo imagen_url:', [$request->file('imagen_url')]);

        $validated = $request->validate([
            'codigo' => 'sometimes|required|string|max:255',
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'diseño' => 'nullable|string',
            'color' => 'nullable|string',
            'dimensiones' => 'nullable|string',
            'piezas_por_caja' => 'sometimes|required|integer|min:1',
            'm2_por_caja' => 'sometimes|required|numeric|min:0',
            'stock_actual' => 'sometimes|required|integer|min:0',
            'precio' => 'sometimes|required|numeric|min:0',
            'imagen_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'categoria_id' => 'sometimes|required|exists:categorias,categoria_id',
            'origen_id' => 'sometimes|required|exists:origenes,origen_id',
        ]);
        Log::info('¿Archivo imagen_url recibido?', [$request->hasFile('imagen_url')]);
        Log::info('Archivo imagen_url:', [$request->file('imagen_url')]);

        // Si subieron una nueva imagen:
        if ($request->hasFile('imagen_url')) {
            // Borra la imagen anterior si existe
            if ($producto->imagen_url && Storage::disk('public')->exists($producto->imagen_url)) {
                Storage::disk('public')->delete($producto->imagen_url);
            }
            // Guarda la nueva imagen y actualiza el path
            $path = $request->file('imagen_url')->store('imagenes', 'public');
            $validated['imagen_url'] = $path;
        } else {
            // No se subió nueva imagen: elimina del validated para NO sobreescribir la actual
            unset($validated['imagen_url']);
        }

        $producto->update($validated);
        Log::info('Producto actualizado:', $producto->fresh()->toArray());


        // Bitácora: registro de modificación
        $this->registraOperacion(
            'modificacion',
            'productos',
            $producto->id,
            'Modificación de producto: ' . $producto->nombre,
            $producto->stock_actual
        );

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
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

        // Guarda info relevante antes de eliminar
        $nombre = $producto->nombre;
        $stock_actual = $producto->stock_actual;
        $id = $producto->id;

        // Borra el producto de la base de datos
        $producto->delete();

        // Bitácora: registro de baja
        $this->registraOperacion(
            'baja',
            'productos',
            $id,
            'Eliminación de producto: ' . $nombre,
            $stock_actual
        );

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente.');
    }

}
