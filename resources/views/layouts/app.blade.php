<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Posty</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/3a953beb95.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <body class="body">
        <nav class="up">
            <ul class="up-part">
                <li>
                    <a href="/" class="p-3"><i class="fa-solid fa-house pr-1"></i></i>Home</a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="p-3"><i class="fa-solid fa-gauge pr-1"></i>Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('posts') }}" class="p-3"><i class="fa-solid fa-file-lines pr-1"></i>Post</a>
                </li>
            </ul>
 
            <ul class="up-part">
                @auth
                <li>
                    <a href="" class="p-3"><i class="fa-solid fa-user pr-1"></i>{{ auth()->user()->name }}</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post" class="inline">
                        @csrf
                        <button type="submit" class="p-3 logout"><i class="fa-solid fa-right-from-bracket pr-1"></i>Logout</button>
                    </form>
                </li>
                @endauth

                @guest
                <li>
                    <a href="{{ route('login') }}" class="p-3"><i class="fa-solid fa-right-to-bracket pr-1"></i>Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="p-3"><i class="fa-solid fa-user-plus pr-1"></i>Register</a>
                </li> 
                @endguest               
            </ul>
        </nav>

        @yield('content')
    </body>
</html>