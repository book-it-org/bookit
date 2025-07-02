<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transacoes extends Model
{
    protected $fillable = [
        'pedido_id',
        'pago',
        'valor',
        'tipo',
        'pago_em'
    ];
}
