<!DOCTYPE html>
<html class="login" lang="{[ Config::get('app.locale','pl')]}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta http-equiv="X-UA-Compatible" content="{[ $meta or 'IE=edge,chrome=1' ]}">
        <title>{[ Lang::get('content.title') ]}</title>
        <link rel="stylesheet" href="/css/vendor.3f36f94d.css">
        <link rel="stylesheet" href="/css/main.5d0b7dd3.css">
    </head>
    <body class="login">
        @yield('content')
    </body>
</html>