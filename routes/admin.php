<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\AutenticarUsuarioAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AutenticarUsuarioAdmin::class])->group(function () {
    Route::get('admin', [AdminController::class, 'mostrar'])->name('admin');
});
