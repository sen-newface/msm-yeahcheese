<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar nabvar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <p class="navbar-brand mb-0 h1">YeahCheese</p>
                <a href="{{ route('events.search') }}">イベント検索</a>
                <!--ログインしてたら-->
                @if (Auth::check())
                    <a href="{{ route('events.index') }}">イベント一覧</a>
                    <!--ログアウトの処理-->
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <p class="mb-0">{{ Auth::user()->email }}</p>
                <!--ログインしてなかったら-->
                @else
                    <a href="/login">login</a>
                    <a href="/register">register</a>
                @endif
            </div>
        </nav>

        <div class="content">
            @yield('content')
        </div>

    </body>
</html>
