<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
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
//api versioning

Route::controller(AuthController::class)->prefix('v1/auth')->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('users', [UserController::class, 'index'])->middleware('admin');
    Route::get('user', [UserController::class, 'getAuthUser']);
    Route::patch('user', [UserController::class, 'updateProfile']);
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'addToCart']);
    Route::apiResource('order', OrderController::class);
    Route::apiResource('storage',StorageController::class);
});
