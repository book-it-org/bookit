<?php

use App\Http\Controllers\Enderecos\CriarEnderecoController;
use App\Http\Controllers\Enderecos\EnderecoController;
use App\Http\Controllers\Enderecos\ExcluirEnderecoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('enderecos', [EnderecoController::class, 'mostrar'])->name('enderecos');
    Route::get('enderecos/adicionar', [CriarEnderecoController::class, 'mostrar'])->name('enderecos.adicionar');

    Route::post('endereco', [CriarEnderecoController::class, 'criarEndereco'])->name('endereco.criar');
    Route::delete('endereco/{id}', [ExcluirEnderecoController::class, 'excluirEndereco'])->name('endereco.excluir');
});
