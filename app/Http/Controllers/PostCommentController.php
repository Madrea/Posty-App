<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request)
    {

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $user = auth()->user();


        Comment::create([
            'user_id' => $user['id'],
            'comment' => $request->comment,
            'post_id' => $post->id,
        ]);


        return back();
    }

    public function show(Post $post)
    {
        $comments = Comment::latest()->where('post_id', $post->id)->paginate(10);  

        // latest()->where('id', $post->id)->paginate(10)
        return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function destroy(Comment $comment, Request $request)
    {
        $comment->delete();

        return back();
    }
}
