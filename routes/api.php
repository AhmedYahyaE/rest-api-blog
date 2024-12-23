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
// Note: Whenever getting the authenticated user using auth() or Auth::user() within Authentication Routes method (e.g., /register, /login, /me, /refresh, /logout), this won't work properly, because in 'config/auth.php' file, we didn't change the default 'guard' from 'web' to 'api' (the default is 'web'), so we must use either auth('api') or Auth::guard('api') instead, to get the authenticated user. On the contrary, in the Protected Routes (e.g., /posts, /posts/{post}, etc. (i.e., the posts & comments routes)), we don't need to specify the 'api' guard using auth('api') nor Auth::guard('api') to get the authenticated user as Laravel does this automatically, because we applied the 'auth:api' Middleware to these routes, which tells Laravel explicitly to use the 'api' guard (not 'web') (which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of the Tymon JWT-Auth package)
Route::prefix('v1')->group(function() {


    // Public Routes (No 'auth:api' Middleware Group applied)   // Authentication Routes (i.e., Getting authenticated)  (Tymon JWT-Auth package authentication)
    // N.B. This group() can be omitted altogether. It's just mentioned in Tymon JWT-Auth package's documentation
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
    Route::group(['middleware' => 'auth:api'], function() { // Protect routes (by requiring authentication to access them) that require authentication in our application: Apply Laravel's built-in 'auth' Middleware which requires the user to be authenticated to access the route/s (N.B. 'auth:api' tells Laravel to use the 'api' guard (not 'web') which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of the Tymon JWT-Auth package). This way, we don't need to use    Auth::shouldUse('api'); (especially before request reaches Policy classes),nor auth('api'), nor Auth::guard('api')    within the controller methods of these routes.
        Route::apiResource('posts'         , PostAPIController::class); // API Resource Controller (excludes 'create' & 'edit' methods automatically)
        Route::apiResource('posts.comments', CommentAPIController::class)->shallow(); // Shallow Nested API Resource Controller (Post has many Comments)

        Route::patch('/posts/{post}', [PostAPIController::class, 'partiallyUpdate']); // Partial Update (PATCH) Route
    });
    // End of Posts & Comments Routes


});



// Similar working route setup (Note: In this route setup, Authentication Routes doesn't have neither the 'api' Middleware Group nor the '/auth' prefix, i.e., the Route::group() has been ommitted altogether)
/*
    Route::prefix('v1')->group(function() {
        // Public Routes (No 'auth:api' Middleware Group applied)    // Authentication Routes (i.e., getting authenticated)  (Tymon JWT-Auth package authentication)
        // Tymon JWTAuth: https://jwt-auth.readthedocs.io/en/develop/quick-start    // https://www.linkedin.com/pulse/jwt-authentication-laravel-11-sanjay-jaiswar-kbelf
        Route::post('/register', [APIAuthenticationController::class, 'register']); // WITH '/auth' prefix    // N.B. register() and login() methods are excluded by the Tymon JWT-Auth 'auth:api' Middleware
        Route::post('/login'   , [APIAuthenticationController::class, 'login']); // WITH '/auth' prefix    // N.B. register() and login() methods are excluded by the Tymon JWT-Auth 'auth:api' Middleware

        // Note: 'Authorization' Header of Bearer Token is required for ALL following routes:
        Route::post('me', [APIAuthenticationController::class, 'me']);
        Route::post('refresh', [APIAuthenticationController::class, 'refresh']);
        Route::post('/logout', [APIAuthenticationController::class, 'logout']);
        // End of Authentication Routes


        // Posts & Comments Routes (Protected Routes which require authentication (Tymon JWT-Auth package))
        Route::group(['middleware' => 'auth:api'], function() { // Protect routes (by requiring authentication to access them) that require authentication in our application: Apply Laravel's built-in 'auth' Middleware which requires the user to be authenticated to access the route/s (N.B. 'auth:api' tells Laravel to use the 'api' guard (not 'web') which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of the Tymon JWT-Auth package). This way, we don't need to use    Auth::shouldUse('api'); (especially before request reaches Policy classes),nor auth('api'), nor Auth::guard('api')    within the controller methods of these routes.
            Route::apiResource('posts'         , PostAPIController::class); // API Resource Controller (excludes 'create' & 'edit' methods automatically)
            Route::apiResource('posts.comments', CommentAPIController::class)->shallow(); // Shallow Nested API Resource Controller (Post has many Comments)

            Route::patch('/posts/{post}', [PostAPIController::class, 'partiallyUpdate']); // Partial Update (PATCH) Route
        });
        // End of Posts & Comments Routes
    });
*/
