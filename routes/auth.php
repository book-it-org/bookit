<?php

use App\Http\Controllers\Auth\UsuarioAutenticadoController;
use App\Http\Controllers\Auth\ConfirmarSenhaController;
use App\Http\Controllers\Auth\NotificacaoVerificarEmailController;
use App\Http\Controllers\Auth\AvisoVerificarEmailController;
use App\Http\Controllers\Auth\NovaSenhaController;
use App\Http\Controllers\Auth\ResetarSenhaLinkController;
use App\Http\Controllers\Auth\RegistrarUsuarioController;
use App\Http\Controllers\Auth\VerificarEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('registrar', [RegistrarUsuarioController::class, 'create'])
        ->name('registrar');

    Route::post('registrar', [RegistrarUsuarioController::class, 'store']);

    Route::get('entrar', [UsuarioAutenticadoController::class, 'create'])
        ->name('entrar');

    Route::post('entrar', [UsuarioAutenticadoController::class, 'store']);

    Route::get('recuperar-senha', [ResetarSenhaLinkController::class, 'create'])
        ->name('senha.recuperar');

    Route::post('recuperar-senha', [ResetarSenhaLinkController::class, 'store'])
        ->name('senha.email');

    Route::get('recuperar-senha/{token}', [NovaSenhaController::class, 'create'])
        ->name('senha.resetar');

    Route::post('recuperar-senha', [NovaSenhaController::class, 'store'])
        ->name('senha.salvar');
});

Route::middleware('auth')->group(function () {
    Route::get('verificar-email', AvisoVerificarEmailController::class)
        ->name('verificacao.avisar');

    Route::get('verificar-email/{id}/{hash}', VerificarEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verificacao.verificar');

    Route::post('email/verification-notification', [NotificacaoVerificarEmailController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verificacao.enviar');

    Route::get('confirmar-senha', [ConfirmarSenhaController::class, 'show'])
        ->name('senha.confirmar');

    Route::post('confirmar-senha', [ConfirmarSenhaController::class, 'store']);

    Route::post('sair', [UsuarioAutenticadoController::class, 'destroy'])
        ->name('sair');
});
