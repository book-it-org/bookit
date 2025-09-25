<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Ofertas;
use App\Models\Generos;


class OfertaController extends Controller
{
    /**
     * Renderiza a pagina de anunciar um livro
     */
    public function mostrar(string $id): Response
    {
        $generos = Generos::all();
        return Inertia::render('oferta/Oferta', [
            'id_oferta' => $id,
            'generos' => $generos
        ]);
    }

}