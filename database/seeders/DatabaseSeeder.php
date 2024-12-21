<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Post, Comment};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a specific user with 3 posts and 5 comments per each post (Ahmed Yahya)
        User::factory()
            ->has(
                Post::factory(3)->has( // User will have 3 posts
                    Comment::factory(5)->state(function (array $attributes, Post $post) { // Each post will have 5 comments    // Overriding Attributes: https://laravel.com/docs/11.x/eloquent-factories#overriding-attributes
                        return [
                            'user_id' => $post->user_id, // Comment inherits user_id from post's owner
                        ];
                    }),
                    'comments'
                ),
                'posts'
            )->create([
                'name'  => 'Ahmed Yahya',
                'email' => 'ahmed.yahya@example-email.com',
            ])
        ;

        // Create 6 random users, each with 2 posts and 4 comments
        User::factory(6)
            ->has(
                Post::factory(2)->has( // Each user will have 2 posts
                    Comment::factory(4)->state(function (array $attributes, Post $post) { // Each post will have 4 comments    // Overriding Attributes: https://laravel.com/docs/11.x/eloquent-factories#overriding-attributes
                        return [
                            'user_id' => $post->user_id, // Comment inherits user_id from post's owner
                        ];
                    }),
                    'comments'
                ),
                'posts'
            )->create()
        ;


        // Total No. of Users = 1 (Ahmed Yahya) + 6 = 7 users
        // Total No. of Posts = Ahmed Yahya has 3 posts + 6 users * 2 posts = 15 posts
        // Total No. of Comments = Ahmed Yahya has 15 comments + (6 users * 2 posts * 4 comments) = 63 comments
    }
}
