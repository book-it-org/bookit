<?php

namespace App\Http\Controllers\Enderecos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnderecoController extends Controller
{
    public function mostrar(): \Inertia\Response
    {
        return Inertia::render('enderecos/Enderecos');
    }
}
