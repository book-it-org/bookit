<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Generos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Renderiza a pagina home
     */
    public function mostrarHome(Request $request): Response
    {
        $generos = Generos::all();
        return Inertia::render('Home', ['generos' => $generos]);
    }
}
