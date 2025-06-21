<?php

use App\Http\Controllers\Pedidos\PedidosController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('pedidos', [PedidosController::class, 'mostrar'])->name('pedidos');
});
