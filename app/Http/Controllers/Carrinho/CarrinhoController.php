<?php

namespace App\Http\Controllers\Carrinho;

use App\Http\Controllers\Controller;
use App\Models\Carrinhos;
use App\Models\Ofertas;
use App\Models\Pedidos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CarrinhoController extends Controller
{
    /**
     * Renderiza a pagina do carrinho
     */
    public function mostrar(Request $request): Response
    {
        $carrinho = [];

        if ($request->user()) {
            $id_usuario = $request->user()->id;
            $carrinho = Carrinhos::porUsuario($id_usuario);
        } else {
            $cookie = json_decode($request->cookie('carrinho', '[]'), true);
            $carrinho = Carrinhos::porCookie($cookie);
        }

        return Inertia::render('Carrinho', [
            'carrinho' => $carrinho,
        ]);
    }

    public function adicionar(Request $request)
    {
        $oferta_id = $request->input('oferta_id');

        $esta_em_pedido = Pedidos::where('oferta_id', $oferta_id)
            ->where('estado', '!=', 'cancelado')
            ->exists();

        $bloqueada_ou_inativa = Ofertas::where('id', $oferta_id)
            ->where(function ($query) {
                $query->where('bloqueado', true)
                    ->orWhere('ativo', false);
            })
            ->exists();

        if ($esta_em_pedido || $bloqueada_ou_inativa) {
            return back()->with('flash', [
                'erro' => 'Essa oferta não está disponível para compra no momento.',
            ]);
        }

        if ($request->user()) {
            $id_usuario = $request->user()->id;
            $resultado = Carrinhos::criarItem($id_usuario, $oferta_id);

            if ($resultado === false) {
                return back()->with('flash', ['erro' => 'Essa oferta não está disponível para compra no momento.']);
            }

            if ($resultado == null) {
                return back()->with('flash', ['erro' => 'Essa oferta já está no carrinho.']);
            }
        } else {
            $cookie = json_decode($request->cookie('carrinho', '[]'), true);

            foreach ($cookie as $item) {
                if ($item['ofertas_id'] == $oferta_id) {
                    return back()->with('flash', ['erro' => 'Essa oferta já está no carrinho.']);
                }
            }

            $resultado = [
                'id' => uniqid(),
                'ofertas_id' => $oferta_id,
            ];

            $cookie[] = $resultado;

            $json = json_encode($cookie);
            $tempo = 60 * 24 * 7;
            cookie()->queue('carrinho', $json, $tempo);
        }

        return back()->with('flash', [
            'sucesso' => 'Item adicionado ao carrinho com sucesso!',
        ]);
    }

    public function remover(Request $request)
    {
        $oferta_id = $request->input('oferta_id');

        if ($request->user()) {
            $id_usuario = $request->user()->id;
            Carrinhos::excluirItemPorIdEUsuario($id_usuario, $oferta_id);
        } else {
            $cookie = json_decode($request->cookie('carrinho', '[]'), true);
            $updatedCart = array_filter($cookie, function ($item) use ($oferta_id) {
                return $item['ofertas_id'] != $oferta_id;
            });

            cookie()->queue('carrinho', json_encode(array_values($updatedCart)), 60 * 24 * 7);
        }

        return redirect()->back()->with('flash', [
            'sucesso' => 'Item removido do carrinho com sucesso!',
        ]);
    }

    public function limpar(Request $request)
    {
        if ($request->user()) {
            $id_usuario = $request->user()->id;
            Carrinhos::excluirTodosPorUsuario($id_usuario);
        } else {
            cookie()->queue(cookie()->forget('carrinho'));
        }

        return redirect()->back()->with('flash', [
            'sucesso' => 'Carrinho limpo com sucesso!',
        ]);
    }
}
