<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class OfertaController extends Controller
{
    /**
     * Renderiza a pagina de anunciar um livro
     */
    public function mostrar(string $id): Response
    {
        return Inertia::render('oferta/Oferta', [
            'id_oferta' => $id
        ]);
    }
}
