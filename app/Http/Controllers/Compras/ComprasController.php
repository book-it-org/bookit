<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\Carrinhos;
use App\Models\Compras;
use App\Models\ComprasPedidos;
use App\Models\Pedidos;
use App\Models\Transacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ComprasController extends Controller
{
    /**
     * Renderiza a pagina de pedidos
     */
    public function comprar(Request $request)
    {

        $usuario = $request->user();
        // precisa estar logado
        if (! $usuario) {
            Inertia::render('auth/Entrar');
        }

        $forma_pagamento = $request->input('forma_pagamento', 'pix');

        try {
            DB::beginTransaction();

            $itens_carrinho = Carrinhos::porUsuario($usuario->id);

            if ($itens_carrinho->isEmpty()) {
                DB::rollBack();

                return Inertia::render('Carrinho', [
                    'erro' => 'Carrinho vazio. Adicione itens antes de comprar.',
                ]);
            }

            $preco_total = $itens_carrinho->sum(fn ($item) => $item->ofertas->preco);

            $compra = Compras::create([
                'usuario_id' => $usuario->id,
                'data_compra' => now(),
                'preco_total' => $preco_total,
                'estado' => 'pendente',
            ]);

            foreach ($itens_carrinho as $item) {
                // se oferta estiver desativada ou bloqueada, dar erro

                $foi_comprado = Pedidos::where('oferta_id', $item->ofertas_id)
                    ->whereIn('estado', ['andamento', 'concluido'])
                    ->exists();

                if ($item->ofertas->bloqueado || ! $item->ofertas->ativo || $foi_comprado) {
                    DB::rollBack();

                    return redirect()->back()->with(
                        'flash', [
                            'erro' => "A oferta '{$item->ofertas->titulo}' não está mais disponível.",
                        ],
                    );

                }

                $pedido = Pedidos::create([
                    'vendedor_id' => $item->ofertas->usuarios_id,
                    'comprador_id' => $usuario->id,
                    'oferta_id' => $item->ofertas_id,
                    'estado' => 'andamento',
                ]);

                ComprasPedidos::create([
                    'compra_id' => $compra->id,
                    'pedido_id' => $pedido->id,
                ]);
            }

            Transacoes::create([
                'compra_id' => $compra->id,
                'pago' => false,
                'valor' => $preco_total,
                'tipo' => $forma_pagamento,
                'pago_em' => null,
            ]);

            Carrinhos::where('usuarios_id', $usuario->id)->delete();

            DB::commit();

            return to_route('pedido.pagar', ['id' => $compra->id]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'erro' => 'Ocorreu um erro ao processar sua compra',
            ]);
        }
    }
}
