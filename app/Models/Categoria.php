<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Indicar la tabla (opcional si coincide automáticamente)
    protected $table = 'categorias';

    // Indicar la llave primaria personalizada
    protected $primaryKey = 'categoria_id';

    // Si tu PK no es integer auto-increment (en este caso sí lo es), podrías necesitar:
    // public $incrementing = true;
    // protected $keyType = 'int';

    // Indicar que no maneja timestamps si es el caso
    public $timestamps = false;

    // Campos asignables por create() o update()
    protected $fillable = ['nombre'];
}
