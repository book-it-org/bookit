<?php

use App\Http\Controllers\Chat\ChatController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('chat', [ChatController::class, 'mostrar'])->name('chat');
});
