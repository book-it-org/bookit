<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagens extends Model
{
    protected $fillable = [
        'chat_id',
        'remetente_id',
        'conteudo',
        'data_envio'
    ];
}
