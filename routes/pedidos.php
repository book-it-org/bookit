<?php

use App\Http\Controllers\Compras\ComprasController;
use App\Http\Controllers\Pedidos\ConfirmarPedidoController;
use App\Http\Controllers\Pedidos\PagarPedidoController;
use App\Http\Controllers\Pedidos\PedidosController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('pedidos', [PedidosController::class, 'mostrar'])->name('pedidos');
    Route::get('pedido/confirmar', [ConfirmarPedidoController::class, 'mostrar'])->name('pedido.confirmar');

    Route::get('pedido/{id}/pagar', [PagarPedidoController::class, 'mostrar'])->name('pedido.pagar');
    Route::post('pedido/{id}/pagar', [PagarPedidoController::class, 'pagar']);

    // visualizar uma compra/pedido
    Route::get('pedido/{id}/visualizar', [PedidosController::class, 'visualizar'])->name('pedido.visualizar');
    Route::post('pedido/{id}/cancelar', [PedidosController::class, 'cancelar'])->name('pedido.cancelar');
    Route::post('pedido/{id}/confirmar-recebimento', [PedidosController::class, 'confirmarRecebimento'])->name('pedido.confirmar.recebimento');

    // avaliar vendedor para um pedido específico
    Route::post('pedido/{pedido}/avaliar', [\App\Http\Controllers\Avaliacoes\AvaliacoesController::class, 'store'])->name('pedido.avaliar');

    Route::post('pedido/comprar', [ComprasController::class, 'comprar'])->name('comprar');
});
