<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\SessionController;

Route::post('/login', [SessionController::class, 'login'])->middleware('throttle:10,1'); 
Route::post('/register', [SessionController::class, 'register'])->middleware('throttle:10,1');

Route::middleware(['auth:sanctum', \App\Http\Middleware\PermissionPolicy::class])->group(function () {
    
    Route::apiResource('passengers', PassengerController::class)->only(['index', 'show'])->middleware('throttle:10,1');
    Route::get('flights', [FlightController::class, 'index'])->middleware(['throttle:10,1', 'cache.response']); 
    Route::get('flights/{flight}', [FlightController::class, 'show'])->middleware('throttle:10,1');

    Route::middleware(['role:admin', 'throttle:10,1'])->group(function () {

        Route::apiResource('users', UserController::class);
        Route::apiResource('passengers', PassengerController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('flights', FlightController::class)->only(['store', 'update', 'destroy']);

        Route::get('/export_users', [UserController::class, 'export']);
        Route::get('/import_users', [UserController::class, 'import']);

    });
    
    Route::post('/logout', [SessionController::class, 'logout']); 
});

Route::get('/', function () {
    return view('welcome');
})->name('home');



