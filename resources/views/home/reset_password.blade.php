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
                               
                               <nav class="custom-tab no-un m-t-40">
                                <ul> 
                                    <li class="active"><a href="javascript:void(0)">Reset Password</a></li>                                    
                                </ul>
                            </nav>
                            <form action="{{ url("/User/UpdatePassword") }}" method="POST" class="m-t-30" id="login_form">
                                 {{ csrf_field() }}
                                <div class="form-group ">
                                    <div class="form-group-material textbox">
                                        <label class="control-label">New Password</label>
                                        <input type="password" class="form-control" placeholder="Enter New Password" name="new_password" required>
                                    </div>
                                </div>
                                 <div class="form-group ">
                                    <div class="form-group-material textbox">
                                        <label class="control-label">Confirm New Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm New Password" name="confirm_new_password" required>
                                    </div>
                                </div>
                                <button type="submit" class="text-uppercase btn btn-primary btn-lg right-arrow-btn btn-block text-left">Submit</button>
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
   fblogin('http://ratemyitrecruiter.com/login','employee');
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