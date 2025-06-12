<?php

namespace App\Traits;

use App\Models\Operacion;
use Illuminate\Support\Facades\Auth;

trait RegistraOperacion
{
    /**
     * Registra una operación en la bitácora.
     * 
     * @param string $tipo (alta, baja, modificacion, consulta, etc.)
     * @param string $entidad (productos, usuarios, categorias, etc.)
     * @param int|null $entidad_id (ID del registro afectado)
     * @param string|null $descripcion (texto descriptivo)
     * @param int|null $cantidad (opcional, para inventario)
     */
    public function registraOperacion($tipo, $entidad, $entidad_id = null, $descripcion = null, $cantidad = null)
    {
        Operacion::create([
            'tipo'        => $tipo,
            'entidad'     => $entidad,
            'entidad_id'  => $entidad_id,
            'descripcion' => $descripcion,
            'cantidad'    => $cantidad,
            'fecha_hora'  => now(),
            'usuario_id'  => Auth::id(),
            'ip'          => request()->ip(),
            'user_agent'  => request()->header('User-Agent'),
        ]);
    }
}
