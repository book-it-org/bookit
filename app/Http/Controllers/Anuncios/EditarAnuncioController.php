<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Controller;
use App\Models\Ofertas;
use App\Models\Pedidos;
use Illuminate\Http\Request;

class EditarAnuncioController extends Controller
{
    public function desativarOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($oferta->usuarios_id !== $usuario->id) {
            return redirect()->back()->with('flash', ['erro' => 'Você não tem permissão para desativar esta oferta.']);
        }

        // não permitir desativar se a oferta estiver em um pedido ativo
        $pedidoAtivo = Pedidos::where('oferta_id', $oferta->id)->where('estado', '!=', 'cancelado')->exists();
        if ($pedidoAtivo) {
            return redirect()->back()->with('flash', ['erro' => 'Não é possível desativar esta oferta enquanto ela estiver em um pedido ativo.']);
        }

        $oferta->desativar();

        return redirect()->back()->with('flash', [
            'sucesso' => 'Oferta desativada com sucesso.',
        ]);
    }

    public function ativarOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($oferta->usuarios_id !== $usuario->id) {
            return redirect()->back()->with('flash', ['erro' => 'Você não tem permissão para ativar esta oferta.']);
        }

        // não permitir bloquear se a oferta estiver em um pedido ativo
        $pedidoAtivo = Pedidos::where('oferta_id', $oferta->id)->where('estado', '!=', 'cancelado')->exists();
        if ($pedidoAtivo) {
            return redirect()->back()->with('flash', ['erro' => 'Não é possível bloquear esta oferta enquanto ela estiver em um pedido ativo.']);
        }

        if ($oferta->bloqueado) {
            return redirect()->back()->with('flash', ['erro' => 'Não é possível ativar uma oferta bloqueada.']);
        }

        $oferta->ativar();

        return redirect()->back()->with('flash', [
            'sucesso' => 'Oferta bloqueada com sucesso.',
        ]);
    }

    public function bloquearOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($usuario->verificarAdmin()) {
            $oferta->bloquear();
            $oferta->desativar();

            return redirect()->back()->with('flash', [
                'sucesso' => 'Oferta bloqueada com sucesso.',
            ]);
        } else {
            return redirect()->back()->with('flash', [
                'erro' => 'Você não tem permissão para bloquear esta oferta.',
            ]);
        }

    }

    public function desbloquearOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($usuario->verificarAdmin()) {
            $oferta->desbloquear();

            return redirect()->back()->with('flash', [
                'sucesso' => 'Oferta desbloqueada com sucesso.',
            ]);
        } else {
            return redirect()->back()->with('flash', [
                'erro' => 'Você não tem permissão para desbloquear esta oferta.',
            ]);
        }

    }

    public function alterarPrecoOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $novoPreco = $request->input('novoPreco');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($oferta->usuarios_id === $usuario->id && $novoPreco !== null) {
            $oferta->alterarPreco($novoPreco);

            return redirect()->back()->with('flash', [
                'sucesso' => 'Preço da oferta alterado com sucesso.',
            ]);
        } else {
            return redirect()->back()->with('flash', [
                'erro' => 'Você não tem permissão para alterar o preço desta oferta ou o novo preço é inválido.',
            ]);
        }
    }
}
