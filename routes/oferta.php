<?php

use App\Http\Controllers\Ofertas\OfertaController;
use App\Http\Controllers\Ofertas\CriarOfertaController;
use Illuminate\Support\Facades\Route;

Route::get("oferta/{id}", [OfertaController::class, 'mostrar'])->name('oferta');
Route::get("oferta/criar", [CriarOfertaController::class, 'mostrar'])->name('oferta.criar');
Route::post("oferta/criar", [CriarOfertaController::class, 'criarOferta'])->name('oferta.sstore');
