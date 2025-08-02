<?php

use App\Http\Controllers\Enderecos\RegistrarEnderecoController;
use Illuminate\Support\Facades\Route;

Route::get('endereco/criar', [RegistrarEnderecoController::class, 'mostrar'])->name('endereco.criar');
Route::post('endereco/criar', [RegistrarEnderecoController::class, 'registrarEndereco'])->name('endereco.store');

