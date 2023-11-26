<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoleController;
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

//  after login
Route::middleware('auth:sanctum')->group(function() {
    Route::post('events/{event}/participate', [EventController::class, 'participate']);
    Route::apiResource('events', EventController::class);
    
    Route::get('roles/menus', [RoleController::class, 'menus']);
    Route::apiResource('roles', RoleController::class);

    Route::post('temples/{temple}/follow', [TempleController::class, 'follow']);
    Route::post('temples/{temple}/unfollow', [TempleController::class, 'unfollow']);
    Route::patch('temples/{temple}/members/{member}/roles', [TempleController::class, 'patchMemberRoles']);
    Route::apiResource('temples', TempleController::class);

    Route::prefix('users')->group(function() {
        Route::post('logout', [AuthController::class, 'logout']);
        
        Route::get('me', [UserController::class, 'me']);
        Route::put('me', [UserController::class, 'update']);
        Route::patch('me/password', [UserController::class, 'patchPassword']);
        Route::patch('me/email', [UserController::class, 'patchEmail']);
        Route::patch('me/phone_number', [UserController::class, 'patchPhoneNumber']);
        Route::patch('{user}/roles', [UserController::class, 'patchRoles']);
    });
    Route::apiResource('users', UserController::class)->only('index', 'show', 'update');
});

//  before login
Route::middleware('guest')->group(function() {
    Route::apiResource('guest/events', EventController::class)->only('index', 'show');
    Route::apiResource('guest/temples', TempleController::class)->only('index', 'show');

    Route::prefix('users')->group(function() {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('token', [AuthController::class, 'token'])->middleware('throttle:5,5');
    });
});


