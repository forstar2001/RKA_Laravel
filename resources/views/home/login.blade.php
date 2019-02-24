@extends("layouts.dashboardlayout")
@section('content')

<section class="sign-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-6 col-xs-12">
                        <div class="sign-box">
                            <h2 class="site-titel-dashboard">Welcome to RKA </h2>
                            <p class="desp">Enabling the Endurance Athlete to Achieve the Extraordinary</p>
                               @if (Session::has('msg'))
                                <div class="alert alert-danger">{{ Session::get('msg') }}</div>
                               @endif

                               @if (Session::has('smsg'))
                                <div class="alert alert-success">{{ Session::get('smsg') }}</div>
                               @endif
                               
                               <nav class="custom-tab no-un m-t-40">
                                <ul>                                    
                                    <li><a href="{{ url("/Join") }}">Sign Up</a></li>
                                    <li class="active"><a href="{{ url("User/Login") }}">Login</a></li>                                    
                                </ul>
                            </nav>
                            <form action="{{ url("/User/LoginAccess") }}" method="POST" class="m-t-30" id="login_form">
                                 {{ csrf_field() }}
                                 <?php
                                    if (isset($_COOKIE['username']) && $_COOKIE['username']!=""){
                                        $u_value = "value=" . $_COOKIE['username'];
                                        $checked = "checked=checked";
                                    } else {
                                        $u_value = "";
                                        $checked = "";
                                    }

                                    if (isset($_COOKIE['password']) && $_COOKIE['password']!=""){
                                        $p_value = "value=" . $_COOKIE['password'];
                                        $checked = "checked=checked";
                                    } else {
                                        $p_value = "";
                                        $checked = "";
                                    }
                                ?>
                                <div class="form-group ">
                                    <input type="hidden" id="fb_access_token" name="fb_access_token" value=""/>
                                    <div class="form-group-material textbox">
                                        <label class="control-label">Email</label>
                                        <input type="text" class="form-control" placeholder="Email" name="username" <?php echo $u_value; ?> required>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="form-group-material textbox">
                                        <label class="control-label">Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password" <?php echo $p_value; ?> required>
                                    </div>
                                </div>
                                <div id="Options" class="label-set-content pull-left">
                                        <div class="checkbox checkbox-custom">
                                            <label>
                                                <input type="checkbox" name="remember_me" value="Y" <?php echo $checked; ?>>
                                                <span class="checkmark"></span><span>Remember me</span>
                                            </label>
                                        </div>
                                </div>
                                <a href="{{ url("/User/ForgotPassword") }}" class="btn btn-grey pull-right">
                                    Forgot Password
                                </a>
                                <button type="submit" class="text-uppercase btn btn-primary btn-lg right-arrow-btn btn-block text-left">Login</button>
                                <p class="text-center text-muted m-20">- OR -</p>
                                <button type="button" id="fb_login" class="text-uppercase btn btn-primary btn-lg right-facebook-btn btn-block text-left">Login with facebook</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-6 col-xs-12 hidden-xs">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="{{ url('/') }}/public/default/images/img_bg.png" alt="" style="width:100%;">
                                </div>

                                <div class="item">
                                    <img src="{{ url('/') }}/public/default/images/img_bg.png" alt="" style="width:100%;">
                                </div>

                                <div class="item">
                                    <img src="{{ url('/') }}/public/default/images/img_bg.png" alt="" style="width:100%;">
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

<script>
    
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    window.fbAsyncInit = function () {
        FB.init({
            appId: '214136889295852',
            cookie: false, // enable cookies to allow the server to access
            // the session
            xfbml: true, // parse social plugins on this page
            version: 'v2.1' // use version 2.1
        });


    };
    
    
    $('#fb_login').click(function(){
        fblogin('http://192.168.1.2:8080/dev/RKA/User/Login','');
    });

function fblogin(url_to_redirect,user_selected) {
  FB.login(function(response) {
     if (response.authResponse) {
			$('#fb_access_token').val(response.authResponse.accessToken);
                        
            var form = document.forms.login_form;
            form.submit();
     }
     else {
     }
 }, {scope:'public_profile,email'});
}
    </script>

@endsection