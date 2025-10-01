<?php

namespace App\Http\Controllers\Anuncios;

use App\Enums\EstadoLivro;
use App\Http\Controllers\Controller;
use App\Models\Generos;
use App\Models\Idiomas;
use App\Models\Ofertas;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AnunciarController extends Controller
{
    /**
     * Renderiza a pagina de anunciar um livro
     */
    public function mostrarFormulario(Request $request): Response
    {
        $generos = Generos::all();
        $idiomas = Idiomas::all();
        $estados = EstadoLivro::values();
        $oferta = null;

        if ($request->has('editando')) {
            $ofertaId = $request->query('editando');
            $oferta = Ofertas::buscarOfertaParaEdicao($ofertaId, Auth::id());

            if (! $oferta) {
                abort(404, 'Oferta não encontrada ou você não tem permissão para editá-la.');
            }
        }

        return Inertia::render('anuncios/Anunciar', [
            'estados' => $estados,
            'generos' => $generos,
            'idiomas' => $idiomas,
            'oferta' => $oferta,
            'editando' => $request->has('editando'),
        ]);
    }
}
