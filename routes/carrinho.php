<?php

use App\Http\Controllers\Carrinho\CarrinhoController;
use Illuminate\Support\Facades\Route;

Route::get('carrinho', [CarrinhoController::class, 'mostrar'])->name('carrinho');

Route::post('carrinho/adicionar', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');

Route::delete('carrinho/remover', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::delete('carrinho/limpar', [CarrinhoController::class, 'limpar'])->name('carrinho.limpar');
