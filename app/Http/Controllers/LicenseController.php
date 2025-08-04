<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\License;

class LicenseController extends Controller
{
    public function activate(Request $request): JsonResponse
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $license = License::where('key', $request->key)->first();

        if (!$license){
            return response()->json(['error' => 'License key not found'], 404);
        }

        if ($license->state !== 0){
            return response()->json(['error' => 'License key was already activated'], 400);
        }

        $license->state = 1;
        $license->save();
        
        return response()->json($license);
    }

    public function deactivate(Request $request): JsonResponse
    {
        $request->validate([
            'serial_number' => 'required|string|size:8',
        ]);

        $license = License::where('serial_number', $request->serial_number)->first();

        if (!$license){
            return response()->json(['error' => 'License not found'], 404);
        }

        if ($license->state !== 1){
            return response()->json(['error' => 'License is not active or already deactivated'], 400);
        } 
        
        $license->state = 0;
        $license->save();

        return response()->json($license);
    }
}
