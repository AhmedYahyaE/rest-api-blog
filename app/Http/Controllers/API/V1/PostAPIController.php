<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PartialUpdatePatchRequest;
use App\Http\Requests\API\StorePostRequest;
use App\Http\Requests\API\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        /*
            \DB::enableQueryLog();
            $allPosts = Post::with('user')->latest()->paginate($request->per_page ?? 3);
            dd(\DB::getQueryLog());
        */

        $allPosts = Post::with('user')->latest('id')->paginate($request->per_page ?? 3); // Eager Loading (N+1 Problem) // If the user sends a 'per_page' query parameter, then it will be used; otherwise, 3 records will be shown per page


        return new PostCollection($allPosts); // Return the posts as a Resource Collection
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // dd(
        //     Auth::guard('api')->id(),
        //     Auth::guard()->id()
        // );

        $newPost = Post::create([
            'title'   => $request->title,
            'content' => $request->content,
            'user_id' => Auth::guard('api')->id()// Note: Since we didn't change the default 'guard' from 'web' to 'api' in the 'config/auth.php' file, we must to specify the 'api' guard whenever we retrieve the authenticated user, e.g. auth() doesn't work because it uses the default 'web' guard, so we must use either auth('api') or Auth::guard('api'). Check Accessing Specific Guard Instances: https://laravel.com/docs/11.x/authentication#accessing-specific-guard-instances
        ]);

        return response()->json($newPost, 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        // Note: All Policy classes won't work with the 'web' guard being set as the default guard in config/auth.php file, because Laravel will retrieve the authenticated user using the default 'web' guard, so we need to use    Auth::shouldUse('api');    just before any request reaches the Policy class. Example: refer to the update() method in PostAPIController and authorize() method in UpdatePostRequest
        /*
            Auth::shouldUse('api');
            $postToUpdate = Post::findOrFail($id);
            Gate::authorize('update', $postToUpdate);
        */
        // Authorization has been done in the UpdatePostRequest class

        $postToUpdate = Post::findOrFail($id);
        $postToUpdate->update($request->validated()); // Update the post with the validated data
        // dd($postToUpdate->update($request->validated()));


        return new PostResource($postToUpdate); // Return the post after has been updated    // Return the post as a single resource
    }

    // PATCH (partial update)
    public function partiallyUpdate(Request $request, string $id)
    {
        // Note: All Policy classes won't work with the 'web' guard being set as the default guard in config/auth.php file, because Laravel will retrieve the authenticated user using the default 'web' guard, so we need to use    Auth::shouldUse('api');    just before any request reaches the Policy class. Example: refer to the update() method in PostAPIController and authorize() method in UpdatePostRequest
        /*
            Auth::shouldUse('api');
            $postToUpdate = Post::findOrFail($id);
            Gate::authorize('update', $postToUpdate);
        */
        // Authorization has been done in the UpdatePostRequest class

        // dd($request->only(['title', 'content']));

        $postToUpdate = Post::findOrFail($id);
        $postToUpdate->update($request->only(['title', 'content'])); // Update the post with a portion of the validated data (if one of the two isn't sent in the request, only one will stay in the resulting array of the only() method)    // Retrieving a Portion of the Input Data: https://laravel.com/docs/11.x/requests#retrieving-a-portion-of-the-input-data
        // dd($postToUpdate->update($request->validated()));


        return new PostResource($postToUpdate); // Return the post after has been updated    // Return the post as a single resource
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
