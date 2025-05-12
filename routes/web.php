<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ApiDocumentationController;

// Public routes - Redirect to admin login
Route::redirect('/', '/dashboard');

//Customer Authentication routes
// Register (Pendaftaran pengguna)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/dashboard', function () {
    return view('dashboard'); // atau arahkan ke controller jika perlu
})->middleware('auth');

Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/search', [HomeController::class, 'searchForm'])->name('search.form');
Route::get('/search-results', [HomeController::class, 'search'])->name('search.results');

Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');

Route::prefix('reservations')->middleware('auth')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('/{id}/print', [ReservationController::class, 'print'])->name('reservations.print');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin authentication routes
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

// Admin routes - API Management
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');
    
    // Transport Types management (Tipe Penerbangan)
    Route::get('/transport-types', [TransportController::class, 'typeIndex'])->name('transport-types.index');
    Route::get('/transport-types/create', [TransportController::class, 'typeCreate'])->name('transport-types.create');
    Route::post('/transport-types', [TransportController::class, 'typeStore'])->name('transport-types.store');
    Route::get('/transport-types/{type}/edit', [TransportController::class, 'typeEdit'])->name('transport-types.edit');
    Route::put('/transport-types/{type}', [TransportController::class, 'typeUpdate'])->name('transport-types.update');
    Route::delete('/transport-types/{type}', [TransportController::class, 'typeDestroy'])->name('transport-types.destroy');
    
    // Transports management (Maskapai)
    Route::get('/transports', [TransportController::class, 'adminIndex'])->name('transports.index');
    Route::get('/transports/create', [TransportController::class, 'create'])->name('transports.create');
    Route::post('/transports', [TransportController::class, 'store'])->name('transports.store');
    Route::get('/transports/{transport}/edit', [TransportController::class, 'edit'])->name('transports.edit');
    Route::put('/transports/{transport}', [TransportController::class, 'update'])->name('transports.update');
    Route::delete('/transports/{transport}', [TransportController::class, 'destroy'])->name('transports.destroy');
    
    // Routes management (Rute Penerbangan)
    Route::get('/routes', [RouteController::class, 'adminIndex'])->name('routes.index');
    Route::get('/routes/create', [RouteController::class, 'create'])->name('routes.create');
    Route::post('/routes', [RouteController::class, 'store'])->name('routes.store');
    Route::get('/routes/{route}/edit', [RouteController::class, 'edit'])->name('routes.edit');
    Route::put('/routes/{route}', [RouteController::class, 'update'])->name('routes.update');
    Route::delete('/routes/{route}', [RouteController::class, 'destroy'])->name('routes.destroy');
    
    // Schedules management (Jadwal Penerbangan)
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
    
    // API Documentation
    Route::get('/api-docs', [ApiDocumentationController::class, 'index'])->name('api-docs');
    
    // API Logs
    Route::get('/api-logs', [ApiDocumentationController::class, 'logs'])->name('api-logs');
});
