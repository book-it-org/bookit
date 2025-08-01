<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Ofertas ;
use Inertia\Inertia;

class CriarOfertaController extends Controller
{
    public function mostrar(): \Inertia\Response
    {
        return Inertia::render('ofertas/Criar');
    }

    public function criarOferta(Request $request): RedirectResponse
    {
        $request->validate([
            'genero_id' => 'required|exists:generos,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'preco' => 'required|numeric|min:0',
            'titulo_livro' => 'required|string|max:255',
            'autor_livro' => 'required|string|max:255',
            'estado_livro' => 'required',
            'isbn' => 'required|string|max:13',
            'data_publicacao_livro' => 'required|date',
        ]);

        Ofertas::create($request->all());

        return to_route('home');
    }
}
