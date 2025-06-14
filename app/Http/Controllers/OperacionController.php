<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\Usuario;
use Inertia\Inertia;
use App\Exports\OperacionesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf; // <--- Importa la facade (Laravel 9+)



class OperacionController extends Controller
{
    /**
     * Muestra el historial con filtros y paginación
     */
    public function index(Request $request)
    {
        $query = Operacion::with('usuario')->orderBy('fecha_hora', 'desc');

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

        // filtros de fechas**
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_fin);
        }

        $operaciones = $query->paginate(15)->withQueryString();

        $tipos     = Operacion::select('tipo')->distinct()->pluck('tipo');
        $entidades = Operacion::select('entidad')->distinct()->pluck('entidad');
        $usuarios  = Usuario::where('rol_id', 1)->orderBy('nombre')->get(['usuario_id', 'nombre']);

        return Inertia::render('operacion/Index', [ // O 'operaciones/Index'
            'operaciones' => $operaciones,
            'filtros'     => [
                'tipo'        => $request->tipo,
                'entidad'     => $request->entidad,
                'search'      => $request->search,
                'usuario_id'  => $request->usuario_id,
                'fecha_inicio'=> $request->fecha_inicio, // Para que el filtro persista en la vista
                'fecha_fin'   => $request->fecha_fin,
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
        return redirect()->route('admin.operacion.index')->with('success', 'Operación eliminada correctamente.');
    }

    public function exportExcel(Request $request)
    {
        $query = \App\Models\Operacion::query();

        // Filtros básicos
        if ($request->filled('search')) {
            $query->where('descripcion', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('entidad')) {
            $query->where('entidad', $request->entidad);
        }
        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        // Filtro por fechas si quieres implementarlo (agrega campos en el front si los usas)
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_fin);
        }

        $operaciones = $query->orderByDesc('fecha_hora')->get();

        // Aquí tu lógica de exportación (por ejemplo, usando Maatwebsite\Excel)
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\OperacionesExport($operaciones),
            'operaciones_filtradas.xlsx'
        );
    }


        public function exportPdf(Request $request)
    {
        $query = \App\Models\Operacion::query();

        // Filtros igual que en el Excel
        if ($request->filled('search')) {
            $query->where('descripcion', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('entidad')) {
            $query->where('entidad', $request->entidad);
        }
        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        // Filtro por fechas opcional
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_fin);
        }

        $operaciones = $query->orderByDesc('fecha_hora')->get();

        // Ejemplo con DomPDF, ajusta tu view y variables
        $pdf = PDF::loadView('admin.exports.operaciones_pdf', compact('operaciones'));
        return $pdf->download('operaciones_filtradas.pdf');
    }

}
