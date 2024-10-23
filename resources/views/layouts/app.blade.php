<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | КиноКлад - собрание лучшего приключенческого кино.</title>
    <meta name="description" content="КиноКолумб - сайт о лучших приключенческих фильмах. Настало время приключений  для всей семьи!">
    <meta name="keywords" content="приключенческие фильмы, кино, семейное кино">
    <link rel="icon" href="{{ asset('assets/images/img.png') }}" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('movies.index') }}">
            <i class="fas fa-film"></i> КиноКлад
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Выход') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</header>
<div class="container-fluid hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 hero-text">
                <h2>КиноКлад  <i class="fas fa-toolbox"></i></h2>
                <p class="lead">
                     - подборка лучших приключенческих фильмов.<br>
                    Вы еще в раздумьях, что посмотреть  большой компанией?<br>
                    Скорее открывайте КиноКлад! <br>
                </p>
            </div>
            <div class="col-md-4 hero-icons">
                <i class="fas fa-globe-americas"></i>
                <i class="fas fa-calendar-alt"></i>
                <i class="fas fa-star"></i><br>
            </div>
        </div>
    </div>
</div>
<main>
    <div class="container-fluid mt-5 mb-5">
        @yield('content')
    </div>
</main>
<footer class="text-center text-lg-start">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">О нас</h5>
                <p>
                    КиноКолумб. Собрание лучших приключенческих фильмов!
                </p>
            </div>
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Контакты</h5>
                <p>
                    Email: <a href="mailto:info@kinokvest.by" style="color:white">info@kinokvest.ru</a>
                </p>
            </div>
        </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        2024 КиноКолумб
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>