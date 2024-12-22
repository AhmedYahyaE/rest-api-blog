<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PartialUpdatePatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;

        // Make sure that the authenticated user is the owner of the post that he/she wants to update

        // Note: All Policy classes won't work with the 'web' guard being set as the default guard in config/auth.php file, because Laravel will retrieve the authenticated user using the default 'web' guard, so we need to use    Auth::shouldUse('api');    just before any request reaches the Policy class. Example: refer to the update() method in PostAPIController and authorize() method in UpdatePostRequest
        $postToUpdate = Post::findOrFail($this->route('post')); // $this->route('post') gets the {post} parameter from the route: /api/v1/auth/posts/{post}
        // dd($postToUpdate);
        Auth::shouldUse('api');
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
            'title'   => ['nullable', 'string', 'max:255'], // 'nullable' since it's a PATCH request (partial update)
            'content' => ['nullable', 'string', 'max:255'] // 'nullable' since it's a PATCH request (partial update)
        ];
    }
}
