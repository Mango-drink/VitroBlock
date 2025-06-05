<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';
    protected $primaryKey = 'usuario_id';

    protected $fillable = ['nombre', 'email', 'password_hash', 'rol_id'];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
