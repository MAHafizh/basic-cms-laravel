<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::post('/register', 'AuthController@register');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// 5|Uq0X7dcWXuuxRIZS79uVew3BoVOmKBRPl8pjiOFxe080154b