@extends("layouts.user_dashboardlayout")
@section('content')
 <section class="right-section">
                <div class="content">
                        @include("home.interests_menu")
                    <div class="row m-t-40">
                        <?php if(!empty($favorites_info)){   
                             foreach($favorites_info as $fav_info){ 
                                 ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="panel panel-default trainer-list">
                                <div class="panel-body p-30">
                                    <div class="user-img-div">
                                        <div class="rounded-avatar">
                                           <?php
                                        $prof_pic = url('/').'/public/default/images/demo-avatar.png';
                                        if(isset($fav_info->profile_picture) && $fav_info->profile_picture!=""){
                                            if (file_exists( public_path().'/uploads/user_profile_pictures/'.$fav_info->profile_picture)) {
                                                $prof_pic = url('/').'/public/uploads/user_profile_pictures/'.$fav_info->profile_picture;
                                            } 
                                        }
                                    ?> 
                                            <img src="{{$prof_pic}}" alt="">
                                        </div>
                                        <span class="online"></span>
                                    </div>
                                    <div class="user-info text-center">
                                        <a href="{{ url("/User/TrainerProfile/".$fav_info->favorite_profile) }}"><h3>{{$fav_info->name}}</h3></a>
                                        <p class="small-info">{{$fav_info->profile_type}}</p>
                                        <p class="small-info">{{$fav_info->primary_location}}</p>
                                    </div>
                                    <ul class="count-info">
                                        <li>
                                            <h6><?php echo isset($fav_info->trainer_distance) && $fav_info->trainer_distance != '' ?$fav_info->trainer_distance : 0 ;?> km</h6>
                                            <p>nearby</p>
                                        </li>
                                        <li>
                                            <h6>$<?php echo isset($fav_info->rate) && $fav_info->rate != '' ?$fav_info->rate : 0 ;?></h6>
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
                 <?php  } 
                     }else{  ?>
                         <div class='text text-danger'>No Favorites Found</div>
              <?php       }  ?>
                   </div>
                </div>
            </section>


        <!-- Compose Message Modal -->
        <div class="modal fade" id="composeMessage" tabindex="-1" role="dialog" aria-labelledby="composeMessageModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content create-message">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="modal-close-icon"></i></button>
                        <h4 class="modal-title m-b-20" id="myModalLabel"><i class="new-message-icon m-r-15"></i> New Message</h4>
                        <div class="custom-autoselect">
                            <div class="selected-contacts">
                                <label>To: </label>
                                <ul class="selected-contact-list">
                                    <li class="contact">Rand Lyons <a href="" class="remove-contact"><i class="icon-cross2"></i></a></li>
                                    <li class="contact last">John Doe <a href="" class="remove-contact"><i class="icon-cross2"></i></a></li>
                                    <li class="input-people-name"><input type="text" id="search-people" placeholder="Search Contact" /></li>
                                </ul>
                            </div>
                            <div class="contact-suggestion">
                                <ul>
                                    <li data-contactId="1">
                                        <div class="user-avatar">
                                            <div class="rounded-avatar">
                                                <img src="images/trainer_avatar.jpg" />
                                            </div>
                                        </div>
                                        <div class="contact-info">
                                            <span>Randy Schmidt</span>
                                            randy.schmidt@example.com
                                        </div>
                                    </li>
                                    <li data-contactId="2">
                                        <div class="user-avatar">
                                            <div class="rounded-avatar">
                                                <img src="images/trainer_avatar.jpg" />
                                            </div>
                                        </div>
                                        <div class="contact-info">
                                            <span>Randy Lyons</span>
                                            randy.schmidt@example.com
                                        </div>
                                    </li>
                                    <li data-contactId="3">
                                        <div class="user-avatar">
                                            <div class="rounded-avatar">
                                                <img src="images/trainer_avatar.jpg" />
                                            </div>
                                        </div>
                                        <div class="contact-info">
                                            <span>Randy Maers</span>
                                            randy.schmidt@example.com
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="m-b-30">
                            <textarea class="form-control message_body" id="message_body" rows="10" placeholder="Type your message here..."></textarea>
                        </div>

                        <div class="attached-files">
                            <ul>
                                <li style="background-image: url(images/trainer-photo1.jpg);">
                                    <a href=""><i class="modal-close-icon"></i></a>
                                </li>
                                <li style="background-image: url(images/trainer-photo2.jpg);">
                                    <a href=""><i class="modal-close-icon"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <div class="pull-left">
                            <label class="add-attachment m-r-15"><input type="file" name="" /></label>

                            <!--<div class="dropdown emoticons" style="display: inline-block;">
                                <a href="" data-toggle="dropdown" class="dropdown-toggle"></a>
                                <ul class="dropdown-menu">
                                    <li></li>
                                </ul>
                            </div>-->
                        </div>
                        <button type="button" class="btn btn-primary btn-send-msg">Send</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
