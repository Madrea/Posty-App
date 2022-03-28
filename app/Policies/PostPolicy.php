<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function deleteComment(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }


    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
