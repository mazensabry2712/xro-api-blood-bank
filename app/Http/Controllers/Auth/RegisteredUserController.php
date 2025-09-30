<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;
use App\Traits\Helpers;

class RegisteredUserController extends Controller
{
    use Helpers;
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $otpCode = rand(100000, 999999);

        $user->update([
            'email_otp' => $otpCode,
            'email_otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // ارسال الاوتي بي
        Mail::to($user->email)->send(new SendOtpMail($otpCode));

        return $this->successResponse(null, 'Registered successfully, please check your email for the OTP code.');
    }
}
