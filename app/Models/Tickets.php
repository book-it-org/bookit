<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $fillable = [
        'requerente_id',
        'curador_id',
        'tipo',
        'respondido'
    ];
}
