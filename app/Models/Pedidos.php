<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $fillable = [
        'vendedor_id',
        'comprador_id',
        'oferta_id',
        'endereco_id',
        'estado',
        'confirmacao_recebimento',
        'confirmado_recebimento_at',
    ];

    public function vendedor()
    {
        return $this->belongsTo(Usuarios::class, 'vendedor_id');
    }

    public function comprador()
    {
        return $this->belongsTo(Usuarios::class, 'comprador_id');
    }

    public function oferta()
    {
        return $this->belongsTo(Ofertas::class, 'oferta_id');
    }

    public function compras()
    {
        return $this->belongsToMany(Compras::class, 'compras_pedidos', 'pedido_id', 'compra_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Enderecos::class, 'endereco_id');
    }
}
