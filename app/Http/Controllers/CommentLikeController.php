<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\CommentLiked;


class CommentLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Comment $comment, Request $request)
    {

        if ($comment->likedBy($request->user()))
        {
            return response(null, 409);
        }

        $comment->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        $user = auth()->user();

        return back();
    }

    public function destroy(Comment $comment, Request $request)
    {
        $request->user()->likes()->where('comment_id', $comment->id)->delete();

        return back();
    }
}
