<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
        
        <link href="{{ url('/') }}/public/default/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="{{ url('/') }}/public/default/styles/style.css" rel="stylesheet" type="text/css" />

        <script>
// Get the video
            var video = document.getElementById("myVideo");

// Get the button
            var btn = document.getElementById("myBtn");

// Pause and play the video, and change the button text
            function myFunction() {
                if (video.paused) {
                    video.play();
                    btn.innerHTML = "Pause";
                } else {
                    video.pause();
                    btn.innerHTML = "Play";
                }
            }
        </script>

        <!-- Bootstrap 3.3.2 JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <!-- jvectormap -->
        <script src="{{ url('/') }}/public/default/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    </head>


<body>
        <header class="site-header">

            <nav class="navbar navbar-default">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/') }}/public/default/images/logo/Black.svg" alt="" title=""/></a>
                        <div class="pull-right visible-xs m-r-10">
                            <a href="{{ url("/User/Login") }}" class="btn btn-default text-uppercase m-r-10">LOGIN</a>
                            <a href="{{ url("/Join") }}" class="btn btn-primary text-uppercase">Join</a>
                        </div>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">How it Works</a></li>
                            <li><a href="#">What is RKA?</a></li>
                            <li class="hidden-xs"><a href="{{ url("/User/Login") }}" class="btn btn-default text-uppercase">LOGIN</a></li>
                            <li class="hidden-xs"><a href="{{ url("/Join") }}" class="btn btn-primary text-uppercase">Join</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>

        </header>

                <!-- Main content -->
                    @yield('content')

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <a href="{{ url('/') }}" class="footer-logo"><img src="{{ url('/') }}/public/default/images/logo/White.svg" alt="" title=""/></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <ul class="footer-list-item">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Our History</a></li>
                            <li><a href="#">What is RKA?</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <ul class="footer-list-item">
                            <li><a href="{{ url("/Join") }}">SIGN UP</a></li>
                            <li><a href="#">CONTACT</a></li>
                            <li><a href="#">Download app</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <ul class="footer-list-item footer-list-item1">
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <ul class="social-icon-footer">
                            <li><a href="#"><img src="{{ url('/') }}/public/default/images/icons/Social white/Facebook.svg" alt="" title=""/></a></li>
                            <li><a href="#"><img src="{{ url('/') }}/public/default/images/icons/Social white/Twitter.svg" alt="" title=""/></a></li>
                            <li><a href="#"><img src="{{ url('/') }}/public/default/images/icons/Social white/Instagram.svg" alt="" title=""/></a></li>
                            <li><a href="#"><img src="{{ url('/') }}/public/default/images/icons/Social white/G+.svg" alt="" title=""/></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ url('/') }}/public/default/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script>
// Get the video
            var video = document.getElementById("myVideo");

// Get the button
            var btn = document.getElementById("myBtn");

// Pause and play the video, and change the button text
            function myFunction() {
                if (video.paused) {
                    video.play();
                    btn.innerHTML = "Pause";
                } else {
                    video.pause();
                    btn.innerHTML = "Play";
                }
            }
        </script>
    </body>


</html>