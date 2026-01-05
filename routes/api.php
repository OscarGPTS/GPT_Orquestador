<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserDatabase2Controller;


// Rutas para la segunda base de datos (RH)
Route::prefix('rh')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserDatabase2Controller::class, 'index']);
        Route::post('/buscar-por-email', [UserDatabase2Controller::class, 'getByEmail']);
        Route::get('/{userId}', [UserDatabase2Controller::class, 'show']);
    });
});
