<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origen extends Model
{
    use HasFactory;

    protected $table = 'origenes';
    protected $primaryKey = 'origen_id'; // ← ESTE CAMBIO

    public $timestamps = false; // o true si tienes los campos en la tabla

    protected $fillable = ['pais']; // Y los campos que uses
}

