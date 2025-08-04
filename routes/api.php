<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/license/activate', [LicenseController::class, 'activate']);
Route::post('/license/deactivate', [LicenseController::class, 'deactivate']);
