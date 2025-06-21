<?php

namespace App\Http\Controllers\Carrinho;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CarrinhoController extends Controller
{
    /**
     * Renderiza a pagina do carrinho
     */
    public function mostrar(Request $request): Response
    {
        return Inertia::render('Carrinho');
    }
}
