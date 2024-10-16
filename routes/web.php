<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\SessionController; 

// Login for users
Route::post('/login', [SessionController::class, 'login'])->name('login'); 

// Grouping all routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    // User logout
    Route::post('/logout', [SessionController::class, 'logout'])->name('logout'); // Logout for users

    // Routes requiring authentication
    Route::get('/passengers', [PassengerController::class, 'index'])->name('passengers.index'); // List passengers
    Route::get('/passengers/{id}', [PassengerController::class, 'show'])->name('passengers.show'); // View a single passenger
    Route::get('/flights', [FlightController::class, 'index'])->name('flights.index'); // List flights
    Route::get('/flights/{id}', [FlightController::class, 'show'])->name('flights.show'); // View a single flight
    Route::get('/flights_passengers/{id}', [FlightController::class, 'passengers'])->name('flights.passengers'); // Get passengers by flight ID

    // Admin routes (Full access to all routes)
    Route::middleware('admin')->group(function () {

        // User management routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index'); // Get all users
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show'); // Get a single user
        Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Create user
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update'); // Update user
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Delete user

        // Import users from an Excel file route
        Route::get('/import_users', [UserController::class, 'import'])->name('users.import');
    });

    // Manager routes (Limited to passengers and flights, but no access to users)
    Route::middleware('manager')->group(function () {
        // Passenger management routes
        Route::post('/passengers', [PassengerController::class, 'store'])->name('passengers.store'); // Create passenger
        Route::put('/passengers/{id}', [PassengerController::class, 'update'])->name('passengers.update'); // Update passenger
        Route::delete('/passengers/{id}', [PassengerController::class, 'destroy'])->name('passengers.destroy'); // Delete passenger

        // Flight management routes
        Route::post('/flights', [FlightController::class, 'store'])->name('flights.store'); // Create flight
        Route::put('/flights/{id}', [FlightController::class, 'update'])->name('flights.update'); // Update flight
        Route::delete('/flights/{id}', [FlightController::class, 'destroy'])->name('flights.destroy'); // Delete flight
    });
});

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');
