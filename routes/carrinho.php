<?php


use App\Http\Controllers\Carrinho\CarrinhoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('carrinho', [CarrinhoController::class, 'mostrar'])->name('carrinho');
});
