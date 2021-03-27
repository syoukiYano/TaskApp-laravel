<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDoメモアプリ</title>  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Tempus Dominus CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0/css/tempusdominus-bootstrap-4.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
</head>
<body>
<header>
  <nav class="my-navbar">
    <a class="my-navbar-brand text-center" href="/">ToDoメモアプリ</a>
    @if (Route::has('login'))
        <div class="top-right links d-flex flex-row">
            @auth
                <a href="{{ route('home') }}" class="btn btn-link" style="text-decoration:none;">ホーム</a>
                <form action="{{ route('logout') }}" method="post">
                    {{csrf_field() }}
                    <input type="submit" value="ログアウト" class="btn btn-link" style="text-decoration:none;"><i class="fas fa-sign-out-alt"></i>
               </form>   
            @else
                <a href="{{ route('login') }}" class="btn btn-link" style="text-decoration:none;"><i class="fas fa-sign-in-alt"></i> ログイン</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-link" style="text-decoration:none;"><i class="fas fa-user-plus"></i> 新規登録</a>
                @endif
                
            @endauth
        </div>
    @endif
  </nav>
</header>
<main class="py-4">
    @yield('content')
</main>
</body>
</html>
