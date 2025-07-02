<?php

use App\Http\Controllers\Ofertas\OfertaController;
use Illuminate\Support\Facades\Route;

Route::get("oferta/{id}", [OfertaController::class, 'mostrar'])->name('oferta');
