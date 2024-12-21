<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasOneThrough};

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;



    // A comment belongs to a post
    public function post(): BelongsTo {
        return $this->belongsTo(Post::class);
    }

    // Inverse of the HasManyThrough relationship in User model
    public function commentOwner(): HasOneThrough {
        return $this->hasOneThrough(User::class, Post::class);
    }
}
