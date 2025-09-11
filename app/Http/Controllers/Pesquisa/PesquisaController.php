<?php

namespace App\Http\Controllers\Pesquisa;

use App\Enums\EstadoLivro;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pesquisa\PesquisaRequest;
use App\Models\Idiomas;
use App\Models\Ofertas;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Generos;
use Log;


class PesquisaController extends Controller
{
    public function mostrarPesquisa(PesquisaRequest $request): Response
    {
        $filtros = $request->getFiltros();
        $ofertas = Ofertas::pesquisarOferta(
            $filtros['pesquisa'] ?: null,
            $filtros['genero'] !== '*' ? $filtros['genero'] : null,
            $filtros['idioma'] !== '*' ? $filtros['idioma'] : null,
            $filtros['estado'] !== '*' ? $filtros['estado'] : null,
            $filtros['min'] ? (float) $filtros['min'] : null,
            $filtros['max'] ? (float) $filtros['max'] : null,
            $filtros['ordem'] ?: null
        );

        $generos = Generos::all();
        $idiomas = Idiomas::all();
        $estados = EstadoLivro::values();

        return Inertia::render('Pesquisa', [
            'estados' => $estados,
            'generos' => $generos,
            'idiomas' => $idiomas,
            'ofertas' => $ofertas,
            'filtros' => $filtros,
        ]);
    }
}
