<?php

use App\Constants\UserTypeConst;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::middleware('role:'.UserTypeConst::SUPER_ADMIN.','.UserTypeConst::ADMIN)->group( function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::delete('delete', [AuthController::class, 'delete']);
    });
});
