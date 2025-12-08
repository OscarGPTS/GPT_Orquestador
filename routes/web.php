<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

Route::middleware('auth')->group(function () {
    // Dashboard (muestra vista según rol del usuario)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/logout/google', [GoogleController::class, 'logout'])->name('google.logout');
    
    // Rutas de administración de sitios (solo admin)
    Route::middleware('role:admin')->group(function () {
        Route::resource('sites', SiteController::class);
        Route::post('sites/{site}/check', [SiteController::class, 'checkStatus'])->name('sites.check');
    });
});

