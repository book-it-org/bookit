<?php

use App\Http\Controllers\Ofertas\AnunciarOfertaController;
use App\Http\Controllers\Ofertas\OfertaController;
use Illuminate\Support\Facades\Route;

Route::get("oferta/{id}", [OfertaController::class, 'mostrar'])->name('oferta');

Route::middleware('auth')->group(function () {
    Route::get('oferta/anunciar', [AnunciarOfertaController::class, 'mostrar'])->name('oferta.anunciar');
});
