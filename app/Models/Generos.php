<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generos extends Model
{
    public function ofertas()
    {
        return $this->belongsToMany(Ofertas::class, 'ofertas_generos', 'generos_id', 'ofertas_id');
    }

    protected $fillable = [
        'nome',
    ];
}
