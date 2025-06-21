<?php

use App\Http\Controllers\Configuracao\ConfiguracaoContaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::redirect('configuracao', '/configuracao/conta');
    Route::get('configuracao/conta', [ConfiguracaoContaController::class, 'mostrar'])->name('config.conta');
});
