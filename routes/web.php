<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route for passengers
Route::get('/passengers', [PassengerController::class, 'index']);

// Route for flights
Route::get('/flights', [FlightController::class, 'index']); // This will list all flights

// get passenger by flight id
Route::get('/flights/{flight}/passengers', [FlightController::class, 'passengers']);

// CRUD for users
Route::get('/users', [UserController::class, 'index']);     // Get all users
Route::get('/users/{id}', [UserController::class, 'show']);  // Get a single user

// CRUD for users for Admins
Route::middleware('auth:sanctum', 'admin')->group(function () {
    Route::post('/users', [UserController::class, 'store']); // create user
    Route::put('/users/{id}', [UserController::class, 'update']); // Update user
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete user
});

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);

// Authentication routes (only for authenticated users)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::get('/', function () {
    return view('welcome');
});