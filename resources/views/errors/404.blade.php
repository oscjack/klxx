<!DOCTYPE html>
<html>
    <head>
        <title>访问错误</title>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">

            <div class="content">
                <img src="<?=asset_url('static/img/logo.png')?>" />

                <div class="title">404错误: 你的请求不能处理</div>
            </div>
        </div>
    </body>
</html>
