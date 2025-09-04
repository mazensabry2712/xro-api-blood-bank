<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request): Response
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->string('password')),
    ]);

    // 🔹 توليد كود OTP
    $otp = rand(100000, 999999);
    $user->update([
        'email_otp' => $otp,
        'email_otp_expires_at' => now()->addMinutes(10),
    ]);

    // 🔹 إرسال OTP على الإيميل
    \Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

    // 🔹 لحد هنا المستخدم مش Verified
    // event(new Registered($user));  👉 مش هنحتاجه دلوقتي

    return response()->json([
        'message' => 'Registered successfully, please check your email for the OTP code.',
    ]);
}

}
