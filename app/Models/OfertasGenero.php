<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertasGenero extends Model
{
    protected $fillable = [
        'ofertas_id',
        'generos_id'
    ];
}
