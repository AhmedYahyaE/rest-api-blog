<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;

        // Make sure that the authenticated user is the owner of the post that he/she wants to update

        // Note: All Policy classes won't work with the 'web' guard being set as the default guard in config/auth.php file, because Laravel will retrieve the authenticated user using the default 'web' guard, so we need to use    Auth::shouldUse('api');    just before any request reaches the Policy class. Example: refer to the update() method in PostAPIController and authorize() method in UpdatePostRequest
        // Note: Whenever getting the authenticated user using auth() or Auth::user() within Authentication Routes method (e.g., /register, /login, /me, /refresh, /logout), this won't work properly, because in 'config/auth.php' file, we didn't change the default 'guard' from 'web' to 'api' (the default is 'web'), so we must use either auth('api') or Auth::guard('api') instead, to get the authenticated user. On the contrary, in the Protected Routes (e.g., /posts, /posts/{post}, etc. (i.e., the posts & comments routes)), we don't need to specify the 'api' guard using auth('api') nor Auth::guard('api') to get the authenticated user as Laravel does this automatically, because we applied the 'auth:api' Middleware to these routes, which tells Laravel explicitly to use the 'api' guard (not 'web') (which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of the Tymon JWT-Auth package)
        $postToUpdate = Post::findOrFail($this->route('post')); // $this->route('post') gets the {post} parameter from the route: /api/v1/auth/posts/{post}
        // dd($postToUpdate);
        // Auth::shouldUse('api'); // NO LONGER NEED SINCE WE NOW APPLIED THE 'auth:api' MIDDLEWARE TO THE ROUTE (REFER TO the api.php file)    // Note: Whenever getting the authenticated user using auth() or Auth::user() within Authentication Routes method (e.g., /register, /login, /me, /refresh, /logout), this won't work properly, because in 'config/auth.php' file, we didn't change the default 'guard' from 'web' to 'api' (the default is 'web'), so we must use either auth('api') or Auth::guard('api') instead, to get the authenticated user. On the contrary, in the Protected Routes (e.g., /posts, /posts/{post}, etc. (i.e., the posts & comments routes)), we don't need to specify the 'api' guard using auth('api') nor Auth::guard('api') to get the authenticated user as Laravel does this automatically, because we applied the 'auth:api' Middleware to these routes, which tells Laravel explicitly to use the 'api' guard (not 'web') (which is configured in 'config/auth.php' file to use the 'jwt' 'driver' of the Tymon JWT-Auth package)
        // dd(GateFacade::allows('update', $postToUpdate));

        return Gate::allows('update', $postToUpdate); // PostPolicy    // Boolean

        // Another way to go
        // return auth('api')->user()->id === $postToUpdate->user_id; // Boolean
        // return Auth::guard('api')->user()->id === $postToUpdate->user_id; // Boolean
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ];
    }
}
