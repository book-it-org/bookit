<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AnunciosController extends Controller
{
    /**
     * Renderiza a pagina de anunciar um livro
     */
    public function mostrarAnuncios(Request $request): Response
    {
        return Inertia::render('anuncios/Anuncios');
    }
}
