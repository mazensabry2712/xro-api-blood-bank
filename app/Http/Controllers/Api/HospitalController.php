<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Mail\SendOtpMail;

class HospitalController extends Controller
{
    use \App\Traits\Helpers;

    /**
     * Summary of login
     */
    public function login(Request $request)
    {
        $request->validate([
            'license_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $hospital = Hospital::where('license_number', $request->license_number)->first();

        if (! $hospital) {
            return $this->errorResponse(null, 'Invalid credentials');
        }

        if (! Hash::check($request->password, $hospital->password)) {
            return $this->errorResponse(null, 'Invalid credentials');
        }

        $token = $hospital->createToken('HospitalToken')->plainTextToken;

        return $this->successResponse([
            'hospital' => $hospital,
            'token' => $token,
        ], 'Login successful');
    }
    /**
     * Send OTP to hospital
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'license_number' => 'required|string',
        ]);

        $hospital = Hospital::where('license_number', $request->license_number)->first();

        if (! $hospital) {
            return $this->errorResponse(null, 'Hospital not found');
        }

        // توليد OTP
        $otpCode = rand(100000, 999999);

        $hospital->update([
            'email_otp' => $otpCode,
            'email_otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // هنا تقدر تبعته Email أو SMS
        Mail::to($hospital->email)->send(new SendOtpMail($otpCode));

        return $this->successResponse(null, 'OTP sent successfully');
    }

    /**
     * Verify OTP and login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'license_number' => 'required|string',
            'email_otp' => 'required|string',
        ]);

        $hospital = Hospital::where('license_number', $request->license_number)->first();

        if (! $hospital) {
            return $this->errorResponse(null, 'Hospital not found');
        }

        if (
            $hospital->email_otp !== $request->email_otp ||
            !$hospital->email_otp_expires_at ||
            $hospital->email_otp_expires_at->isPast()
        ) {
            return $this->errorResponse(null, 'Invalid or expired OTP');
        }

        // امسح الـ OTP بعد الاستخدام
        $hospital->update([
            'email_otp' => null,
            'email_otp_expires_at' => null,
        ]);

        // اصنع توكن
        $token = $hospital->createToken('HospitalToken')->plainTextToken;

        return $this->successResponse([
            'hospital' => $hospital,
            'token' => $token,
        ], 'Login successful');
    }

    /**
     * Summary of logout
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->successResponse(null, 'Logged out successfully');
        // return self::successResponse(null, 'Logged out successfully');
        // return parent::successResponse(null, 'Logged out successfully');
        // return static::successResponse(null, 'Logged out successfully');
    }




    /**
     * Register a new hospital
     */

    public function register(Request $request)
    {
        // Normalize possible translated/object payloads for 'type' and 'address'
        // Accepts: plain string, JSON string, or array/object like ['en' => '...']
        $normalizeField = function ($value) {
            if (is_array($value)) {
                return $value['en'] ?? array_values($value)[0] ?? null;
            }

            if (is_string($value)) {
                $trim = trim($value);
                if ((str_starts_with($trim, '{') || str_starts_with($trim, '[')) && $decoded = json_decode($trim, true)) {
                    return is_array($decoded) ? ($decoded['en'] ?? array_values($decoded)[0] ?? null) : $decoded;
                }
            }

            return $value;
        };

        if ($request->has('type')) {
            $request->merge(['type' => $normalizeField($request->input('type'))]);
        }

        if ($request->has('address')) {
            $request->merge(['address' => $normalizeField($request->input('address'))]);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:hospitals,license_number',
            'type' => 'in:governmental,private,university,military,charity',
            'address' => 'required|string',
            'region_id' => 'required|exists:regions,id',
            'email' => 'nullable|email|unique:hospitals,email',
            'phone' => 'nullable|string',
            'hotline' => 'nullable|string',
            'website' => 'nullable|url',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $hospital = Hospital::create([
            'name' => $request->name,
            'license_number' => $request->license_number,
            'type' => $request->type ?? 'governmental',
            'address' => $request->address,
            'region_id' => $request->region_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'hotline' => $request->hotline,
            'website' => $request->website,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'password' => Hash::make($request->password),
        ]);

        $token = $hospital->createToken('HospitalToken')->plainTextToken;

        return $this->successResponse([
            'hospital' => $hospital,
            'token' => $token,
        ], 'Hospital registered successfully');
    }
}
