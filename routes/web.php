<?php

use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',[HomeController::class, 'mostrarHome'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/configuracao.php';
require __DIR__ . '/carrinho.php';
require __DIR__ . '/oferta.php';
require __DIR__ . '/pedidos.php';
require __DIR__ . '/anuncios.php';
require __DIR__ . '/chat.php';
require __DIR__ . '/pesquisa.php';
