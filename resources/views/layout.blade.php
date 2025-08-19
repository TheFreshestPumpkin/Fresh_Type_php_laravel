<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshType</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                FreshType
            </a>
            <a class = "nav-link active" href ="/home">
                Профиль
            </a>
            <a class = "nav-link active" href ="/dialogs">
                Диалоги
            </a>
            <a class = "nav-link active" href ="{{route('friends.index')}}">
                Друзья
            </a>
            <a class = "nav-link active" href ="/">
                Лента
            </a>
            <a class = "nav-link active" href ="/">
                Группы
            </a>
            @auth
                <form method="post" action="/logout">
                    @csrf
                    <button type="submit" class="btn btn-primary">Выйти</button>
                </form>
            @endauth
            @guest
                <a class = "nav-link active" href ="/login">
                    Войти
                </a>
            @endguest
        </div>
    </nav>
    @yield('content')
</body>
</html>
