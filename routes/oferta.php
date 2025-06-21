<?php

use App\Http\Controllers\Ofertas\AnunciarOfertaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('oferta/anunciar', [AnunciarOfertaController::class, 'mostrar'])->name('oferta.anunciar');
});
