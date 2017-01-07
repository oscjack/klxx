<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>快乐兴兴 - 货单打印</title>

        <link rel="shortcut icon" href="<?=asset_url('favicon.ico')?>" type="image/x-icon">
        <style>
            .order-print {
                width: 900px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <div class="klxx-print">
            @yield('content')
        </div>
    </body>
</html>
