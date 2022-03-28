<?php

namespace App\Models;

use App\Models\User;
use App\Models\Post;
use App\Models\Like;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'user_id',
        'post_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function ownedBy(User $user)
    {
        return $user->id === $this->user_id;
    }

    public function isIn(Post $post)
    {
        return $post->id === $this->post_id;
    }

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
