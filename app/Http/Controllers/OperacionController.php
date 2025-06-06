<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\Producto;
use App\Models\Usuario;
use Inertia\Inertia;
use App\Models\Sincronizacion;

class OperacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operaciones = Operacion::with(['producto', 'usuario'])->get();
        return Inertia::render('operacion/Index', [
            'operaciones' => $operaciones
        ]);
    }

    public function create()
    {
        $productos = Producto::all();
        $usuarios = Usuario::all();
        return Inertia::render('operacion/Create', [
            'productos' => $productos,
            'usuarios' => $usuarios
        ]);
    }

    public function store(Request $request)
    {
        // VALIDAR PRIMERO
        $request->validate([
            'tipo' => 'required|in:alta,baja,modificación',
            'cantidad' => 'required|integer',
            'fecha_hora' => 'required|date',
            'producto_id' => 'required|exists:productos,producto_id',
            'usuario_id' => 'required|exists:usuario,usuario_id'
        ]);

        // CREAR OPERACION
        $operacion = Operacion::create([
            'tipo' => $request->tipo,
            'cantidad' => $request->cantidad,
            'fecha_hora' => $request->fecha_hora,
            'producto_id' => $request->producto_id,
            'usuario_id' => $request->usuario_id
        ]);
        
        // CREAR REGISTRO DE SINCRONIZACION (pendiente)
        $sincronizacion = Sincronizacion::create([
            'estado' => 'pendiente',
            'fecha_hora' => now(),
            'operacion_id' => $operacion->operacion_id,
            'producto_id' => $operacion->producto_id,
        ]);

        // INTENTAR SINCRONIZAR AL INSTANTE (simulado aquí, cambia por tu lógica real)
        $exito = $this->sincronizarConSistemaExterno($operacion);

        // ACTUALIZAR ESTADO
        $sincronizacion->estado = $exito ? 'éxito' : 'fallo';
        $sincronizacion->save();

        return redirect()->route('operacion.index')->with('success', 'Operación creada y sincronizada correctamente.');
    }

    // --- Método para simular sincronización (cámbialo por tu lógica real) ---
    protected function sincronizarConSistemaExterno($operacion)
    {
        // Aquí va tu lógica real de sincronización.
        // Simulación: éxito/fallo aleatorio (para pruebas)
        return rand(0, 1) ? true : false;
    }

    public function edit(Operacion $operacion)
    {
        $productos = Producto::all();
        $usuarios = Usuario::all();
        return Inertia::render('operacion/Edit', [
            'operacion' => $operacion,
            'productos' => $productos,
            'usuarios' => $usuarios
        ]);
    }

    public function update(Request $request, Operacion $operacion)
    {
        $request->validate([
            'tipo' => 'required|in:alta,baja,modificación',
            'cantidad' => 'required|integer',
            'fecha_hora' => 'required|date',
            'producto_id' => 'required|exists:productos,producto_id',
            'usuario_id' => 'required|exists:usuario,usuario_id'
        ]);
        $operacion->update($request->all());
        return redirect()->route('operacion.index')->with('success', 'Operación actualizada correctamente.');
    }

    public function destroy(Operacion $operacion)
    {
        $operacion->delete();
        return redirect()->route('operacion.index')->with('success', 'Operación eliminada correctamente.');
    }
}
