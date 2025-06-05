<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cambia el '1' por el rol que corresponda a admin en tu base de datos
        if (!auth()->check() || auth()->user()->rol_id !== 1) {
            // Redirige o aborta si no es admin
            abort(403, 'Acceso solo para administradores.');
        }
        return $next($request);
    }
}