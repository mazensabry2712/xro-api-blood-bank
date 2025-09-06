<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {


});
/* User Auth Routes */
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:3,1');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum');

/* OTP User Verification Route */
Route::post('/verify-otp', [AuthenticatedSessionController::class, 'verifyOtp']);

/* Hospital Routes */
Route::post('/hospital/login', [HospitalController::class, 'login']);
Route::post('/hospital/logout', [HospitalController::class, 'logout']);
Route::post('/hospital/register', [HospitalController::class, 'register']);
/* Hospital OTP Verification Route */
Route::post('/hospital/verify-otp', [HospitalController::class, 'verifyOtp']);
Route::post('/hospital/send-otp', [HospitalController::class, 'sendOtp'])->middleware('throttle:3,1');
