<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;
    protected $primaryKey = 'producto_id';

    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'diseño', 'color', 'dimensiones',
        'piezas_por_caja', 'm2_por_caja', 'stock_actual', 'precio', 'imagen_url',
        'categoria_id', 'origen_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function origen()
    {
        return $this->belongsTo(Origen::class);
    }
}
