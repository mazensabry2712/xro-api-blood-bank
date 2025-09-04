<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HospitalController extends Controller
{
     public function login(Request $request)
    {
        $request->validate([
            'license_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $hospital = Hospital::where('license_number', $request->license_number)->first();

        if (! $hospital || ! Hash::check($request->password, $hospital->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $hospital->createToken('HospitalToken')->plainTextToken;

        return response()->json([
            'hospital' => $hospital,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }






public function register(Request $request)
{
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

    return response()->json([
        'hospital' => $hospital,
        'token' => $token,
    ], 201);
}














}

