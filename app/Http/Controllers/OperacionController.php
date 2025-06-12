<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\Usuario;
use Inertia\Inertia;

class OperacionController extends Controller
{
    /**
     * Muestra el historial con filtros y paginación
     */
    public function index(Request $request)
    {
        $query = Operacion::with('usuario')->orderBy('fecha_hora', 'desc');

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('entidad')) {
            $query->where('entidad', $request->entidad);
        }
        if ($request->filled('search')) {
            $query->where('descripcion', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        $operaciones = $query->paginate(15)->withQueryString();

        // Catálogos para filtros
        $tipos     = Operacion::select('tipo')->distinct()->pluck('tipo');
        $entidades = Operacion::select('entidad')->distinct()->pluck('entidad');
        $usuarios  = Usuario::orderBy('nombre')->get(['usuario_id', 'nombre']);

        return Inertia::render('operacion/Index', [
            'operaciones' => $operaciones,
            'filtros'     => [
                'tipo'      => $request->tipo,
                'entidad'   => $request->entidad,
                'search'    => $request->search,
                'usuario_id'=> $request->usuario_id,
            ],
            'tipos'     => $tipos,
            'entidades' => $entidades,
            'usuarios'  => $usuarios,
        ]);
    }

    /**
     * Elimina un registro de la bitácora
     */
    public function destroy(Operacion $operacion)
    {
        $operacion->delete();
        return redirect()->route('admin.operaciones.index')->with('success', 'Operación eliminada correctamente.');
    }
}
