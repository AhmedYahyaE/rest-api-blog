<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return Auth::guard('api')->check(); // Only Authenticated Users can create a Post    // Note: Since we didn't change the default 'guard' from 'web' to 'api' in the 'config/auth.php' file, we must to specify the 'api' guard whenever we retrieve the authenticated user, e.g. auth() doesn't work because it uses the default 'web' guard, so we must use either auth('api') or Auth::guard('api'). Check Accessing Specific Guard Instances: https://laravel.com/docs/11.x/authentication#accessing-specific-guard-instances
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
