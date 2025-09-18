<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use App\Models\Generos;
use App\Models\Ofertas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class OfertaController extends Controller
{
    /**
     * Renderiza a pagina de anunciar um livro
     */
    public function mostrar(int $id, ?string $titulo_oferta = null): Response|RedirectResponse
    {
        $oferta = Ofertas::where('id', $id)->with(['generos', 'idioma', 'usuario'])->first();

        if (!$oferta) {
            abort(404, 'Oferta não encontrada.');
        }

        $titulo_slug = $oferta->tituloParaSlug();
        if ($titulo_oferta !== $titulo_slug) {
            return Redirect::route('oferta', [
                'id' => $id,
                'titulo_oferta' => $titulo_slug,
            ]);
        }

        $generos = Generos::all();

        return Inertia::render('oferta/Oferta', [
            'oferta' => $oferta,
            'generos' => $generos,
        ]);
    }
}
