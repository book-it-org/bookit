<?php

namespace App\Http\Controllers\Enderecos;

use App\Http\Controllers\Controller;
use App\Models\Enderecos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EnderecoController extends Controller
{
    public function mostrar(): \Inertia\Response
    {
        $id_usuario = Auth::id();
        $enderecos = Enderecos::porUsuario($id_usuario);

        return Inertia::render('enderecos/Enderecos', [
            'enderecos' => $enderecos,
        ]);
    }
}
