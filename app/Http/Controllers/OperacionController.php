<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\Producto;
use App\Models\Usuario;
use Inertia\Inertia;

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
        $request->validate([
            'tipo' => 'required|in:alta,baja,modificación',
            'cantidad' => 'required|integer',
            'fecha_hora' => 'required|date',
            'producto_id' => 'required|exists:productos,producto_id',
            'usuario_id' => 'required|exists:usuario,usuario_id'
        ]);
        Operacion::create($request->all());
        return redirect()->route('operacion.index')->with('success', 'Operación creada correctamente.');
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