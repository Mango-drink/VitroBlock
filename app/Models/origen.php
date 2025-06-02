<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class origen extends Model
{
    use HasFactory;

    protected $table = 'origenes';
    protected $primaryKey = 'origen_id';
    public $timestamps = false;

    protected $fillable = ['pais'];

}
