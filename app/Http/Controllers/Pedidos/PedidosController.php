<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use App\Models\Compras;
use App\Models\Pedidos;
use App\Models\Avaliacoes;
use App\Models\ComprasPedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PedidosController extends Controller
{
    /**
     * Renderiza a pagina de pedidos
     */
    public function mostrar(Request $request): Response
    {
        $usuario = $request->user();

        if (! $usuario) {
            return Inertia::render('auth/Entrar');
        }

        $compras = Compras::where('usuario_id', $usuario->id)
            ->with(['pedidos', 'pedidos.oferta', 'pedidos.vendedor'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'usuario_id' => $c->usuario_id,
                    'data_compra' => $c->data_compra,
                    'preco_total' => $c->preco_total,
                    'estado' => $c->estado,
                    'created_at' => $c->created_at,
                    'pedidos' => $c->pedidos->map(function ($p) {
                        return [
                            'id' => $p->id,
                            'estado' => $p->estado,
                            'endereco' => $p->endereco ? [
                                'id' => $p->endereco->id,
                                'logradouro' => $p->endereco->logradouro,
                                'numero' => $p->endereco->numero,
                                'complemento' => $p->endereco->complemento,
                                'bairro' => $p->endereco->bairro,
                                'cidade' => $p->endereco->cidade,
                                'cep' => $p->endereco->cep,
                            ] : null,
                            'oferta' => $p->oferta ? [
                                'id' => $p->oferta->id,
                                'titulo' => $p->oferta->titulo ?? $p->oferta->titulo_livro ?? null,
                                'titulo_livro' => $p->oferta->titulo_livro ?? null,
                                'autor_livro' => $p->oferta->autor_livro ?? null,
                                'preco' => $p->oferta->preco ?? null,
                                'capa_url' => $p->oferta->capa_url ?? null,
                            ] : null,
                            'vendedor' => $p->vendedor ? [
                                'id' => $p->vendedor->id,
                                'nome' => $p->vendedor->nome ?? null,
                            ] : null,
                        ];
                    })->toArray(),
                ];
            })->toArray();

        $comprasPorEstado = [
            'em_andamento' => array_values(array_filter($compras, fn ($c) => $c['estado'] === 'pendente')),
            'pago' => array_values(array_filter($compras, fn ($c) => $c['estado'] === 'pago')),
            'cancelado' => array_values(array_filter($compras, fn ($c) => $c['estado'] === 'cancelado')),
        ];

        return Inertia::render('Pedidos', [
            'comprasPorEstado' => $comprasPorEstado,
        ]);
    }

    /**
     * Visualiza os detalhes de uma compra/pedido
     */
    public function visualizar(Request $request, $id)
    {
        $usuario = $request->user();

        if (! $usuario) {
            return Inertia::render('auth/Entrar');
        }

        $compra = Compras::with(['pedidos', 'pedidos.oferta', 'pedidos.vendedor'])
            ->find($id);

        if (! $compra) {
            return to_route('pedidos');
        }

        // somente o comprador pode ver a tela de visualização detalhada da compra
        $isComprador = $compra->usuario_id === $usuario->id;

        if (! $isComprador) {
            return to_route('pedidos');
        }

        // enrich pedidos com informacoes de avaliacao
        $pedidos = $compra->pedidos->map(function ($p) use ($usuario) {
            $avaliacao = Avaliacoes::where('pedido_id', $p->id)->first();

            return [
                'id' => $p->id,
                'estado' => $p->estado,
                'confirmacao_recebimento' => $p->confirmacao_recebimento ?? false,
                'confirmado_recebimento_at' => $p->confirmado_recebimento_at ?? null,
                    'endereco' => $p->endereco ? [
                        'id' => $p->endereco->id,
                        'logradouro' => $p->endereco->logradouro,
                        'numero' => $p->endereco->numero,
                        'complemento' => $p->endereco->complemento,
                        'bairro' => $p->endereco->bairro,
                        'cidade' => $p->endereco->cidade,
                        'cep' => $p->endereco->cep,
                    ] : null,
                'oferta' => $p->oferta ? [
                    'id' => $p->oferta->id,
                    'titulo' => $p->oferta->titulo ?? $p->oferta->titulo_livro ?? null,
                    'titulo_livro' => $p->oferta->titulo_livro ?? null,
                    'autor_livro' => $p->oferta->autor_livro ?? null,
                    'preco' => $p->oferta->preco ?? null,
                    'capa_url' => $p->oferta->capa_url ?? null,
                ] : null,
                'vendedor' => $p->vendedor ? [
                    'id' => $p->vendedor->id,
                    'nome' => $p->vendedor->nome ?? null,
                ] : null,
                'avaliacao' => $avaliacao ? [
                    'nota' => $avaliacao->nota,
                    'comentario' => $avaliacao->comentario,
                    'comprador_id' => $avaliacao->comprador_id,
                ] : null,
                // indica se o usuario atual (se comprador) já avaliou este pedido
                'avaliado_pelo_usuario' => $avaliacao ? ($avaliacao->comprador_id === $usuario->id) : false,
            ];
        })->toArray();

        return Inertia::render('pedidos/VisualizarPedido', [
            'compra' => $compra,
                'pedidos' => $pedidos,
            'usuario_eh_comprador' => $isComprador,
            'usuario_eh_vendedor' => false,
        ]);
    }

    /**
     * Cancela uma compra (apenas comprador pode cancelar quando pendente)
     */
    public function cancelar(Request $request, $id)
    {
        $usuario = $request->user();

        if (! $usuario) {
            return Inertia::render('auth/Entrar');
        }

        $compra = Compras::with('pedidos')->find($id);

        if (! $compra) {
            return to_route('pedidos')->with('erro', 'Compra não encontrada');
        }

        // somente comprador pode cancelar e somente se estiver pendente
        if ($compra->usuario_id !== $usuario->id || $compra->estado !== 'pendente') {
            return back()->with('erro', 'Não autorizado a cancelar esta compra');
        }

        try {
            DB::beginTransaction();

            $compra->estado = 'cancelado';
            $compra->save();

            $pedidoIds = $compra->pedidos->pluck('id')->toArray();
            if (! empty($pedidoIds)) {
                Pedidos::whereIn('id', $pedidoIds)->update(['estado' => 'cancelado']);
            }

            DB::commit();

            return to_route('pedidos')->with('flash', [
                'sucesso' => 'Compra cancelada com sucesso.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('flash', [
                'erro' => 'Ocorreu um erro ao cancelar a compra. Tente novamente.',
            ]);
        }
    }

    /**
     * Confirma o recebimento de um pedido (apenas comprador da compra)
     */
    public function confirmarRecebimento(Request $request, $id)
    {
        $usuario = $request->user();

        if (! $usuario) {
            return Inertia::render('auth/Entrar');
        }

        $pedido = Pedidos::find($id);
        if (! $pedido) {
            return back()->with('erro', 'Pedido não encontrado');
        }

        $compraPedido = ComprasPedidos::where('pedido_id', $pedido->id)->first();
        if (! $compraPedido) {
            return back()->with('erro', 'Compra não encontrada para este pedido');
        }

        $compra = Compras::find($compraPedido->compra_id);
        if (! $compra || $compra->usuario_id !== $usuario->id) {
            return back()->with('erro', 'Não autorizado');
        }

        try {
            DB::beginTransaction();

            $pedido->confirmacao_recebimento = true;
            $pedido->confirmado_recebimento_at = now();
            $pedido->save();

            DB::commit();

            return back()->with('flash', ['sucesso' => 'Recebimento confirmado']);
        } catch (\Exception $e) {
            DB::rollBack();
            dump($e);
            return back()->with('flash', ['erro' => 'Erro ao confirmar recebimento']);
        }
    }
}
