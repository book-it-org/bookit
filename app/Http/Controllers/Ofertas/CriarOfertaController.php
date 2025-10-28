<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use App\Models\Ofertas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CriarOfertaController extends Controller
{
    public function criarOferta(Request $request): RedirectResponse
    {
        $request->validate([
            'generos_id' => 'required|exists:generos,id',
            'idiomas_id' => 'required|exists:idiomas,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'preco' => 'required|numeric|min:0',
            'titulo_livro' => 'required|string|max:255',
            'autor_livro' => 'required|string|max:255',
            'estado_livro' => 'required',
            'isbn_livro' => 'required|string|max:13',
            'data_publicacao_livro' => 'required|date',
        ]);

        $data = array_merge($request->all(), ['usuarios_id' => Auth::id()]);
        $oferta = Ofertas::criarOfertaComGenero($data, $request->generos_id);

        return Redirect::route('anuncios');
    }

    public function editarOferta(Request $request, $id): RedirectResponse
    {
        $oferta = Ofertas::buscarOfertaPorIdEUsuario($id, Auth::id());

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'preco' => 'required|numeric|min:0',
        ]);

        $oferta->editar($request->titulo, $request->descricao, $request->preco);

        return Redirect::route('anuncios');
    }
}
