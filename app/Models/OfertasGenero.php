<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertasGenero extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'ofertas_id',
        'generos_id'
    ];
}
