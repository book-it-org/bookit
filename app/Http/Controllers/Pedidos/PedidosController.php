<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PedidosController extends Controller
{
    /**
     * Renderiza a pagina de pedidos
     */
    public function mostrar(Request $request): Response
    {
        return Inertia::render('Pedidos');
    }
}
