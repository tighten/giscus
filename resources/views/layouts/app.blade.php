<!DOCTYPE html>
<html>
    <head>
        <title>Giscus</title>

        <link rel="stylesheet" href="/css/app.css">

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                @if (Auth::check())
                <a href="/logout" class="btn btn-default pull-right meta-button">Log out <i class="fa fa-sign-out"></i></a>
                @else
                <a href="/auth/github" class="btn btn-default pull-right meta-button">Log in with Github <i class="fa fa-github"></i></a>
                @endif
                <h1 class="text-center page-title"><img src="/giscus-logo.png" class="giscus-logo" alt="Giscus"></h1>
            </div>
            <div class="row col-md-8 col-md-push-2">
                @yield('content')
            </div>
        </div>

        @yield('footerScripts')
    </body>
</html>
