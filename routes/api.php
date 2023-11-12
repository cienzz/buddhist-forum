<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//  sebelum login
Route::middleware('guest')->group(function() {
    Route::prefix('users')->group(function() {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('token', [AuthController::class, 'token'])->middleware('throttle:5,5');
    });
});

//  sesudah login
Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('users')->group(function() {
        Route::get('me', [UserController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
    
});
