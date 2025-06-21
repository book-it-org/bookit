<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{
    /**
     * Renderiza a pagina de chat
     */
    public function mostrar(Request $request): Response
    {
        return Inertia::render('Chat');
    }
}
