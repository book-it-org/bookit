<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $filable = [
        'vendedor_id',
        'comprador_id',
        'oferta_id',
        'estado'
    ];
}
