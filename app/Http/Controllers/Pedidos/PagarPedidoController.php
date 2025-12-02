<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use App\Models\Compras;
use App\Models\Pedidos;
use App\Models\Transacoes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PagarPedidoController extends Controller
{
    /**
     * Mostra a tela de pagar pedido (simulado)
     */
    public function mostrar(Request $request, $id)
    {
        $usuario = $request->user();

        if (! $usuario) {
            return Inertia::render('auth/Entrar');
        }

        $compra = Compras::with([
            'pedidos',
            'pedidos.vendedor',
            'pedidos.oferta',
            'pedidos.comprador'])
            ->find($id);

        if (! $compra) {
            return to_route('carrinho');
        }

        if ($compra->usuario_id !== $usuario->id) {
            return to_route('carrinho');
        }

        if ($compra->estado === 'pago') {
            return to_route('pedidos');
        }

        $transacao = Transacoes::where('compra_id', $compra->id)->first();

        return Inertia::render('pedidos/PagarPedido', [
            'compra' => $compra,
            'transacao' => $transacao,
        ]);
    }

    /**
     * Processa (simula) o pagamento e marca tudo como pago
     */
    public function pagar(Request $request, $id)
    {
        $usuario = $request->user();

        if (! $usuario) {
            return Inertia::render('auth/Entrar');
        }

        $compra = Compras::with('pedidos')->find($id);

        if (! $compra) {
            return back()->with('erro', 'Compra não encontrada');
        }

        try {
            DB::beginTransaction();

            // marca transacao como paga
            $transacao = Transacoes::where('compra_id', $compra->id)->first();
            if ($transacao) {
                $transacao->update([
                    'pago' => true,
                    'pago_em' => now(),
                ]);
            }

            $compra->update([
                'estado' => 'pago',
            ]);

            // marca todos os pedidos da compra como pagos
            $pedidoIds = $compra->pedidos->pluck('id')->toArray();
            if (! empty($pedidoIds)) {
                Pedidos::whereIn('id', $pedidoIds)->update(['estado' => 'concluido']);
            }

            DB::commit();

            return to_route('pedidos')->with('flash', [
                'sucesso' => 'Pagamento realizado com sucesso!',
            ]);
        } catch (Exception $e) {
            dump($e);
            DB::rollBack();

            return back()->with('flash', [
                'erro' => 'Ocorreu um erro ao processar o pagamento. Tente novamente.',
            ]);
        }
    }
}
