<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\BloodRequestController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::prefix("/v1")->group(function () {
    // Public user auth routes
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');

    // OTP for users
    Route::post('/send-otp', [AuthenticatedSessionController::class, 'sendOtp'])->middleware('throttle:3,1');
    Route::post('/verify-otp', [AuthenticatedSessionController::class, 'verifyOtp']);

    // Hospital routes grouped under /hospital
    Route::prefix('hospital')->group(function () {
        Route::post('/register', [HospitalController::class, 'register']);
        Route::post('/login', [HospitalController::class, 'login'])->middleware('throttle:5,1');
        Route::post('/password/reset', [HospitalController::class, 'resetPassword'])->middleware('throttle:3,1');
        Route::post('/password/update', [HospitalController::class, 'updatePassword']);
        Route::post('/logout', [HospitalController::class, 'logout'])->middleware('auth:hospital');
    });

    // Protected routes (require user auth)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
        // add other protected user endpoints here
    });

    // Blood request routes (public for now, can be protected later)
    Route::post('/blood-requests', [BloodRequestController::class, 'store']);
});
