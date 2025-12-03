<?php

use App\Http\Controllers\Anuncios\AnunciarController;
use App\Http\Controllers\Anuncios\AnunciosController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Anuncios\EditarAnuncioController;

Route::middleware('auth')->group(function () {
    Route::get('anuncios', [AnunciosController::class, 'mostrarAnuncios'])->name('anuncios');
    Route::get('anuncio/{id}/visualizar', [AnunciosController::class, 'visualizar'])->name('anuncio.visualizar');
    Route::get('anunciar', [AnunciarController::class, 'mostrarFormulario'])->name('anuncios.formulario');
    Route::post('anuncios/{id}/desativar', [EditarAnuncioController::class, 'desativarOferta'])->name('anuncios.desativar');
    Route::post('anuncios/{id}/ativar', [EditarAnuncioController::class, 'ativarOferta'])->name('anuncios.ativar');
    Route::post('anuncios/{id}/bloquear', [EditarAnuncioController::class, 'bloquearOferta'])->name('anuncios.bloquear');
    Route::post('anuncios/{id}/desbloquear', [EditarAnuncioController::class, 'desbloquearOferta'])->name('anuncios.desbloquear');
});
