<?php

namespace App\Http\Controllers\Enderecos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Enderecos;
use Inertia\Inertia;

class RegistrarEnderecoController extends Controller
{
    public function mostrar(): \Inertia\Response
    {
        return Inertia::render('enderecos/Registrar');
    }

    public function registrarEndereco(Request $request): RedirectResponse
    {
        $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'estados_id' => 'required|exists:estados,id',
            'paises_id' => 'required|exists:paises,id',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:100',
            'cep' => 'required|string|max:8'
        ]);

        Enderecos::create($request->all());

        return to_route('config.conta');
    }
}
