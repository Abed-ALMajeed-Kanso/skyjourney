<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\SessionController;

Route::post('/login', [SessionController::class, 'login'])->name('login'); 

Route::middleware('auth:sanctum')->group(function () {
    //routes ghalat
    Route::get('/passengers', [PassengerController::class, 'index'])->name('passengers.index'); 
    Route::get('/passengers/{passenger}', [PassengerController::class, 'show'])->name('passengers.show'); 
    Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
    Route::get('/flights/{flight}', [FlightController::class, 'show'])->name('flights.show');
    Route::get('/flights_passengers/{flight}', [FlightController::class, 'passengers'])->name('flights.passengers');

    Route::middleware('role:admin')->group(function () {

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/Get_user/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('/Create_user', [UserController::class, 'store'])->name('users.store');
        Route::put('/Update_user/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/Delete_user/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/import_users', [UserController::class, 'import'])->name('users.import');

        Route::post('/Create_passenger', [PassengerController::class, 'store'])->name('passengers.store');
        Route::put('/Update_passenger/{passenger}', [PassengerController::class, 'update'])->name('passengers.update');
        Route::delete('/Delete_passenger/{passenger}', [PassengerController::class, 'destroy'])->name('passengers.destroy');

        Route::post('/Create_flight', [FlightController::class, 'store'])->name('flights.store');
        Route::put('/Update_flight/{flight}', [FlightController::class, 'update'])->name('flights.update');
        Route::delete('/Delete_flight/{flight}', [FlightController::class, 'destroy'])->name('flights.destroy');

    });
    
    Route::post('/logout', [SessionController::class, 'logout'])->name('logout'); 
});

Route::get('/', function () {
    return view('welcome');
})->name('home');



