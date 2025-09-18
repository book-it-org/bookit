<?php

use App\Http\Controllers\Ofertas\OfertaController;
use App\Http\Controllers\Ofertas\CriarOfertaController;
use Illuminate\Support\Facades\Route;

Route::get("oferta/{id}/{titulo_oferta?}", [OfertaController::class, 'mostrar'])->name('oferta');
Route::post("oferta", [CriarOfertaController::class, 'criarOferta'])->name('oferta.criar');

