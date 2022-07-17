<?php

namespace App\Models;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        // 'user_id',
    ];

    public function likedBy(User $user)
    {
        // Contains is a laravel's collection method
        return $this->likes->contains('user_id', $user->id);
    }

    // Commit due to create PostPolicy
    // public function ownedBy(User $user)
    // {
    //     return $user->id === $this->user_id;
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
