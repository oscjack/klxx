<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - 管理系统</title>

        <link rel="shortcut icon" href="<?=asset_url('favicon.ico')?>" type="image/x-icon">
        @if (asset_exists('static/css/app.css'))
        <link href="<?=asset_url('static/css/app.css')?>" rel="stylesheet">
        @endif
    </head>

    <body>
        <div class="klxx-dashboard">
            @yield('content')
        </div>

        @foreach (['manifest.js', 'vendor.js', 'app.js'] as $script)
        @if (asset_exists('static/js/' . $script))
        <script type="text/javascript" src="<?=asset_url('static/js/' . $script)?>"></script>
        @endif
        @endforeach
    </body>
</html>
