<!DOCTYPE html>
<html lang="{[ Config::get('app.locale','pl')]}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta http-equiv="X-UA-Compatible" content="{[ $meta or 'IE=edge,chrome=1' ]}">
        <title>{[ Lang::get('content.title') ]} - {[ $titleDetail or '' ]}</title>
        <link rel="stylesheet" href="/css/vendor.3f36f94d.css">
        <link rel="stylesheet" href="/css/main.5d0b7dd3.css">
		@yield('stylesheets')
        <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <input type="hidden" id="help-content-link" value="/help/{[$helpcnt or 'wprowadzenie.html']}"/>
        @include('layouts/navbar',$navbarVars)
        <div class="content-div container-fluid" style="overflow-x:auto;">
        <input id="fakefocus" type="checkbox" style="position:absolute;left:-999em;opacity:0;"/>
@if($navbarVars['showRegions'])		
           @include('layouts/sideregion', $sideRegionVars)
@endif
            @yield('content')
           @include('help/sidewindow')
        </div>
        <script src="/js/vendor.7884c6a6.js"></script>
        <script>
            var justloggedin = {[Session::get('justloggedin', 'false')]};
            $.fn.select2.defaults.set( "theme", "bootstrap" );
			$(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })


            $("body").on('click','.changeToText',function () {
                var obj = $(this).data("value");
                var type = 'password';
                var iconType = "";
                if (0 === obj.id) {
                    obj.id = 1;
                    type = 'text';
                    iconType = "-slash";
                } else {
                    obj.id = 0;
                }
                $(obj.input).each(function (key, input) {
                    $('#' + input).attr('type', type);
                });
                $(this).data("value", obj);
				
				if ($(this).data("linked")) {
				    $btn = $(".changeToText-icon");
				} else {
				    $btn = $("#" + obj.span);
				}
				$btn.removeClass("fa-eye");
				$btn.removeClass("fa-eye-slash");
				$btn.addClass("fa-eye" + iconType);
            });

        </script>


        <script src="/js/script-main.64c32307.js"></script>
        {[ isset($editTree) ?'': '
        <script src="/js/script-tree.0ab69345.js"></script>
        ' ]}
        @yield('javascripts')
        @yield('modalDialogs')
        @include('dialogs/message')
        @include('help/welcomedialog')
    </body>
</html>