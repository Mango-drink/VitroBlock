<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\User;
use App\Models\Sincronizacion;

class Operacion extends Model
{
    protected $table = 'operacion';
    protected $primaryKey = 'operacion_id';
    public $timestamps = false; // Quita si agregas timestamps

    protected $fillable = [
        'tipo', 'cantidad', 'fecha_hora', 'producto_id', 'usuario_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'producto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }

    public function sincronizaciones()
    {
        return $this->hasMany(Sincronizacion::class, 'operacion_id', 'operacion_id');
    }
}
