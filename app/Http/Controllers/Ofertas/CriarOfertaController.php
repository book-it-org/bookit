<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Ofertas ;
use App\Models\OfertasGenero;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        $oferta = Ofertas::create($data);

        OfertasGenero::create([
            'ofertas_id' => $oferta->id,
            'generos_id' => $request->generos_id,
        ]);

        return to_route('home');
    }
}
