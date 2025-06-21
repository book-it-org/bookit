<?php

namespace App\Http\Controllers\Configuracao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConfiguracaoContaController extends Controller
{
    /**
     * Renderiza a pagina de configuracao de conta
     */
    public function mostrar(Request $request): Response
    {
        return Inertia::render('configuracao/ConfiguracaoConta');
    }
}
