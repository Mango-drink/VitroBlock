<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Sincronizacion;

class Operacion extends Model
{
    protected $table = 'operacion';
    protected $primaryKey = 'operacion_id';
    public $timestamps = false; // Usamos 'fecha_hora', no 'created_at'

    protected $fillable = [
        'tipo',           // alta, baja, modificacion, consulta, etc.
        'entidad',        // productos, usuarios, categorias, etc.
        'entidad_id',     // ID del registro afectado (puede ser de cualquier entidad)
        'descripcion',    // Texto explicativo de la operación
        'cantidad',       // Solo si aplica (ej. inventario)
        'fecha_hora',     // Fecha y hora de la operación
        'usuario_id',     // Quién hizo la operación
        'ip',             // IP del usuario (opcional)
        'user_agent',     // User agent del usuario (opcional)
    ];

    // Relación con Usuario (quién realizó la operación)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }

    // Relación con Sincronizacion (si la necesitas)
    public function sincronizaciones()
    {
        return $this->hasMany(Sincronizacion::class, 'operacion_id', 'operacion_id');
    }
}
