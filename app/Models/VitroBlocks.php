<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitroBlocks extends Model

{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'diseno', 'color', 'dimensiones',
        'piezas_por_caja', 'm2_por_caja', 'stock_actual', 'precio', 'imagen_url', 'categoria_id'
    ];
}

