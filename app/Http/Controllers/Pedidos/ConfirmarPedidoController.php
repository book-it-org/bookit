<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use App\Models\Carrinhos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConfirmarPedidoController extends Controller
{
    /**
     * Renderiza a pagina de confirmar pedido
     */
    public function mostrar(Request $request): Response
    {
        $usuario = $request->user();

        if (! $usuario) {
            return Inertia::render('auth/Entrar');
        }

        $id_usuario = $usuario->id;
        $pedidos = Carrinhos::porUsuario($id_usuario);

        // formas de pagamento simples — ajuste conforme seu modelo/DB
        $formasPagamento = [
            'pix', 'debito', 'credito', 'boleto',
        ];

        return Inertia::render('pedidos/ConfirmarPedido', [
            'pedidos' => $pedidos,
            'formasPagamento' => $formasPagamento,
        ]);
    }
}
