<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ofertas extends Model
{
    protected $fillable = [
        'usuarios_id',
        'idiomas_id',
        'titulo',
        'descricao',
        'preco',
        'titulo_livro',
        'autor_livro',
        'estado_livro',
        'isbn_livro',
        'data_publicacao_livro',
        'ativo'
    ];

    public function desativar()
    {
        $this->ativo = false;
        $this->save();
    }
}
