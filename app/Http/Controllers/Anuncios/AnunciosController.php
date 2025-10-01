<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Controller;
use App\Models\Ofertas;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AnunciosController extends Controller
{
    /**
     * Renderiza a pagina de anúncios do usuário
     */
    public function mostrarAnuncios(Request $request): Response
    {
        $usuario = Auth::user();
        $ofertas = Ofertas::buscarOfertasDoUsuario($usuario->id);

        return Inertia::render('anuncios/Anuncios', [
            'ofertas' => $ofertas,
        ]);
    }
}
