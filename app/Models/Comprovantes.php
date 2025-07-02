<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comprovantes extends Model
{
    protected $fillable = [
        'transacao_id',
        'caminho'
    ];
}
