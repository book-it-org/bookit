<?php

namespace App\Models;

use App\Utils\Slugger;
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
        'ativo',
        'bloqueado'
    ];

    public function generos()
    {
        return $this->belongsToMany(Generos::class, 'ofertas_generos', 'ofertas_id', 'generos_id');
    }

    public function idioma()
    {
        return $this->belongsTo(Idiomas::class, 'idiomas_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuarios_id');
    }

    public function tituloParaSlug()
    {
        return Slugger::slugify($this->titulo);
    }

    public static function pesquisarOferta(
        ?string $pesquisa = null,
        ?string $genero = null,
        ?string $idioma = null,
        ?string $estado = null,
        ?float $precoMin = null,
        ?float $precoMax = null,
        ?string $ordem = null
    ) {
        $query = self::query();

        // pesquisa por texto
        $query->when($pesquisa, function ($query, $pesquisa) {
            $query->where(function ($q) use ($pesquisa) {
                $q->where('titulo', 'ilike', "%{$pesquisa}%")
                    ->orWhere('descricao', 'ilike', "%{$pesquisa}%")
                    ->orWhere('titulo_livro', 'ilike', "%{$pesquisa}%")
                    ->orWhere('isbn_livro', 'ilike', "%{$pesquisa}%")
                    ->orWhere('autor_livro', 'ilike', "%{$pesquisa}%");
            });
        });

        // pesquisa por genero
        $query->when($genero, function ($query, $genero) {
            if ($genero !== '*') {
                $query->leftJoin('ofertas_generos', 'ofertas.id', '=', 'ofertas_generos.ofertas_id')
                    ->where('ofertas_generos.generos_id', $genero);
            }
        });

        // pesquisa por idioma
        $query->when($idioma, function ($query, $idioma) {
            if ($idioma !== '*') {
                $query->where('idiomas_id', $idioma);
            }
        });

        // pesquisa por estado do livro
        $query->when($estado, function ($query, $estado) {
            if ($estado !== '*') {
                $query->where('estado_livro', $estado);
            }
        });

        // pesquisa por preco minimo
        $query->when($precoMin, function ($query, $precoMin) {
            $query->where('preco', '>=', $precoMin);
        });

        // pesquisa por preco maximo
        $query->when($precoMax, function ($query, $precoMax) {
            $query->where('preco', '<=', $precoMax);
        });

        // ordenacao da pesquisa
        $query->when($ordem, function ($query, $ordem) {
            match ($ordem) {
                'preco_asc' => $query->orderBy('preco', 'asc'),
                'preco_desc' => $query->orderBy('preco', 'desc'),
                'data_asc' => $query->orderBy('created_at', 'asc'),
                'data_desc' => $query->orderBy('created_at', 'desc'),
                default => $query
            };
        });

        return $query->get();
    }

    public function desativar()
    {
        $this->ativo = false;
        $this->save();
    }

    public function ativar()
    {
        $this->ativo = true;
        $this->save();
    }

    public function bloquear()
    {
        $this->bloqueado = true;
        $this->save();
    }

    public function desbloquear()
    {
        $this->bloqueado = false;
        $this->save();
    }

    public function alterarPreco(float $novoPreco)
    {
        if($novoPreco >= 10.00){
            $this->preco = $novoPreco;
            $this->save();
        }
    }
}
