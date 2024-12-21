<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{APIAuthenticationController};

// Sanctum authentication routes
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('v1')->group(function() {
    // Public Routes
    Route::post('/register', [APIAuthenticationController::class, 'register']);
});
