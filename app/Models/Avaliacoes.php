<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacoes extends Model
{
    protected $fillable = [
        'pedido_id',
        'vendedor_id',
        'comprador_id',
        'nota',
        'comentario'
    ];

    public function vendedor()
    {
        return $this->belongsTo(Usuarios::class, 'vendedor_id');
    }

    public function comprador()
    {
        return $this->belongsTo(Usuarios::class, 'comprador_id');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedidos::class, 'pedido_id');
    }
}
