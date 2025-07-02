<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Papeis extends Model
{
    protected $fillable = [
        'nome',
        'descricao'
    ];
}
