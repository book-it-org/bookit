<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprasPedidos extends Model
{
    protected $fillable = [
        'compra_id',
        'pedido_id',
    ];
}
