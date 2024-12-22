<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'user_id', 'content'
    ];



    // A post belongs to a user
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // A post has many comments
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
}
