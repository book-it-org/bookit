<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AnunciarOfertaController extends Controller
{
    /**
     * Renderiza a pagina de anunciar um livro
     */
    public function mostrar(Request $request): Response
    {
        return Inertia::render('oferta/Anunciar');
    }
}
