<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enderecos extends Model
{
    protected $fillable = [
        'usuarios_id',
        'estados_id',
        'paises_id',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep'
    ];
}
