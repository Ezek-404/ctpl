<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CocController;
use App\Http\Controllers\CtplIssuanceController;
use Illuminate\Support\Facades\Route;

// Guest Routes (Accessible only if NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/', [AuthController::class, 'login']); // Updated to process POST requests on the root URL
});

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Accessible only if logged in)
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    
    // Main LTO Menu selection screen from {A423A2C4-B70F-4D9B-A194-689DB2EE47AB}.jpg
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/dashboard/coc', [CocController::class, 'index'])->name('dashboard.coc');
    Route::get('/coc', [CocController::class, 'index'])->name('cocs.index');
    Route::post('/coc', [CocController::class, 'store'])->name('coc.store');
    Route::delete('/coc/{id}', [CocController::class, 'destroy'])->name('coc.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('dashboard.profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/dashboard/ctpl-issuance', [CtplIssuanceController::class, 'index'])->name('dashboard.ctpl-issuance');
    Route::get('/ctpl/check-coc', [CtplIssuanceController::class, 'checkCoc'])->name('ctpl.check-coc');
    Route::post('/dashboard/ctpl-issuance', [CtplIssuanceController::class, 'store'])->name('ctpl.store');
    Route::get('/ctpl/get-vehicle-details', [App\Http\Controllers\CtplIssuanceController::class, 'getVehicleDetails'])->name('ctpl.get-vehicle-details');
});