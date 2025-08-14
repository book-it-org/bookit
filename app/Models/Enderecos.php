<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enderecos extends Model
{
    protected $fillable = [
        'usuarios_id',
        'estados_id',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'cep'
    ];

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'estados_id');

    }

    public static function porUsuario($id)
    {
        return self::with('estado')->where('usuarios_id', $id)->get();
    }
}
