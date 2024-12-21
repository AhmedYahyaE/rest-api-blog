<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{APIAuthenticationController};

// Sanctum authentication routes
/*
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
*/



// N.B. Run "php artisan route:list" command to check all the routes (correctly)!
// N.B. "Accept: application/json" Header must be set in ALL HTTP Requests
Route::prefix('v1')->group(function() {
    // Public Routes
    // Route::post('/register', [APIAuthenticationController::class, 'register']); // WITHOUT '/auth' prefix
    // Route::post('/login'   , [APIAuthenticationController::class, 'login']); // WITHOUT '/auth' prefix


    // Protected Routes (require JWT authentication)    // Tymon JWTAuth: https://jwt-auth.readthedocs.io/en/develop/quick-start    // https://www.linkedin.com/pulse/jwt-authentication-laravel-11-sanjay-jaiswar-kbelf
    Route::group([
        'middleware' => 'api', // 'auth:api', i.e., Tymon JWT-Auth Guard (defined in 'config/auth.php' file)
        'prefix'     => 'auth'
    ], function ($router) {
        Route::post('/register', [APIAuthenticationController::class, 'register']); // WITH '/auth' prefix    // N.B. register() and login() methods are excluded by the Tymon JWT-Auth 'auth:api' Middleware
        Route::post('/login'   , [APIAuthenticationController::class, 'login']); // WITH '/auth' prefix    // N.B. register() and login() methods are excluded by the Tymon JWT-Auth 'auth:api' Middleware

        // 'Authorization' Header of Bearer Token is required for the following routes
        Route::post('me', [APIAuthenticationController::class, 'me']);
        Route::post('refresh', [APIAuthenticationController::class, 'refresh']);
        Route::post('/logout', [APIAuthenticationController::class, 'logout']);
    });

});
