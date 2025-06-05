<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Operacion;

class Sincronizacion extends Model
{
    protected $table = 'sincronizacion';
    protected $primaryKey = 'evento_id';
    public $timestamps = false;

    protected $fillable = [
        'estado', 'fecha_hora', 'operacion_id', 'producto_id'
    ];

    public function operacion()
    {
        return $this->belongsTo(Operacion::class, 'operacion_id', 'operacion_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'producto_id');
    }
}
