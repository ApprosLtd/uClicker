<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <title>Админка / {{$title}}</title>

</head>
<body role="document">

<?
$user = Auth::user();
?>

<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">uClicker</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li<?= Request::is('/')          ? ' class="active"' : '' ?>><a href="/">Главная</a></li>
                <li<?= Request::is('sites')      ? ' class="active"' : '' ?>><a href="/sites">Сайты</a></li>
                <li<?= Request::is('balance')    ? ' class="active"' : '' ?>><a href="/balance">Баланс</a></li>
                <li<?= Request::is('statistics') ? ' class="active"' : '' ?>><a href="/statistics">Статистика</a></li>
                <li<?= Request::is('help')       ? ' class="active"' : '' ?>><a href="/help">Справочник</a></li>
                <li<?= Request::is('support')    ? ' class="active"' : '' ?>><a href="/support">Тех. поддержка</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $user->email }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/profile">Профиль</a></li>
                        <li class="divider"></li>
                        <li><a href="/auth/logout">Выход</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container theme-showcase" role="main" style="margin-top: 50px">
    {{ $content }}
</div>
</body>
</html>
