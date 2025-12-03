<?php

namespace App\Http\Controllers\Avaliacoes;

use App\Http\Controllers\Controller;
use App\Models\Avaliacoes;
use App\Models\Compras;
use App\Models\Pedidos;
use Illuminate\Http\Request;

class AvaliacoesController extends Controller
{
    /**
     * Armazena a avaliação de um pedido (vendedor) por um comprador.
     */
    public function store(Request $request, $pedidoId)
    {
        $usuario = $request->user();

        if (! $usuario) {
            return redirect()->route('login');
        }

        $pedido = Pedidos::find($pedidoId);
        if (! $pedido) {
            return back()->with('erro', 'Pedido não encontrado');
        }

        // verifica se o pedido pertence a uma compra do usuário e se a compra está paga
        $compra = Compras::where('usuario_id', $usuario->id)
            ->whereHas('pedidos', function ($q) use ($pedidoId) {
                $q->where('pedidos.id', $pedidoId);
            })->first();

        if (! $compra) {
            return back()->with('erro', 'Você não tem permissão para avaliar este pedido');
        }

        if ($compra->estado !== 'pago') {
            return back()->with('erro', 'Somente compras pagas podem ser avaliadas');
        }

        // já existe avaliação para este pedido?
        $existe = Avaliacoes::where('pedido_id', $pedidoId)->first();
        if ($existe) {
            return back()->with('erro', 'Este pedido já foi avaliado');
        }

        $data = $request->validate([
            'nota' => 'required|integer|min:0|max:5',
            'comentario' => 'nullable|string|max:2000',
        ]);

        Avaliacoes::create([
            'pedido_id' => $pedido->id,
            'vendedor_id' => $pedido->vendedor_id,
            'comprador_id' => $usuario->id,
            'nota' => $data['nota'],
            'comentario' => $data['comentario'] ?? null,
        ]);

        return back()->with('flash', ['sucesso' => 'Avaliação enviada com sucesso']);
    }
}
