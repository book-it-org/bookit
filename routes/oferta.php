<?php

use App\Http\Controllers\Ofertas\OfertaController;
use App\Http\Controllers\Ofertas\CriarOfertaController;
use Illuminate\Support\Facades\Route;

Route::get("oferta/{id}/{titulo_oferta?}", [OfertaController::class, 'mostrar'])->name('oferta');

Route::middleware('auth')->group(function () {
    Route::post("oferta", [CriarOfertaController::class, 'criarOferta'])->name('oferta.criar');
    Route::put("oferta/{id}", [CriarOfertaController::class, 'editarOferta'])->name('oferta.editar');
});

