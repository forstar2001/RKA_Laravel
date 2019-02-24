<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>RKA - Relentless Kinetics Anywhere</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ url('/') }}/public/admin_asset/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <!-- Theme style -->        
        <link href="{{ url('/') }}/public/admin_asset/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

        <!-- iCheck -->
        <link href="{{ url('/') }}/public/admin_asset/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries logo-icon.png-->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo text-center">
                <img src="" alt="" />
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <h4 class="text-center">RKA - Relentless Kinetics Anywhere</h4><br/>
                <form action="{{ route('AdminLoginAccess') }}" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" id="username" name="username" class="form-control input-lg" placeholder="Username"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" id="passowrd" name="password" class="form-control input-lg" placeholder="Password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <input type="hidden" name="_token" value="{{ Session::token()}}" />
                    </div>
                    @if(count($errors) > 0)
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="callout callout-danger">
                                @foreach($errors->all() as $error)
                                <p><i class="fa fa-warning"></i> {{ $error }}</p>
                                @endforeach
                            </div>
                        </div>    
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn bg-purple btn-block btn-flat btn-lg">Sign In</button>
                        </div><!-- /.col -->
                    </div>
                </form> 



            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <p class="text-center text-white">&copy; <?php echo date('Y'); ?> RKA - Relentless Kinetics Anywhere.</p>

        <!-- jQuery 2.1.3 -->
        <script src="{{ url('/') }}/public/admin_asset/plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{ url('/') }}/public/admin_asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="{{ url('/') }}/public/admin_asset/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
        </script>
    </body>
</html>