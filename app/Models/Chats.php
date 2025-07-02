<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $fillable = [
        'remetente_id',
        'destinatario_id',
        'ativo'
    ];
}
