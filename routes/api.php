<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{APIAuthenticationController, PostAPIController, CommentAPIController};

// Sanctum authentication routes
/*
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
*/



// N.B. Run "php artisan route:list" command to check all the routes (correctly)!
// N.B. "Accept: application/json" Header must be set in ALL HTTP Requests
Route::prefix('v1')->group(function() {


    // Authentication Routes (i.e., Getting authenticated)  (Tymon JWT-Auth package authentication)
    Route::group([
        'middleware' => 'api', // N.B. This line can be omitted!    // Apply Laravel's built-in 'api' Middleware Group defined in 'vendor\laravel\framework\src\Illuminate\Foundation\Configuration\Middleware.php'. Refer to:    Laravel's Default Middleware Groups: https://laravel.com/docs/11.x/middleware#laravels-default-middleware-groups
        'prefix'     => 'auth' // N.B. This line can be omitted. It's just a prefix mentioned in Tymon JWT-Auth package's documentation
    ], function ($router) {
        // Tymon JWTAuth: https://jwt-auth.readthedocs.io/en/develop/quick-start    // https://www.linkedin.com/pulse/jwt-authentication-laravel-11-sanjay-jaiswar-kbelf
        Route::post('/register', [APIAuthenticationController::class, 'register']); // WITH '/auth' prefix    // N.B. register() and login() methods are excluded by the Tymon JWT-Auth 'auth:api' Middleware
        Route::post('/login'   , [APIAuthenticationController::class, 'login']); // WITH '/auth' prefix    // N.B. register() and login() methods are excluded by the Tymon JWT-Auth 'auth:api' Middleware

        // Note: 'Authorization' Header of Bearer Token is required for ALL following routes:
        Route::post('me', [APIAuthenticationController::class, 'me']);
        Route::post('refresh', [APIAuthenticationController::class, 'refresh']);
        Route::post('/logout', [APIAuthenticationController::class, 'logout']);
    });
    // End of Authentication Routes


    // Posts & Comments Routes (Protected Routes which require authentication (Tymon JWT-Auth package)) (i.e., User must be authenticated to access these routes)
    Route::group(['middleware' => 'auth:api'], function() { // Protect routes that require authentication in our application: Apply Laravel's built-in 'auth' Middleware ('auth:api' tells Laravel to use the 'api' guard (not 'web') which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of Tymon JWT-Auth package)
        Route::apiResource('posts'         , PostAPIController::class); // API Resource Controller (excludes 'create' & 'edit' methods automatically)
        Route::apiResource('posts.comments', CommentAPIController::class)->shallow(); // Shallow Nested API Resource Controller (Post has many Comments)

        Route::patch('/posts/{post}', [PostAPIController::class, 'partiallyUpdate']); // Partial Update (PATCH) Route
    });
    // End of Posts & Comments Routes


});



// Similar working route setup (Note: Authentication Routes doesn't have the '/auth' prefix here with this setup)
/*
    Route::prefix('v1')->group(function() {
        // Authentication Routes (i.e., getting authenticated)  (Tymon JWT-Auth package authentication)
        // Tymon JWTAuth: https://jwt-auth.readthedocs.io/en/develop/quick-start    // https://www.linkedin.com/pulse/jwt-authentication-laravel-11-sanjay-jaiswar-kbelf
        Route::post('/register', [APIAuthenticationController::class, 'register']); // WITH '/auth' prefix    // N.B. register() and login() methods are excluded by the Tymon JWT-Auth 'auth:api' Middleware
        Route::post('/login'   , [APIAuthenticationController::class, 'login']); // WITH '/auth' prefix    // N.B. register() and login() methods are excluded by the Tymon JWT-Auth 'auth:api' Middleware

        // Note: 'Authorization' Header of Bearer Token is required for ALL following routes:
        Route::post('me', [APIAuthenticationController::class, 'me']);
        Route::post('refresh', [APIAuthenticationController::class, 'refresh']);
        Route::post('/logout', [APIAuthenticationController::class, 'logout']);
        // End of Authentication Routes


        // Posts & Comments Routes (Protected Routes which require authentication (Tymon JWT-Auth package))
        Route::group(['middleware' => 'auth:api'], function() { // Protect routes that require authentication in our application: Apply Laravel's built-in 'auth' Middleware ('auth:api' tells Laravel to use the 'api' guard (not 'web') which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of Tymon JWT-Auth package)
            Route::apiResource('posts'         , PostAPIController::class); // API Resource Controller (excludes 'create' & 'edit' methods automatically)
            Route::apiResource('posts.comments', CommentAPIController::class)->shallow(); // Shallow Nested API Resource Controller (Post has many Comments)

            Route::patch('/posts/{post}', [PostAPIController::class, 'partiallyUpdate']); // Partial Update (PATCH) Route
        });
        // End of Posts & Comments Routes
    });
*/
