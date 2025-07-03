<?php

use App\Http\Controllers\Carrinho\CarrinhoController;
use Illuminate\Support\Facades\Route;

Route::get('carrinho', [CarrinhoController::class, 'mostrarCarrinho'])->name('carrinho');
