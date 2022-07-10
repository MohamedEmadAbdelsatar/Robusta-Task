<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('trips', 'App\Http\Controllers\TripsController')->except(['update', 'destroy']);

Route::post('book', [App\Http\Controllers\ReservationsController::class, 'book'])->name('reservation.book');
Route::get('availability', [App\Http\Controllers\ReservationsController::class, 'getAvailableSeats'])->name('reservation.getAvailable');
