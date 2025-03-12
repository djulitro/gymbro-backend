<?php

use App\Constants\UserTypeConst;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PunchController;
use App\Http\Controllers\SubcriptionController;
use App\Http\Controllers\SubcriptionDurationController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::middleware('role:'.UserTypeConst::SUPER_ADMIN.','.UserTypeConst::ADMIN)->group( function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::delete('delete/{id}', [AuthController::class, 'delete']);
    });

    // Subcription duration routes
    Route::middleware('role:'.UserTypeConst::SUPER_ADMIN.','.UserTypeConst::ADMIN)->group(function () {
        Route::get('subcription-durations', [SubcriptionDurationController::class, 'getAll']);
        Route::get('subcription-durations/{id}', [SubcriptionDurationController::class, 'getById']);
        Route::post('subcription-durations', [SubcriptionDurationController::class, 'create']);
        Route::put('subcription-durations/{id}', [SubcriptionDurationController::class, 'update']);
        Route::delete('subcription-durations/{id}', [SubcriptionDurationController::class, 'delete']);
    });

    // Subcription routes
    Route::middleware('role:'.UserTypeConst::SUPER_ADMIN.','.UserTypeConst::ADMIN)->group(function () {
        Route::get('subcriptions', [SubcriptionController::class, 'getAll']);
        Route::get('subcriptions/{id}', [SubcriptionController::class, 'getById']);
        Route::post('subcriptions', [SubcriptionController::class, 'create']);
        Route::put('subcriptions/{id}', [SubcriptionController::class, 'update']);
        Route::delete('subcriptions/{id}', [SubcriptionController::class, 'delete']);
    });

    // Payment routes
    Route::middleware('role:'.UserTypeConst::SUPER_ADMIN.','.UserTypeConst::ADMIN)->group(function () {
        Route::get('payments', [PaymentController::class, 'getAll']);
        Route::get('payments/{id}', [PaymentController::class, 'getById']);
        Route::get('payments/{startDate}/{endDate}', [PaymentController::class, 'getByDates']);
        Route::post('payments', [PaymentController::class, 'create']);
        Route::put('payments/{id}', [PaymentController::class, 'update']);
        Route::delete('payments/{id}', [PaymentController::class, 'delete']);
    });

    // Punch routes
    Route::middleware('role:'.UserTypeConst::SUPER_ADMIN.','.UserTypeConst::ADMIN)->group(function () {
        Route::get('punches', [PunchController::class, 'getAll']);
        Route::get('punches/{id}', [PunchController::class, 'getById']);
        Route::put('punches/{id}', [PunchController::class, 'confirmAdmin']);
    });

    Route::post('punches', [PunchController::class, 'create'])->middleware('role:'.UserTypeConst::CLIENT.','.UserTypeConst::SUPER_ADMIN.','.UserTypeConst::ADMIN);
});
