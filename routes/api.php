<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::get('stations', [StationController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('user', [AuthController::class, 'user']);
});
