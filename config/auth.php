<?php
// Note: Since we didn't change the default 'guard' from 'web' to 'api' in the 'config/auth.php' file, we must to specify the 'api' guard whenever we retrieve the authenticated user, e.g. auth() doesn't work because it uses the default 'web' guard, so we must use either auth('api') or Auth::guard('api'). Check Accessing Specific Guard Instances: https://laravel.com/docs/11.x/authentication#accessing-specific-guard-instances
// Note: All Policy classes won't work with the 'web' guard being set as the default guard in config/auth.php file, because Laravel will retrieve the authenticated user using the default 'web' guard, so we need to use    Auth::shouldUse('api');    just before any request reaches the Policy class. Example: refer to the update() method in PostAPIController and authorize() method in UpdatePostRequest
// Note: Whenever getting the authenticated user using auth() or Auth::user() within Authentication Routes method (e.g., /register, /login, /me, /refresh, /logout), this won't work properly, because in 'config/auth.php' file, we didn't change the default 'guard' from 'web' to 'api' (the default is 'web'), so we must use either auth('api') or Auth::guard('api') instead, to get the authenticated user. On the contrary, in the Protected Routes (e.g., /posts, /posts/{post}, etc. (i.e., the posts & comments routes)), we don't need to specify the 'api' guard using auth('api') nor Auth::guard('api') to get the authenticated user as Laravel does this automatically, because we applied the 'auth:api' Middleware to these routes, which tells Laravel explicitly to use the 'api' guard (not 'web') (which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of the Tymon JWT-Auth package)

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'), // Note: Since we didn't change the default 'guard' from 'web' to 'api' in the 'config/auth.php' file, we must to specify the 'api' guard whenever we retrieve the authenticated user, e.g. auth() doesn't work because it uses the default 'web' guard, so we must use either auth('api') or Auth::guard('api'). Check Accessing Specific Guard Instances: https://laravel.com/docs/11.x/authentication#accessing-specific-guard-instances
        // Also, All Policy classes won't work with the 'web' guard being set as the default guard in config/auth.php file, because Laravel will retrieve the authenticated user using the default 'web' guard, so we need to use    Auth::shouldUse('api');    just before any request reaches the Policy class. Example: refer to the update() method in PostAPIController and authorize() method in UpdatePostRequest
        // Note: Whenever getting the authenticated user using auth() or Auth::user() within Authentication Routes method (e.g., /register, /login, /me, /refresh, /logout), this won't work properly, because in 'config/auth.php' file, we didn't change the default 'guard' from 'web' to 'api' (the default is 'web'), so we must use either auth('api') or Auth::guard('api') instead, to get the authenticated user. On the contrary, in the Protected Routes (e.g., /posts, /posts/{post}, etc. (i.e., the posts & comments routes)), we don't need to specify the 'api' guard using auth('api') nor Auth::guard('api') to get the authenticated user as Laravel does this automatically, because we applied the 'auth:api' Middleware to these routes, which tells Laravel explicitly to use the 'api' guard (not 'web') (which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of the Tymon JWT-Auth package)
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | which utilizes session storage plus the Eloquent user provider.
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Tymon JWTAuth: https://jwt-auth.readthedocs.io/en/develop/quick-start    // https://www.linkedin.com/pulse/jwt-authentication-laravel-11-sanjay-jaiswar-kbelf
        'api' => [
            'driver'   => 'jwt',
            'provider' => 'users',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | If you have multiple user tables or models you may configure multiple
    | providers to represent the model / table. These providers may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality, including the table utilized for token storage
    | and the user provider that is invoked to actually retrieve users.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | window expires and users are asked to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
