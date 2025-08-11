<?php

namespace App\Http\Controllers\Enderecos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Enderecos;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use \App\Models\Estados;
use \App\Models\Paises;

class CriarEnderecoController extends Controller
{
    public function mostrar(): \Inertia\Response
    {
        return Inertia::render('enderecos/AdicionarEndereco', [
            'estados' => Estados::all()
        ]);
    }

    public function criarEndereco(Request $request): RedirectResponse
    {
        $request->validate([
            'estados_id' => 'required|exists:estados,id',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:100',
            'cep' => 'required|string|max:8'
        ]);

        $data = array_merge($request->all(), ['usuarios_id' => Auth::id()]);
        Enderecos::create($data);

        return to_route('enderecos');
    }
}
