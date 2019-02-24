@extends("layouts.dashboardlayout")
@section('content')
 <section class="sign-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-6 col-xs-12">
                        <div class="sign-box">                            
                            <?php if (session('msg') != "") { ?>
                                <div class="alert alert-success">
                                    {{ session('msg') }}
                                </div><br>
                            <?php } ?>
                                @if (Session::has('message'))
                                <div class="alert alert-danger">{{ Session::get('message') }}</div>
                                @endif
                            <h2 class="site-titel-dashboard">Welcome to RKA </h2>
                            <p class="desp">Enabling the Endurance Athlete to Achieve the Extraordinary</p>
                            <nav class="custom-tab no-un m-t-40">
                                <ul>
                                    <li class="active"><a href="{{ url("/Join") }}">Sign Up</a></li>
                                    <li><a href="{{ url("User/Login") }}">Login</a></li>
                            </nav>
                            <form action="{{ url("/User/SignUpStepOne") }}" method="POST" class="m-t-30" >
                                {{ csrf_field() }}
                                <div class="form-group ">
                                    <div class="form-group-material textbox">
                                        <label class="control-label">Full Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="form-group-material textbox">
                                        <label class="control-label">Email</label>
                                        <input type="text" class="form-control" name="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="form-group-material textbox">
                                        <label class="control-label">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <button type="submit" class="text-uppercase btn btn-primary btn-lg right-arrow-btn btn-block text-left">Create Account</button>
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
@endsection