<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Controller;
use App\Models\Ofertas;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Pedidos;
use App\Models\Compras;
use App\Models\Avaliacoes;

class AnunciosController extends Controller
{
    /**
     * Renderiza a pagina de anúncios do usuário
     */
    public function mostrarAnuncios(Request $request): Response
    {
        $usuario = $request->user();
        $ofertas = Ofertas::buscarOfertasDoUsuario($usuario->id);

        return Inertia::render('anuncios/Anuncios', [
            'ofertas' => $ofertas,
        ]);
    }

    /**
     * Visualizacao do anuncio pelo vendedor (mostra pedidos/compras que envolvem esta oferta)
     */
    public function visualizar(Request $request, $id)
    {
        $usuario = $request->user();

        if (! $usuario) {
            return Inertia::render('auth/Entrar');
        }

        $oferta = Ofertas::where('id', $id)->first();
        if (! $oferta || $oferta->usuarios_id !== $usuario->id) {
            return to_route('anuncios');
        }

        // pedidos relacionados a esta oferta que não foram cancelados
        $pedidos = Pedidos::where('oferta_id', $id)
            ->where('estado', '!=', 'cancelado')
            ->with(['compras' => function ($q) { $q->with('usuario'); } , 'vendedor', 'comprador'])
            ->get()
            ->map(function ($p) {
                $avaliacao = Avaliacoes::where('pedido_id', $p->id)->first();

                return [
                    'id' => $p->id,
                    'estado' => $p->estado,
                    'compras' => $p->compras->map(fn($c) => [
                        'id' => $c->id,
                        'usuario_id' => $c->usuario_id,
                        'data_compra' => $c->data_compra,
                        'preco_total' => $c->preco_total,
                        'estado' => $c->estado,
                    ])->toArray(),
                    'vendedor' => $p->vendedor ? ['id' => $p->vendedor->id, 'nome' => $p->vendedor->nome ?? null] : null,
                    'comprador' => $p->comprador ? ['id' => $p->comprador->id, 'nome' => $p->comprador->nome ?? null] : null,
                    'endereco' => $p->endereco ? [
                        'id' => $p->endereco->id,
                        'logradouro' => $p->endereco->logradouro,
                        'numero' => $p->endereco->numero,
                        'complemento' => $p->endereco->complemento,
                        'bairro' => $p->endereco->bairro,
                        'cidade' => $p->endereco->cidade,
                        'cep' => $p->endereco->cep,
                    ] : null,
                    'confirmacao_recebimento' => $p->confirmacao_recebimento ?? false,
                    'confirmado_recebimento_at' => $p->confirmado_recebimento_at ?? null,
                    'avaliacao' => $avaliacao ? [
                        'nota' => $avaliacao->nota,
                        'comentario' => $avaliacao->comentario,
                        'comprador_id' => $avaliacao->comprador_id,
                    ] : null,
                ];
            })->toArray();

        return Inertia::render('anuncios/VisualizarAnuncio', [
            'oferta' => $oferta,
            'pedidos' => $pedidos,
        ]);
    }
}
