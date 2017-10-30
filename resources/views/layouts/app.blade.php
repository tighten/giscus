<!DOCTYPE html>
<html>
    <head>
        <title>Giscus</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/app.css">

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    </head>
    <body>
        <header class="header">
            <div class="ribbon">&nbsp</div>

            <div class="container">
                <nav class="navbar navbar-head">
                    <a class="navbar-brand" href="/">
                        <img src="/giscus-logo.svg" class="giscus-logo" alt="Giscus">
                    </a>
                    <div class="navbar-buttons">
                        @if (Auth::check())
                            <a href="/logout" class="btn btn-default">
                                Log out
                                <i class="fa fa-sign-out"></i>
                            </a>
                        @endif
                    </div>
                </nav>
            </div>

        </header>

        <main class="container">
            <div class="main-content">
                @yield('content')
            </div>
        </main>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row col-md-8 col-md-push-2 text-center small">
                    Giscus' source is on GitHub: <a href="https://github.com/tightenco/giscus">tightenco/giscus</a>.<br>
                    By <a href="http://mattstauffer.co/">Matt Stauffer</a>, for a <a href="https://speakerdeck.com/mattstauffer/leveraging-laravel-launching-side-projects-quickly-with-laravel">talk at Laracon 2015</a>, powered by <a href="http://www.laravel.com/">Laravel</a>.<br>
                </div>
            </div>
        </footer>

        @yield('footerScripts')

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-40114814-9', 'auto');
          ga('send', 'pageview');

        </script>
    </body>
</html>
