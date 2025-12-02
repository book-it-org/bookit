<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use App\Models\Compras;
use App\Models\Pedidos;
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

        if (! $compra || $compra->usuario_id !== $usuario->id) {
            return to_route('pedidos');
        }

        return Inertia::render('pedidos/VisualizarPedido', [
            'compra' => $compra,
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
}
