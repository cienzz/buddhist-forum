<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TempleController;
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

//  sesudah login
Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('users')->group(function() {
        Route::get('me', [UserController::class, 'me']);
        Route::put('me', [UserController::class, 'update']);
        Route::patch('me/password', [UserController::class, 'patchPassword']);
        Route::patch('me/email', [UserController::class, 'patchEmail']);
        Route::patch('me/phone_number', [UserController::class, 'patchPhoneNumber']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::post('temples', [TempleController::class, 'store'])->middleware('ability:create-temple');
    Route::put('temples/{temple}', [TempleController::class, 'update'])->middleware('ability:update-temple');
    Route::post('temples/{temple}/follow', [TempleController::class, 'follow']);
    Route::post('temples/{temple}/unfollow', [TempleController::class, 'unfollow']);
});

//  sebelum login
Route::middleware('guest')->group(function() {
    Route::prefix('users')->group(function() {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('token', [AuthController::class, 'token'])->middleware('throttle:5,5');
    });
});

Route::apiResource('temples', TempleController::class)->only(['index', 'show']);