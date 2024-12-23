<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasManyThrough};
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens; // Added HasApiTokens trait which is a Laravel Sanctum's trait

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    // Tymon JWTAuth implementation: https://jwt-auth.readthedocs.io/en/develop/quick-start/
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Use the user's unique ID for the JWT's 'Payload' 'sub' claim (i.e., the `id` column of the user in the `users` table)
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // Add custom JWT Payload's claims to the issued JWT of a user (example: $this->is_active, $this->role, etc.)
        /*
            return [
                'role' => $this->role, // User's role (e.g., admin, editor)
                'is_active' => $this->is_active, // Whether the user's account is active
            ];
        */
        return [];
    }

    // A user has many posts
    public function posts(): HasMany {
        return $this->hasMany(Post::class);
    }

    // A user has many comments through posts
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }
}
