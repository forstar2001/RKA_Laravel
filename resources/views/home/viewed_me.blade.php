@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
    <div class="content">
        <nav class="custom-tab">
            @include("home.interests_menu")
        </nav>
        <?php if (isset($viewed_me_info) && empty($viewed_me_info)) { ?>
         <div class="m-t-40" >
            <h4 class="m-t-0 font-semibold m-b-">No one viewed your profile yet.</h4>
            </div>
        <?php } ?>
        <?php if (isset($profile_complete) && $profile_complete != 100) {
            ?>
            <div class="m-t-40">
                <div class="panel panel-default">
                    <div class="panel-body p-30">
                        <div class="row">
                            <div class="col-md-4">
                                <p>Complete your profile to get more views</p>
                                <div class="m-t-15 m-b-5 clearfix">
                                    <label class="show font-bold ">Profile complete <span class="pull-right">{{ $profile_complete }}%</span></label>
                                </div>

                                <div class="progress profile-progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $profile_complete }}"
                                         aria-valuemin="0" aria-valuemax="100" style="width:{{ $profile_complete }}%">
                                        <span class="sr-only">{{ $profile_complete }}% Complete</span>
                                    </div>
                                </div> 
                                <a href="{{url("/User/BasicProfile")}}" class="btn btn-primary text-uppercase">Complete Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>




        <?php
        if (isset($viewed_me_info) && !empty($viewed_me_info)) {
            foreach ($viewed_me_info as $view_info) {
                ?>
        <div class="m-t-40" >
                <div class="col-sm-6 col-md-4">
                    <div class="panel panel-default trainer-list">
                        <div class="panel-body p-30">
                            <div class="user-img-div">
                                <div class="rounded-avatar">
                                    <?php
                                    $prof_pic = url('/') . '/public/default/images/demo-avatar.png';
                                    if (isset($view_info->profile_picture) && $view_info->profile_picture != "") {
                                        if (file_exists(public_path() . '/uploads/user_profile_pictures/' . $view_info->profile_picture)) {
                                            $prof_pic = url('/') . '/public/uploads/user_profile_pictures/' . $view_info->profile_picture;
                                        }
                                    }
                                    ?> 
                                    <img src="{{$prof_pic}}" alt="">
                                </div>
                                <span class="online"></span>
                            </div>
                            <div class="user-info text-center">
                                <a href="{{ url("/User/TrainerProfile/".$view_info->viewed_profile) }}"><h3>{{$view_info->name}}</h3></a>
                                <p class="small-info">{{$view_info->profile_type}}</p>
                                <p class="small-info">{{$view_info->primary_location}}</p>
                            </div>
                            <ul class="count-info">
                                <li>
                                    <h6><?php echo isset($view_info->view_me_distance) && $view_info->view_me_distance != '' ? $view_info->view_me_distance : 0; ?> km</h6>
                                    <p>nearby</p>
                                </li>
                                <li>
                                    <h6>$<?php echo isset($view_info->rate) && $view_info->rate != '' ? $view_info->rate : 0; ?></h6>
                                    <p>per hour</p>
                                </li>
                            </ul>
                            <div class="text-center">
                                <a class="btn btn-message" href="#">
                                    Message
                                </a>
                            </div>

                        </div>
                    </div>
                </div>


                <?php
            }
        }
        ?>
            </div>
    </div>
</section>
@endsection

