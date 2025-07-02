<?php

namespace App\Http\Controllers\Carrinho;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Generos;

class CarrinhoController extends Controller
{
    /**
     * Renderiza a pagina do carrinho
     */
    public function mostrar(Request $request): Response
    {
        $generos = Generos::all();
        return Inertia::render('Carrinho', ['generos' => $generos]);
    }
}
