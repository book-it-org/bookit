<?php

namespace App\Http\Controllers\Carrinho;

use App\Http\Controllers\Controller;
use App\Models\Carrinhos;
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

        if ($request->user()) {
            $id_usuario = $request->user()->id;
            Carrinhos::criarItem($id_usuario, $oferta_id);
        } else {
            $cookie = json_decode($request->cookie('carrinho', '[]'), true);

            $cookie[] = [
                'id' => uniqid(),
                'ofertas_id' => $oferta_id,
            ];

            $json = json_encode($cookie);
            $tempo = 60 * 24 * 7;
            cookie()->queue('carrinho', $json, $tempo);
        }

        return redirect()->back()->with('success', 'Item adicionado ao carrinho com sucesso!');
    }

    public function remover(Request $request)
    {
        $item_id = $request->input('item_id');

        if ($request->user()) {
            $id_usuario = $request->user()->id;
            Carrinhos::excluirItemPorIdEUsuario($id_usuario, $item_id);
        } else {
            $cookie = json_decode($request->cookie('carrinho', '[]'), true);
            $updatedCart = array_filter($cookie, function ($item) use ($item_id) {
                return $item['id'] != $item_id;
            });

            cookie()->queue('carrinho', json_encode(array_values($updatedCart)), 60 * 24 * 7);
        }

        return redirect()->back()->with('success', 'Item removido do carrinho com sucesso!');
    }

    public function limpar(Request $request)
    {
        if ($request->user()) {
            $id_usuario = $request->user()->id;
            Carrinhos::excluirTodosPorUsuario($id_usuario);
        } else {
            cookie()->queue(cookie()->forget('carrinho'));
        }

        return redirect()->back()->with('success', 'Carrinho limpo com sucesso!');
    }
}
