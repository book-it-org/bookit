<?php

namespace App\Http\Controllers\Enderecos;

use App\Http\Controllers\Controller;
use App\Models\Enderecos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ExcluirEnderecoController extends Controller
{
    public function excluirEndereco(Request $request): RedirectResponse
    {
        $id = $request->route('id');
        $endereco = Enderecos::excluirEnderecoPorIdEUsuario($id, Auth::id());

        if (! $endereco) {
            abort(404, 'Endereço não encontrado');
        }

        return Redirect::route('enderecos');
    }
}
