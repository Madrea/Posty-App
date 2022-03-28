<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }

    public function index()
    {
      // $posts = Post::get();  returneaza o colectie de tip post
       $posts = Post::latest()->with(['user', 'likes'])->paginate(20);   //returneaza x postari 


       return view('posts.index', [
           'posts' => $posts,
        ]); 
    }

    public function show(Post $post)
    {
        $comments = Comment::latest()->where('post_id', $post->id)->paginate(10);  

        return view('posts.show', [
            'post' => $post, 
            'comments' => $comments,
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'body' => 'required',
            'image' => 'mimes:jpg,png,jpeg|max:5048'

        ]);


        if($request->image) 
        {
            $newImageName = time() . '-' . $request->file('image')->getClientOriginalName();

            $request->image->move(public_path('images'), $newImageName);

            $request->user()->posts()->create([
                'body' => $request->body,
                'image_path' => $newImageName,
            ]);
        }
        else
        {

            $request->user()->posts()->create([
                'body' => $request->body,
            ]);
                //will automatically fill in the user id
        }
            
        return back();

    }

    public function destroy(Post $post) 
    {
        $this->authorize('delete', $post);

        $imagePath = 'images/' . $post->image_path;

        File::delete(public_path($imagePath));
        
        $post->delete();

        return back();
    }

    public function editPost(Post $post) 
    {
        return view('posts.update', [
            'post' => $post
        ]);
    }

    public function updatePost(Post $post, Request $request)
    {
        $this->authorize('update', $post);

        Post::find($post->id)->update([
            'body'=>$request->input('postBody'),
        ]);

        return redirect('/posts');

    }

    

}
