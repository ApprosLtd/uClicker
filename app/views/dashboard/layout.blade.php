<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/packages/bootstrap/css/bootstrap.min.css">
    <!-- Optional theme -->
    <!--link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"-->
    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <title>Админка / {{$title}}</title>

    <style>
        html, .yellow-bg{
            background-color: #F1EDE1;
        }
        .base-container{
            margin-top: 70px;
            background: #FFF;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 1px 1px 6px rgba(0, 0, 0, 0.3);
        }
        blockquote{
            font-size: 13px;
            padding-right: 300px;
        }
        blockquote.blockquote-reverse{
            padding-left: 300px;
        }
    </style>

</head>
<body role="document" class="yellow-bg">

<?

if (!isset($current_page)) $current_page = null;

$ifActivePage = function ($alias) use ($current_page) {
    if ($alias == $current_page) return true;
    if (Request::is($alias)) return true;
    return false;
};

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
            <a class="navbar-brand" href="/sites">uClicker</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!--li<?= $ifActivePage('/')          ? ' class="active"' : '' ?>><a href="/">Главная</a></li-->
                <li<?= $ifActivePage('sites')      ? ' class="active"' : '' ?>><a href="/sites">Сайты</a></li>
                <li<?= $ifActivePage('visitors')   ? ' class="active"' : '' ?>><a href="/visitors">Посетители</a></li>
                <li<?= $ifActivePage('balance')    ? ' class="active"' : '' ?>><a href="/balance">Баланс</a></li>
                <li<?= $ifActivePage('statistics') ? ' class="active"' : '' ?>><a href="/statistics">Статистика</a></li>
                <li<?= $ifActivePage('help')       ? ' class="active"' : '' ?>><a href="/help">Справочник</a></li>
                <!--li<?= $ifActivePage('support')    ? ' class="active"' : '' ?>><a href="/support">Тех. поддержка</a></li-->
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

<div class="container theme-showcase base-container" role="main">
    {{ $content }}
</div>

<div style="width: 400px; margin: 10px auto; font-size:12px; text-align: center; color: #726D5F">
    © 2013 - <?= date('Y') ?>. ООО "Центр инновационных технологий"
</div>

</body>
</html>
