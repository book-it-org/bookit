<?php

use App\Http\Controllers\Auth\EntrarUsuarioController;
use App\Http\Controllers\Auth\ConfirmarSenhaController;
use App\Http\Controllers\Auth\NotificacaoVerificarEmailController;
use App\Http\Controllers\Auth\AvisoVerificarEmailController;
use App\Http\Controllers\Auth\NovaSenhaController;
use App\Http\Controllers\Auth\ResetarSenhaLinkController;
use App\Http\Controllers\Auth\RegistrarUsuarioController;
use App\Http\Controllers\Auth\VerificarEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('registrar', [RegistrarUsuarioController::class, 'mostrar'])
        ->name('registrar');

    Route::post('registrar', [RegistrarUsuarioController::class, 'criarUsuario']);

    Route::get('entrar', [EntrarUsuarioController::class, 'mostrar'])
        ->name('entrar');

    Route::post('entrar', [EntrarUsuarioController::class, 'entrarUsuario']);

    Route::get('recuperar-senha', [ResetarSenhaLinkController::class, 'mostrar'])
        ->name('senha.recuperar');

    Route::post('recuperar-senha', [ResetarSenhaLinkController::class, 'mandarLink'])
        ->name('senha.email');

    Route::get('recuperar-senha/{token}', [NovaSenhaController::class, 'mostrar'])
        ->name('senha.resetar');

    Route::post('recuperar-senha', [NovaSenhaController::class, 'salvarSenha'])
        ->name('senha.salvar');
});

Route::middleware('auth')->group(function () {
    Route::get('verificar-email', AvisoVerificarEmailController::class)
        ->name('verificacao.avisar');

    Route::get('verificar-email/{id}/{hash}', VerificarEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verificacao.verificar');

    Route::post('email/verification-notification', [NotificacaoVerificarEmailController::class, 'notificarEmail'])
        ->middleware('throttle:6,1')
        ->name('verificacao.enviar');

    Route::get('confirmar-senha', [ConfirmarSenhaController::class, 'mostrar'])
        ->name('senha.confirmar');

    Route::post('confirmar-senha', [ConfirmarSenhaController::class, 'confirmarSenha']);

    Route::post('sair', [EntrarUsuarioController::class, 'sairUsuario'])
        ->name('sair');
});
