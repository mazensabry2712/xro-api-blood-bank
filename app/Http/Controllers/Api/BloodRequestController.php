<?php

namespace App\Http\Controllers\Api;

use App\Models\BloodRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BloodRequestController extends Controller
{
    use \App\Traits\Helpers;
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'blood_type_id' => 'required|exists:blood_types,id',
            'number_bags' => 'required|integer|min:1',
            'hospital_id' => 'required|exists:hospitals,id',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'status' => 'nullable|in:urgent,medium,low',
            'type_status' => 'in:inactive,active'
        ]);
        $bloodRequest = BloodRequest::create($validatedData);
        return $this->successResponse([
            'blood_request' => $bloodRequest,
        ], 'Blood request created successfully');
    }
}
