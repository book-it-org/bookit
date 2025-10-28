<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Controller;
use App\Models\Ofertas;
use Illuminate\Http\Request;

class EditarAnuncioController extends Controller
{
    public function desativarOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($oferta->usuarios_id === $usuario->id) {
            $oferta->desativar();
            return redirect()->back()->with('success', 'Oferta desativada com sucesso.');
        }else{
            return redirect()->back()->with('error', 'Você não tem permissão para desativar esta oferta.');
        }
    }

    public function ativarOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($oferta->usuarios_id === $usuario->id && !$oferta->bloqueado) {
            $oferta->ativar();
            return redirect()->back()->with('success', 'Oferta ativada com sucesso.');
        }else{
            return redirect()->back()->with('error', 'Você não tem permissão para ativar esta oferta.');
        }

    }

    public function bloquearOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($usuario->verificarAdmin()) {
            $oferta->bloquear();
            $oferta->desativar();
            return redirect()->back()->with('success', 'Oferta bloqueada com sucesso.');
        }else{
            return redirect()->back()->with('error', 'Você não tem permissão para bloquear esta oferta.');
        }

    }

    public function desbloquearOferta(Request $request)
    {
        $id = $request->route()->parameter('id');
        $oferta = Ofertas::findOrFail($id);
        $usuario = $request->user();
        if ($usuario->verificarAdmin()) {
            $oferta->desbloquear();
            return redirect()->back()->with('success', 'Oferta desbloqueada com sucesso.');
        }else{
            return redirect()->back()->with('error', 'Você não tem permissão para desbloquear esta oferta.');
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
            return redirect()->back()->with('success', 'Preço da oferta alterado com sucesso.');
        }else{
            return redirect()->back()->with('error', 'Você não tem permissão para alterar o preço desta oferta.');
        }
    }
}
