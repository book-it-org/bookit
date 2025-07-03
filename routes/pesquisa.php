<?php

use App\Http\Controllers\Pesquisa\PesquisaController;
use Illuminate\Support\Facades\Route;

Route::get('pesquisa', [PesquisaController::class, 'mostrarPesquisa'])->name('pesquisa');
