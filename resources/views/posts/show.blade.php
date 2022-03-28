@extends('layouts.app')

@section('content')
    <div class="section-div-1">
        <div class="section-div-2">
            <div class="mb-4">
                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('posts') }}">
                            <a href="{{ route('users.posts', $post->user) }}" class="post-author">{{ $post->user->name }}</a> 
                            <span class="post-date pl-2">{{ $post->created_at->diffForHumans() }}</span>
                                <button type="submit" style="float:right" class="button-edit pl-3">Go Back</button>
                            @can('delete', $post)
                            <div class="dropdown" style="float:right">
                                <button class="dropdown-toggle" type="button" data-toggle="dropdown" >
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <div class="dropdown-menu">
                                        @can('delete', $post)
                                            <form action="{{ route('posts.destroy', $post) }}" method="post" >
                                                @csrf
                                                @method('DELETE')
                                                <button style="margin: auto" type="submit" class="like-unlike-button pl-4"><i class="fa-solid fa-trash pr-1"></i>Delete</button>
                                            </form>
                                        @endcan

                                        @can('update', $post)
                                            <form action="{{ route('posts.edit', $post) }}" method="get" class="mr-1">
                                                @csrf
                                                <button type="submit" class="like-unlike-button pl-4"><i class="fa-solid fa-pen-to-square pr-1"></i>Edit</button>
                                            </form>
                                        @endcan
                                </div>
                            </div>
                            @endcan
                        </form>    
                    </div>
                    <div class="card-body">
                        <p class="post-body">{{ $post->body }}</p>

                        <div class="image-div">

                            @if ($post->image_path)
                            <img src="{{ asset('images/' . $post->image_path) }}" alt=" " class="image">
                            @endif

                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <span class=" like col" style="float:left"><i class="fa-solid fa-thumbs-up pr-2" style="color:rgb(59 130 246)"></i>{{ $post->likes->count() }}</span>
                            <span style="float:right ;text-align:right" class="col">{{ $post->comments->count() }} {{ Str::plural('comment', $post->likes->count()) }}</span>
                        </div>
                        <div class="row" style="margin-top: 10px; border-top: 0.2px solid black;border-bottom: 0.2px solid black; height: 40px">
                            <div class="col">
                                @auth
                                    @if (!$post->likedBy(auth()->user()))

                                        <form action="{{ route('posts.likes', $post) }}" method="post">
                                            @csrf
                                            <button type="submit" style="width:100%" class="like-unlike-button btn btn-light"><i class="fa-solid fa-thumbs-up pr-1"></i>Like</button>
                                        </form>
                                    @else
                                        <form action="{{ route('posts.likes', $post) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="width:100%" class="like-unlike-button btn btn-light"><i class="fa-solid fa-thumbs-down pr-1"></i>Unlike</button>
                                        </form>

                                    @endif  
                                    <!-- {{ route('comments.show', $post) }} -->
                                
                                @endauth
                            </div>               
                        </div>   
                        
                        @if($post->comments->count())
                            <div class="pt-5">
                                @foreach($comments as $comment)
                                    <div class="main-div-comment">
                                        <div class="comment-div">
                                            <div class="comment-top">
                                                <p class="comment-name">{{ $comment->user->name }}</p>
                                                <p class="pl-2 comment-date">  {{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                            
                                            <p class="pb-2 pt-1">{{ $comment->comment }}</p>
                                        </div>

                                        <div class="comment-buttons">
                                            @auth
                                                @if (!$comment->likedBy(auth()->user()))
                                                
                                                    <form action="{{ route('comments.likes', $comment) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="like-unlike-button pl-3 "><i class="fa-solid fa-thumbs-up pr-1"></i>Like</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('comments.likes', $comment) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="like-unlike-button pl-3"><i class="fa-solid fa-thumbs-down pr-1"></i>Unlike</button>
                                                    </form>

                                                @endif

                                                <span class=" like col" style="float:left"></i>{{ $comment->likes->count() }}</span>

                                                @if($comment->ownedBy(auth()->user()))
                                                    <form action="{{ route('comments.destroy', $comment) }}" method="post" >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button  type="submit" class="like-unlike-button  pt-0"><i class="fa-solid fa-trash pr-1"></i>Delete</button>
                                                    </form>
                                                @else
                                                    @can('delete', $post)
                                                        <form action="{{ route('comments.destroy', $comment) }}" method="post" >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button  type="submit" class="like-unlike-button  pt-0"><i class="fa-solid fa-trash pr-1"></i>Delete</button>
                                                        </form>
                                                    @endcan

                                                @endif

                                            @endauth
                                        </div>
                                    </div>

                                @endforeach

                                {{ $comments->links('pagination::bootstrap-5') }}

                            </div>

                        @else
                            <p>There are no comments to this post</p>    
                        @endif    
                    </div>
                </div>    
            </div>
        </div>
    </div>
@endsection
