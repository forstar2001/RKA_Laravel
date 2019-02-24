<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>RELENTLESS</title>
        <!-- google font -->
        <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
        <link href="{{ url('/') }}/public/default/styles/icomoon/styles.css" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="{{ url('/') }}/public/default/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- range slider -->
        <link rel="stylesheet" href="{{ url('/') }}/public/default/plugins/ion.rangeSlider/css/ion.rangeSlider.css"/>
        <link rel="stylesheet" href="{{ url('/') }}/public/default/plugins/ion.rangeSlider/css/ion.rangeSlider.skinNice.css" />
        <!-- style -->
        <link href="{{ url('/') }}/public/default/styles/login.css" rel="stylesheet">
        <link href="{{ url('/') }}/public/default/styles/form.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/core/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/core/moment.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js"></script>
                       
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/slimscroll/jquery.slimscroll.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/core/jquery_ui/core.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/selects/selectboxit.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/tags/tagsinput.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/tags/tokenfield.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/inputs/touchspin.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/inputs/maxlength.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/inputs/formatter.min.js"></script>

        <script type="text/javascript" src="{{ url('/') }}/public/default/plugins/forms/form_floating_labels.js"></script>

        <script>
            $(function () {
                $('#sidebar').slimScroll({
                    height: '100vh'
                });

                $(function () {
                    $('#datetimepicker1').datetimepicker();
                });
            });
        </script>
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
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="aboutus.html">About Us</a></li>
                            <li><a href="whatisrka.html">Benefits</a></li>
                            <li><a href="howitworks.html">How it Works</a></li>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>

        </header>
        
        
    </body>
</html>
@yield('content')