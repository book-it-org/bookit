<?php

use App\Http\Controllers\Enderecos\CriarEnderecoController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Enderecos\EnderecoController;

# Frontend
Route::get('enderecos', [EnderecoController::class, 'mostrar'])->name('enderecos');
Route::get('enderecos/adicionar', [CriarEnderecoController::class, 'mostrar'])->name('enderecos.adicionar');

# Backend
Route::post('enderecos', [CriarEnderecoController::class, 'criarEndereco'])->name('enderecos.criar');

