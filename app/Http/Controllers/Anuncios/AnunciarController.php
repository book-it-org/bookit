<?php

namespace App\Http\Controllers\Anuncios;

use App\Enums\EstadoLivro;
use App\Http\Controllers\Controller;
use App\Models\Generos;
use App\Models\Idiomas;
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

        return Inertia::render('anuncios/Anunciar', [
            "estados" => $estados,
            "generos" => $generos,
            "idiomas" => $idiomas
        ]);
    }
}
