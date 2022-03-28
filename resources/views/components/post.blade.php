@props(['post' => $post])


    <div class="mb-4">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('users.posts', $post->user) }}" class="post-author">{{ $post->user->name }}</a> 
                <span class="post-date pl-2">{{ $post->created_at->diffForHumans() }}</span>
                
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
                    <a style="float:right ;text-align:right" href="{{ route('comments.show', $post) }}" class="col">{{ $post->comments->count() }} {{ Str::plural('comment', $post->likes->count()) }}</a>

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
                    <div class="col">
                            <button type="button" style="width:100%" id="{{ $post->id }}" onclick="myFunction('{{ $post->id }}')" class="like-unlike-button btn btn-light btn-outline-none comment-button"><i class="fa-solid fa-message pr-1"></i>Comment</button>
                    </div>
                </div>
                
                <div class="row pt-2 pl-4 pr-1" style="width:100%">
                    
                    <div class="comment-div pt-2 pl-3 " style="width:100%">
                        <div class="comment-top">
                            <p class="comment-name">{{ $post->comments()->get()->last()->user()->get()->last()->name }}</p>
                            <p class="pl-3 comment-date">  {{ $post->comments()->get()->last()->created_at->diffForHumans() }}</p>
                        </div>
                        
                        <p class="pb-2 pt-1">{{ $post->comments()->get()->last()->comment }}</p>
                    </div>

                </div>

                <div class="comments-wrapper pt-3" id="{{ 'comment-div' . $post->id }}">                    
                    <div class="make-comment mb-3">
                            <form action="{{ route('comments.store', $post) }}" method="post" style="width:100%">
                                @csrf
                                <textarea name="comment" id="comment" cols="30" rows="4" class="comment-body" placeholder="Write a comment"></textarea>                                
                                <button type="submit" class="post-comment"><i class="fa-solid fa-paper-plane"></i></button>
                            </form>

                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <script>
        function myFunction(id) {
            // console.log("comment-div" + id);
            var x = document.getElementById("comment-div" + id);
            if(x.style.display === '')
            {
                x.style.display = "none";
            }
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

    </script>






    