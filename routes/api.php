<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TransportTypeAPIController;
use App\Http\Controllers\API\TransportAPIController;
use App\Http\Controllers\API\RouteAPIController;
use App\Http\Controllers\API\ScheduleAPIController;
use App\Http\Controllers\API\AuthAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API Routes
// Auth Routes
Route::post('auth/login', [AuthAPIController::class, 'login']);
Route::post('auth/register', [AuthAPIController::class, 'register']);

// Transport Types API Routes (Tipe Penerbangan) - Public Endpoints
Route::get('transport-types', [TransportTypeAPIController::class, 'index']);
Route::get('transport-types/{id}', [TransportTypeAPIController::class, 'show']);

// Transports API Routes (Maskapai) - Public Endpoints
Route::get('transports', [TransportAPIController::class, 'index']);
Route::get('transports/{id}', [TransportAPIController::class, 'show']);

// Routes API Routes (Rute Penerbangan) - Public Endpoints
Route::get('routes', [RouteAPIController::class, 'index']);
Route::get('routes/{id}', [RouteAPIController::class, 'show']);
Route::post('routes/search', [RouteAPIController::class, 'search']);

// Schedules API Routes (Jadwal Penerbangan) - Public Endpoints
Route::get('schedules', [ScheduleAPIController::class, 'index']);
Route::get('schedules/{id}', [ScheduleAPIController::class, 'show']);
Route::post('schedules/search/date', [ScheduleAPIController::class, 'searchByDate']);
Route::post('schedules/search/route', [ScheduleAPIController::class, 'searchByRoute']);
Route::post('schedules/search/airline', [ScheduleAPIController::class, 'searchByAirline']);

// Protected API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/user', [AuthAPIController::class, 'user']);
    Route::post('auth/logout', [AuthAPIController::class, 'logout']);
    
    // Transport Types API Routes (Tipe Penerbangan) - Protected Endpoints
    Route::post('transport-types', [TransportTypeAPIController::class, 'store']);
    Route::put('transport-types/{id}', [TransportTypeAPIController::class, 'update']);
    Route::delete('transport-types/{id}', [TransportTypeAPIController::class, 'destroy']);

    // Transports API Routes (Maskapai) - Protected Endpoints
    Route::post('transports', [TransportAPIController::class, 'store']);
    Route::put('transports/{id}', [TransportAPIController::class, 'update']);
    Route::delete('transports/{id}', [TransportAPIController::class, 'destroy']);

    // Routes API Routes (Rute Penerbangan) - Protected Endpoints
    Route::post('routes', [RouteAPIController::class, 'store']);
    Route::put('routes/{id}', [RouteAPIController::class, 'update']);
    Route::delete('routes/{id}', [RouteAPIController::class, 'destroy']);

});


Route::get('/user/{id}', [AuthController::class, 'show']);
