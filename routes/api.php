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
    Route::post('/login'   , [APIAuthenticationController::class, 'register']);


    // Protected Routes (require JWT authentication)    // Tymon JWTAuth: https://jwt-auth.readthedocs.io/en/develop/quick-start    // https://www.linkedin.com/pulse/jwt-authentication-laravel-11-sanjay-jaiswar-kbelf
    Route::group([
        'middleware' => 'api',
        'prefix'     => 'auth'
    ], function ($router) {
        Route::post('/logout', [APIAuthenticationController::class, 'logout']);
    });

});
