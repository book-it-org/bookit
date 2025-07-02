<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuariosPapeis extends Model
{
    protected $fillable = [
        'usuarios_id',
        'papeis_id'
    ];
}
