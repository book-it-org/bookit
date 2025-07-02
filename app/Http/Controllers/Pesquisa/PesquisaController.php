<?php

namespace App\Http\Controllers\Pesquisa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Generos;

class PesquisaController extends Controller
{
    /**
     * Renderiza a pagina de pesquisa
     */
    public function mostrar(Request $request): Response
    {
        $generos = Generos::all();
        return Inertia::render('Pesquisa', ['generos' => $generos]);
    }
}
