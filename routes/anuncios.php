<?php

use App\Http\Controllers\Anuncios\AnunciarController;
use App\Http\Controllers\Anuncios\AnunciosController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('anuncios', [AnunciosController::class, 'mostrarAnuncios'])->name('anuncios');
    Route::get('anunciar', [AnunciarController::class, 'mostrarFormulario'])->name('anuncios.formulario');
});
