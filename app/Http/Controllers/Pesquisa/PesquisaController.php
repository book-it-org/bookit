<?php

namespace App\Http\Controllers\Pesquisa;

use App\Enums\EstadoLivro;
use App\Http\Controllers\Controller;
use App\Models\Idiomas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Generos;

class PesquisaController extends Controller
{
    /**
     * Renderiza a pagina de pesquisa
     */
    public function mostrarPesquisa(Request $request): Response
    {
        $generos = Generos::all();
        $idiomas = Idiomas::all();
        $estados = EstadoLivro::values();

        return Inertia::render('Pesquisa', [
            "estados" => $estados,
            "generos" => $generos,
            "idiomas" => $idiomas
        ]);
    }
}
