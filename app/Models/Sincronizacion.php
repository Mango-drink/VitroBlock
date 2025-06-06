<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sincronizacion extends Model
{
    protected $table = 'sincronizacion';
    protected $primaryKey = 'evento_id';
    public $timestamps = false;

    protected $fillable = [
        'estado', 'fecha_hora', 'operacion_id', 'producto_id'
    ];

    // Relación con Operacion
    public function operacion()
    {
        return $this->belongsTo(Operacion::class, 'operacion_id', 'operacion_id');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'producto_id');
    }
}
