<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    protected $fillable = [
        'usuario_id',
        'data_compra',
        'preco_total',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id');
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedidos::class, 'compras_pedidos', 'compra_id', 'pedido_id');
    }

    public function comprasPedidos()
    {
        return $this->hasMany(ComprasPedidos::class, 'compra_id');
    }
}
