<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - 登录</title>

        <!-- Styles -->
        @if (asset_exists('static/css/login.css'))
        <link href="<?=asset_url('static/css/login.css')?>" rel="stylesheet">
        @endif

        <link rel="shortcut icon" href="<?=asset_url('favicon.ico')?>" type="image/x-icon">
    </head>
    <body>
        <div class="klxx-login">
            @yield('content')
        </div>
    </body>
</html>
