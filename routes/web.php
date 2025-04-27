<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TransportController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'searchForm'])->name('search');
Route::post('/search', [HomeController::class, 'search'])->name('search.results');
Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
Route::get('/routes/{route}', [RouteController::class, 'show'])->name('routes.show');
Route::get('/transports', [TransportController::class, 'index'])->name('transports.index');
Route::get('/transports/{transport}', [TransportController::class, 'show'])->name('transports.show');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin authentication routes
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

// Protected user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{reservation}/print', [ReservationController::class, 'print'])->name('reservations.print');
});

// Admin routes
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');
    
    // Routes management
    Route::get('/routes', [RouteController::class, 'adminIndex'])->name('routes.index');
    Route::get('/routes/create', [RouteController::class, 'create'])->name('routes.create');
    Route::post('/routes', [RouteController::class, 'store'])->name('routes.store');
    Route::get('/routes/{route}/edit', [RouteController::class, 'edit'])->name('routes.edit');
    Route::put('/routes/{route}', [RouteController::class, 'update'])->name('routes.update');
    Route::delete('/routes/{route}', [RouteController::class, 'destroy'])->name('routes.destroy');
    
    // Reservations management
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations.index');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    
    // Transports management
    Route::get('/transports', [TransportController::class, 'adminIndex'])->name('transports.index');
    Route::get('/transports/create', [TransportController::class, 'create'])->name('transports.create');
    Route::post('/transports', [TransportController::class, 'store'])->name('transports.store');
    Route::get('/transports/{transport}/edit', [TransportController::class, 'edit'])->name('transports.edit');
    Route::put('/transports/{transport}', [TransportController::class, 'update'])->name('transports.update');
    Route::delete('/transports/{transport}', [TransportController::class, 'destroy'])->name('transports.destroy');
    
    // Transport types management
    Route::get('/transport-types', [TransportController::class, 'typeIndex'])->name('transport-types.index');
    Route::get('/transport-types/create', [TransportController::class, 'typeCreate'])->name('transport-types.create');
    Route::post('/transport-types', [TransportController::class, 'typeStore'])->name('transport-types.store');
    Route::get('/transport-types/{type}/edit', [TransportController::class, 'typeEdit'])->name('transport-types.edit');
    Route::put('/transport-types/{type}', [TransportController::class, 'typeUpdate'])->name('transport-types.update');
    Route::delete('/transport-types/{type}', [TransportController::class, 'typeDestroy'])->name('transport-types.destroy');
});
