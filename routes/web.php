<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ImportController;

// Public routes for logging in
Route::post('/login', [AuthController::class, 'login']); // Login for users
Route::post('/login_passenger', [AuthController::class, 'login_passenger'])->name('login_passenger');


// Routes for normal users (protected by auth:sanctum for users)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // Logout for users

    Route::get('/users', [UserController::class, 'index']);     // Get all users
    Route::get('/users/{id}', [UserController::class, 'show']);  // Get a single user

    Route::middleware('admin')->group(function () {
        Route::post('/users', [UserController::class, 'store']); // Create user
        Route::put('/users/{id}', [UserController::class, 'update']); // Update user
        Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete user
    });
});

// Routes for passengers (protected by auth:sanctum:passengers for passengers)
Route::middleware('auth:passengers')->group(function () {
    Route::post('/logout_passenger', [AuthController::class, 'logout_passenger']); // Logout for passengers

    // Protect the upload view route
    Route::get('/upload', function () {
        return view('upload'); 
    })->name('image.upload.form');

    // Protect the image upload route
    Route::post('/upload_image', [ImageUploadController::class, 'upload'])->name('image.upload');
});


// Public routes for passengers and flights
Route::get('/passengers', [PassengerController::class, 'index']); // Public route for passengers
Route::get('/flights', [FlightController::class, 'index']); // Public route for flights
Route::get('/flights/{flight}/passengers', [FlightController::class, 'passengers']); // Get passengers by flight ID

// Import users from an Excel file route
Route::get('/import_users', [ImportController::class, 'import']);

// Home route
Route::get('/', function () {
    return view('welcome');
});
