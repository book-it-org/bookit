<?php

namespace App\Models;

use App\Utils\Slugger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Pedidos;
use App\Models\Compras;
use App\Models\Avaliacoes;

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
        'editora',
        'capa_url',
        'estado_livro',
        'isbn_livro',
        'data_publicacao_livro',
        'ativo',
        'bloqueado',
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

        // excluir ofertas inativas, bloqueadas ou que estão em pedidos não cancelados
        $query->where('ativo', true)
            ->where('bloqueado', false)
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('pedidos')
                    ->whereColumn('pedidos.oferta_id', 'ofertas.id')
                    ->whereIn('pedidos.estado', ['pendente', 'andamento', 'concluido']);
            });

        // pesquisa por texto
        $query->when($pesquisa, function ($query, $pesquisa) {
            $query->where(function ($q) use ($pesquisa) {
                $q->where('titulo', 'ilike', "%{$pesquisa}%")
                    ->orWhere('descricao', 'ilike', "%{$pesquisa}%")
                    ->orWhere('titulo_livro', 'ilike', "%{$pesquisa}%")
                    ->orWhere('isbn_livro', 'ilike', "%{$pesquisa}%")
                        ->orWhere('autor_livro', 'ilike', "%{$pesquisa}%")
                        ->orWhere('editora', 'ilike', "%{$pesquisa}%");
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

        $results = $query->get();

        // attach vendedor rating to each oferta
        return $results->map(function ($o) {
            $nota = Avaliacoes::where('vendedor_id', $o->usuarios_id)->avg('nota');
            $o->vendedor_nota = $nota ? round($nota, 1) : null;
            return $o;
        })->toArray();
    }

    public function desativar()
    {
        self::update([
            'ativo' => false,
        ]);
    }

    public function ativar()
    {
        self::update([
            'ativo' => true,
        ]);
    }

    public function bloquear()
    {
        self::update([
            'bloqueado' => true,
        ]);
    }

    public function desbloquear()
    {
        self::update([
            'bloqueado' => false,
        ]);
    }

    public function editar($titulo, $descricao, $preco, $editora = null, $capa_url = null)
    {
        $dados = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'preco' => $preco,
        ];

        if (!is_null($editora)) {
            $dados['editora'] = $editora;
        }

        if (!is_null($capa_url)) {
            $dados['capa_url'] = $capa_url;
        }

        self::update($dados);
    }

    public static function buscarOfertaPorIdEUsuario($id, $usuarioId)
    {
        return self::where('id', $id)
            ->where('usuarios_id', $usuarioId)
            ->firstOrFail();
    }

    public static function buscarOfertasDoUsuario($usuarioId)
    {
        $ofertas = self::where('usuarios_id', $usuarioId)
            ->with(['generos', 'idioma'])
            ->orderBy('created_at', 'desc')
            ->get();

        // adicionar informacao se a oferta está envolvida em algum pedido/compras
        return $ofertas->map(function ($o) {
            $pedido = Pedidos::where('oferta_id', $o->id)
                ->where('estado', '!=', 'cancelado')
                ->with('compras')
                ->first();

            $o->em_compra = $pedido ? true : false;
            $o->pedido_id = $pedido ? $pedido->id : null;

            // checar se existe alguma compra associada ao pedido que esteja paga/concluida
            $o->compra_concluida = false;
            $o->compra_concluida_id = null;
            if ($pedido && $pedido->compras) {
                foreach ($pedido->compras as $c) {
                    if (in_array($c->estado, ['pago', 'concluido'])) {
                        $o->compra_concluida = true;
                        $o->compra_concluida_id = $c->id;
                        break;
                    }
                }
            }

            // vendedor nota media
            $nota = Avaliacoes::where('vendedor_id', $o->usuarios_id)->avg('nota');
            $o->vendedor_nota = $nota ? round($nota, 1) : null;

            return $o;
        })->toArray();
    }

    public static function buscarOfertaParaEdicao($id, $usuarioId)
    {
        return self::where('id', $id)
            ->where('usuarios_id', $usuarioId)
            ->with(['generos', 'idioma'])
            ->first();
    }

    public static function criarOfertaComGenero(array $dados, $generoId)
    {
        $oferta = self::create($dados);

        OfertasGenero::create([
            'ofertas_id' => $oferta->id,
            'generos_id' => $generoId,
        ]);

        return $oferta;
    }

    public static function ofertasRecomendadas()
    {
        $results = self::where('ativo', true)
            ->where('bloqueado', false)
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('pedidos')
                    ->whereColumn('pedidos.oferta_id', 'ofertas.id')
                    ->whereIn('pedidos.estado', ['pendente', 'andamento', 'concluido']);
            })
            ->inRandomOrder()
            ->limit(20)
            ->get();

        return $results->map(function ($o) {
            $nota = Avaliacoes::where('vendedor_id', $o->usuarios_id)->avg('nota');
            $o->vendedor_nota = $nota ? round($nota, 1) : null;
            return $o;
        })->toArray();
    }
}
