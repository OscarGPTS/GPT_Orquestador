<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProviderApplicationController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;

Route::get('/', [HomeController::class, 'index']);

// Formulario público de proveedores (sin autenticación)
Route::prefix('proveedores')->name('providers.')->group(function () {
    Route::get('registro', [ProviderApplicationController::class, 'create'])->name('register');
    Route::post('registro', [ProviderApplicationController::class, 'store'])->name('register.store');
    Route::get('registro/gracias', [ProviderApplicationController::class, 'thankyou'])->name('register.thankyou');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    
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

    // Rutas de gestión de solicitudes de proveedores (solo compras)
    Route::prefix('compras')->name('purchasing.')->middleware('role:purchasing')->group(function () {
        Route::prefix('solicitudes')->name('applications.')->group(function () {
            Route::get('/', [PurchasingController::class, 'index'])->name('index');
            Route::get('{application}', [PurchasingController::class, 'show'])->name('show');
            Route::get('{application}/revisar', [PurchasingController::class, 'edit'])->name('edit');
            Route::post('{application}/aprobar', [PurchasingController::class, 'approve'])->name('approve');
            Route::post('{application}/rechazar', [PurchasingController::class, 'reject'])->name('reject');
            Route::get('{application}/descargar/{documentType}', [PurchasingController::class, 'downloadDocument'])->name('download');
        });
    });
});

