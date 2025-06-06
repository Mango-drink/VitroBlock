<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Origen;
use App\Models\Sincronizacion;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'producto_id';

    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'diseño', 'color', 'dimensiones',
        'piezas_por_caja', 'm2_por_caja', 'stock_actual', 'precio', 'imagen_url',
        'categoria_id', 'origen_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'categoria_id');
    }

    public function origen()
    {
        return $this->belongsTo(Origen::class, 'origen_id', 'origen_id');
    }

    public function sincronizaciones()
    {
        return $this->hasMany(Sincronizacion::class, 'producto_id', 'producto_id');
    }

}
