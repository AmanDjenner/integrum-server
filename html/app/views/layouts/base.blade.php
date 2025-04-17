<!DOCTYPE html>
<html class="{[ $baseclass or '' ]}" lang="{[ Config::get('app.locale','pl')]}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta http-equiv="X-UA-Compatible" content="{[ $meta or 'IE=edge,chrome=1' ]}">
        <title>{[ Lang::get('content.title') ]} - {[ $titleDetail or '' ]}</title>
        <link rel="stylesheet" href="/css/vendor.3f36f94d.css">
        <link rel="stylesheet" href="/css/main.5d0b7dd3.css">
		@yield('basestylesheets')
		@yield('stylesheets')
        <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="{[ $baseclass or '' ]}">
@yield('precontent')
@yield('postcontent')
@yield('content')
    </body>
</html>