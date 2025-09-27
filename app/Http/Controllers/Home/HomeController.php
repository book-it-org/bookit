<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Generos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Ofertas;

class HomeController extends Controller
{
    /**
     * Renderiza a pagina home
     */
    public function mostrarHome(Request $request): Response
    {
        $recomendadas = Ofertas::ofertasRecomendadas();
        $generos = Generos::all();
        return Inertia::render('Home', ['generos' => $generos, 
        'recomendadas' => $recomendadas]);
    }
}
