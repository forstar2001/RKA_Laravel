<?php  
use App\ApiModel;
use App\UserDetail;
?>
@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
<?php  $user_obj = new ApiModel();
       $fav_obj =  new UserDetail(); 
//       print_r($trainer_basic_info);die;
       $visible = $fav_obj->countFav($trainer_basic_info[0]->user_id);
?>

                <div class="trainer-header">
                    <div class="content">
                        <ol class="breadcrumb">
                            <li><a href="#">{{ (isset($trainer_basic_info[0]->profile_type) && $trainer_basic_info[0]->profile_type != '')?$trainer_basic_info[0]->profile_type : '' }}</a></li>
                            <li class="active">{{ $trainer_basic_info[0]->first_name }}</li>
                        </ol>
                        <div class="trainer-info">
                            <div class="trainer-avatar">
                                <div class="rounded-avatar" data-width="150" data-height="150">
                                    <?php
                                        $prof_pic = url('/').'/public/default/images/demo-avatar.png';
                                        if(isset($trainer_basic_info[0]->profile_picture) && $trainer_basic_info[0]->profile_picture!=""){
                                            if (file_exists( public_path().'/uploads/user_profile_pictures/'.$trainer_basic_info[0]->profile_picture)) {
                                                $prof_pic = url('/').'/public/uploads/user_profile_pictures/'.$trainer_basic_info[0]->profile_picture;
                                            } 
                                        }
                                    ?>
                                    <img src="{{ $prof_pic }}" />
                                </div>
                            </div>
                            <div class="trainer-info-right">
                                <div class="trainer-basic-info">
                                    <h1>{{ $trainer_basic_info[0]->first_name }}</h1>
                                    <div class="profile-type">{{ isset($trainer_basic_info[0]->profile_type) && $trainer_basic_info[0]->profile_type != '' ? $trainer_basic_info[0]->profile_type: '' }}</div>
                                    <h4>
                                    <?php
                                    if(isset($trainer_basic_info[0]->date_of_birth) && $trainer_basic_info[0]->date_of_birth != ''){
                                        $age = (date('Y') - date('Y',strtotime($trainer_basic_info[0]->date_of_birth)));
                                    }else{
                                        $age = '';
                                    }
                                    ?>
                                    {{$age}}
                                    <span></span> {{ isset($trainer_basic_info[0]->gender) && $trainer_basic_info[0]->gender!= '' ?$trainer_basic_info[0]->gender : '' }} <span></span> {{ isset($trainer_basic_info[0]->location) && $trainer_basic_info[0]->location != '' ? $trainer_basic_info[0]->location: '' }}
                                    </h4>
                                </div>
                                
                                <div class="trainer-actions">
                                    <?php if($trainer_basic_info[0]->profile_id == 2 || $trainer_basic_info[0]->profile_id == 5){ ?>
                                    <a href="" class="btn btn-primary text-uppercase">Offer</a>
                                    <?php  }else {?>
                                    <a href="{{url("/User/PayWithCreditCard/".$trainer_basic_info[0]->user_id)}}" class="btn btn-primary text-uppercase">Hire Me</a>
                                    <?php } ?>
                                    <a href="" data-toggle="modal" data-target="#composeMessage" class="btn btn-white text-uppercase">Message</a>
                                    <a href="javascript:void(0)" class="btn btn-white btn-heart" onclick="add_fav('<?php echo $trainer_basic_info[0]->user_id ?>')">
                                         <?php if($visible == 1) {?> 
                                        <i class="icon-heart5" id='favorite'></i>
                                         <?php }else{ ?>
                                        <i class="icon-heart6" id='favorite'></i>
                                         <?php  } ?>
                                             </a>
                                         
                                </div>
                            </div>

                        </div>
                        <?php  
                        $cover_pic = url('/').'/public/default/images/trainer-cover.jpg';
                       if(isset($public_photos[0]->profile_image) && $public_photos[0]->profile_image != "") {
                           if (file_exists(public_path() . '/uploads/user_public_photos/' . $public_photos[0]->profile_image)) {
                               $cover_pic = url('/') . '/public/uploads/user_public_photos/' . $public_photos[0]->profile_image;
                           }
                       }
                        ?>
                        <div class="trainer-cover-pic" style="background-image: url('{{ $cover_pic }}');"></div>
                    </div> 
                </div>

                <div class="trainer-content">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-3">
                                
                                <dl class="trainer-primary-info clearfix">
                                    <?php
                                    $extra_string='/training';
                                    if($trainer_basic_info[0]->profile_id != 2 ) {?>
                                    <dt><svg viewBox="0 0 24 24"><use xlink:href="#price"></use></svg> Rate:</dt>
                                    <dd>{{ isset($trainer_basic_info[0]->rate) && $trainer_basic_info[0]->rate != '' ? "$".$trainer_basic_info[0]->rate.$extra_string: 'N/A'}}</dd>
                                     <?php } ?>
                                    <dt><svg viewBox="0 0 24 24"><use xlink:href="#time"></use></svg> Member Since:</dt>
                                    <dd>{{ date("M d Y", strtotime($trainer_basic_info[0]->member_since)) }}</dd>
                                    <dt><svg viewBox="0 0 24 24"><use xlink:href="#last-active"></use></svg> Last Active:</dt>
                                    <dd>{{isset($trainer_basic_info[0]->last_active) && $trainer_basic_info[0]->last_active!="" ? date("M d Y", strtotime($trainer_basic_info[0]->last_active)) : 'Not Logged In Yet' }}</dd>
                                    <dt><svg viewBox="0 0 24 24"><use xlink:href="#price"></use></svg> Recent:</dt>
                                    <?php  if(isset($trainer_basic_info[0]->last_active) && $trainer_basic_info[0]->last_active != '' ) {
                                            if(isset($trainer_basic_info[0]->recent_login_location) && $trainer_basic_info[0]->recent_login_location != '' ) {?>
                                    <dd>{{$trainer_basic_info[0]->recent_login_location }}</dd>
                                            <?php }else{ ?>
                                    <dd>{{ $trainer_basic_info[0]->location }}</dd>            
                                       <?php     }
                                          }else{  ?>
                                    <dd><?php echo  "Not Logged In Yet" ?></dd>
                                 <?php   } ?>
                                    <dt><svg viewBox="0 0 24 24"><use xlink:href="#language"></use></svg> Language:</dt>
                                    <dd>{{ isset($trainer_basic_info[0]->language) && $trainer_basic_info[0]->language != '' ? $trainer_basic_info[0]->language: ''}}</dd>
                                </dl>

                            </div>
                            <div class="col-md-9">

                                <div class="page-title"><h4>{{ $trainer_basic_info[0]->first_name}}'s Info</h4></div>

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h4 class="font-size-14">Photos</h4>

                                        <ul class="trainer-photos">
                                        <?php if(!empty($public_photos)) {   
                                       foreach($public_photos as $photos){ ?>
                                            <li>
                                                <a href="" style="background-image: url('{{ url('/') }}/public/uploads/user_public_photos/{{ $photos->profile_image }}');"></a>
                                            </li>
                                        <?php } 
                                        }else{ ?>
                                            <li>
                                                <a href=""  ></a>
                                            </li>
                                <?php        }
                                        ?>
<!--                                            <li>
                                                <a href="" style="background-image: url(images/trainer-photo2.jpg);"></a>
                                            </li>-->
                                            <li class="locked">
                                                <div><svg viewBox="0 0 24 24"><use xlink:href="#lock"></use></svg></div>
                                                Private ({{count($private_photos)}})
                                                <a href="" class="btn btn-block">Request to view</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                               
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                         <?php if($trainer_basic_info[0]->profile_id != 2 ) {
                                              if(isset($trainer_basic_info[0]->training_philosophy) &&  $trainer_basic_info[0]->training_philosophy != ''){ ?>
                                        <h4 class="font-size-15">Training / Coaching Philosophy</h4>
                                        <p class="p-b-15">{{ $trainer_basic_info[0]->training_philosophy}}</p>
                                              <?php  }
                                               if(isset($trainer_basic_info[0]->experience) &&  $trainer_basic_info[0]->experience != ''){ ?>
                                        <h4 class="font-size-15">Experience</h4>
                                        <p class="p-b-15">{{ $trainer_basic_info[0]->experience}}</p>
                                        <?php  }
                                               if(isset($trainer_basic_info[0]->certifications) &&  $trainer_basic_info[0]->certifications != ''){ ?>
                                        <h4 class="font-size-15">Certifications</h4>
                                        <p class="p-b-15">{{ $trainer_basic_info[0]->certifications}}</p>
                                               <?php  }
                                              if(isset($trainer_basic_info[0]->workout_info_location) &&  $trainer_basic_info[0]->workout_info_location != ''){ ?>  
                                        <h4 class="font-size-15">Group Work-Out Info and Location</h4>
                                        
                                        <?php   
                                        
                                        $workout_info_location_arr = explode('^',$trainer_basic_info[0]->workout_info_location);
                                                foreach($workout_info_location_arr as $workout_info_location_val){
                                                    $workout_info_location_title =  $user_obj->getTableValueByID('group_workout_info_locations',$workout_info_location_val);
                                        ?>
                                        <p>{{ $workout_info_location_title }}</p>
                                        <?php }  ?>
                                        <!--<a href="" class="btn btn-primary">JOIN</a>-->
                                         <?php  } 
                                         }?>
                                        
                                        <?php  if($trainer_basic_info[0]->fitness_level != '' || $trainer_basic_info[0]->fitness_goals != '' || $trainer_basic_info[0]->athletic_achievements != ''
                                                || $trainer_basic_info[0]->scheduled_races != '' || $trainer_basic_info[0]->gym_memberships != '' || $trainer_basic_info[0]->outdoor_locations != ''
                                                || $trainer_basic_info[0]->personal_trainers != '' || $trainer_basic_info[0]->medical_issues != '' ||  $trainer_basic_info[0]->fitness_budget != '' || $trainer_basic_info[0]->rate_description != '') {?>
                                        <h4 class="font-size-15 m-t-40 m-b-20">Fitness Info</h4>
                                        <div class="row">
                                             <?php 
                                             if(isset($trainer_basic_info[0]->fitness_level) &&  $trainer_basic_info[0]->fitness_level != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Fitness Level</label>
                                                    <p>Level {{ $trainer_basic_info[0]->fitness_level}}</p>
                                                  
                                                </div>
                                            </div>
                                              <?php } 
                                               if(isset($trainer_basic_info[0]->fitness_goals) &&  $trainer_basic_info[0]->fitness_goals != ''){ ?>
                                            <div class="col-md-4">    
                                                <div class="form-group">           
                                                    <label class=" m-b-0">Fitness Goals</label>
                                                    <p>{{ $trainer_basic_info[0]->fitness_goals}}</p>
                                                </div>
                                            </div>
                                              <?php  } 
                                               if(isset($trainer_basic_info[0]->athletic_achievements) &&  $trainer_basic_info[0]->athletic_achievements != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Athletic Achievements</label>
                                                    <p>{{ $trainer_basic_info[0]->athletic_achievements}}</p>
                                                </div>
                                            </div>
                                              <?php } ?>
                                        </div>
                                        <div class="row">
                                             <?php   
                                               if(isset($trainer_basic_info[0]->scheduled_races) &&  $trainer_basic_info[0]->scheduled_races != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Scheduled Races</label>
                                                    <?php   $scheduled_races_arr = explode('^',$trainer_basic_info[0]->scheduled_races);
                                                         foreach($scheduled_races_arr as $scheduled_races_val){
                                                        $scheduled_races_title =  $user_obj->getTableValueByID('scheduled_races',$scheduled_races_val);
                                                      ?>
                                                    <p>{{ $scheduled_races_title}}</p>
                                                         <?php }  ?>
                                                </div>
                                            </div>
                                              <?php  } 
                                            if(isset($trainer_basic_info[0]->gym_memberships) &&  $trainer_basic_info[0]->gym_memberships != ''){ ?>
                                            <div class="col-md-4"> 
                                                <div class="form-group">              
                                                    <label class=" m-b-0">Gym Membership</label>
                                                     <?php   $gym_memberships_arr = explode('^',$trainer_basic_info[0]->gym_memberships);
                                                         foreach($gym_memberships_arr as $gym_memberships_val){
                                                             $gym_memberships_title =  $user_obj->getTableValueByID('gym_memberships',$gym_memberships_val);
                                                             ?>
                                                    <p>{{ $gym_memberships_title}}</p>
                                                         <?php  } ?>
                                                </div>
                                            </div>
                                             <?php } 
                                             if(isset($trainer_basic_info[0]->outdoor_locations) &&  $trainer_basic_info[0]->outdoor_locations != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Outdoor Work-Out Locations</label>
                                                    <?php   $outdoor_locations_arr = explode('^',$trainer_basic_info[0]->outdoor_locations);
                                                         foreach($outdoor_locations_arr as $outdoor_locations_val){
                                                               $outdoor_locations_title =  $user_obj->getTableValueByID('outdoor_workout_locations',$outdoor_locations_val);
                                                      ?>
                                                    <p>{{ isset($outdoor_locations_title) && $outdoor_locations_title != '' ? $outdoor_locations_title : ''}}</p>
                                                         <?php  } ?>
                                                </div>
                                            </div>
                                              <?php  } ?>
                                        </div>
                                        <div class="row">
                                             <?php  
                                              if(isset($trainer_basic_info[0]->personal_trainers) &&  $trainer_basic_info[0]->personal_trainers != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Personal Trainers/ Coaches</label>
                                                    <p>{{ $trainer_basic_info[0]->personal_trainers }}</p>
                                                </div>
                                            </div>
                                              <?php  }
                                              if(isset($trainer_basic_info[0]->medical_issues) &&  $trainer_basic_info[0]->medical_issues != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">             
                                                    <label class=" m-b-0">Medical Issues</label>
                                                    <p>{{ $trainer_basic_info[0]->medical_issues }}</p>
                                                </div>
                                            </div>
                                              <?php  } 
                                               if(isset($trainer_basic_info[0]->fitness_budget) &&  $trainer_basic_info[0]->fitness_budget != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Fitness Budget</label>
                                                    <p>{{ $trainer_basic_info[0]->fitness_budget }}</p>
                                                </div>
                                            </div>
                                              <?php  } ?>
                                        </div>
                                        
                                        <?php if($trainer_basic_info[0]->profile_id != 2 ) {
                                         if(isset($trainer_basic_info[0]->rate_description) &&  $trainer_basic_info[0]->rate_description != ''){ ?>
                                        <h4 class="font-size-15 m-b-0">Rate Description</h4>
                                        <p>{{  $trainer_basic_info[0]->rate_description }}</p>
                                        <?php }
                                        }
                                                } ?>
                                        <?php if($trainer_basic_info[0]->body_type != '' || $trainer_basic_info[0]->relationship != '' || $trainer_basic_info[0]->education != ''
                                                || $trainer_basic_info[0]->height != '' || $trainer_basic_info[0]->children != '' || $trainer_basic_info[0]->smokes != '' ||
                                                $trainer_basic_info[0]->ethnicity != '' || $trainer_basic_info[0]->occupation != '' || $trainer_basic_info[0]->drinks != '') { ?>
                                        <h4 class="font-size-15 m-b-20 m-t-30">Personal Info</h4>

                                        <div class="row">
                                            <?php  
                                            if(isset($trainer_basic_info[0]->body_type) &&  $trainer_basic_info[0]->body_type != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Body Type</label>
                                                    <p>{{ $trainer_basic_info[0]->body_type }}</p>
                                                </div>
                                            </div>
                                            <?php }
                                            if(isset($trainer_basic_info[0]->relationship) &&  $trainer_basic_info[0]->relationship != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">           
                                                    <label class=" m-b-0">Relationship</label>
                                                    <p>{{ $trainer_basic_info[0]->relationship }} </p>
                                                </div>
                                            </div>
                                             <?php }
                                            if(isset($trainer_basic_info[0]->education) &&  $trainer_basic_info[0]->education != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Education</label>
                                                    <p>  {{ $trainer_basic_info[0]->education }}    </p>
                                                </div>
                                            </div>
                                        </div>
                                            <?php } ?>             
                                        <div class="row">
                                             <?php 
                                            if(isset($trainer_basic_info[0]->height) &&  $trainer_basic_info[0]->height != ''){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Height</label>
                                                    <p> {{ $trainer_basic_info[0]->height }} </p>
                                                </div>
                                            </div>
                                             <?php }
                                             if(isset($trainer_basic_info[0]->children) &&  $trainer_basic_info[0]->children != ''){ ?>          
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Children</label>
                                                    <p>{{ isset($trainer_basic_info[0]->children) && $trainer_basic_info[0]->children != '' ?$trainer_basic_info[0]->children : ''}} </p>
                                                </div>
                                            </div> 
                                            <?php }
                                             if(isset($trainer_basic_info[0]->smokes) &&  $trainer_basic_info[0]->smokes != ''){ ?>     
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Smokes</label>
                                                    <p>{{ isset($trainer_basic_info[0]->smokes) && $trainer_basic_info[0]->smokes != '' ?$trainer_basic_info[0]->smokes : ''}}</p>
                                                </div>
                                            </div> 
                                             <?php  } ?>
                                        </div>
                                        <div class="row">
                                            <?php 
                                             if(isset($trainer_basic_info[0]->ethnicity) &&  $trainer_basic_info[0]->ethnicity != ''){ ?>     
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Ethnicity</label>
                                                    <p>{{ isset($trainer_basic_info[0]->ethnicity) && $trainer_basic_info[0]->ethnicity != '' ?$trainer_basic_info[0]->ethnicity : ''}}</p>
                                                </div> 
                                            </div>
                                            <?php }
                                             if(isset($trainer_basic_info[0]->occupation) &&  $trainer_basic_info[0]->occupation != ''){ ?> 
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Occupation</label>
                                                    <p>{{ isset($trainer_basic_info[0]->occupation) && $trainer_basic_info[0]->occupation != '' ?$trainer_basic_info[0]->occupation : ''}}</p>
                                                </div>
                                            </div> 
                                            <?php }
                                             if(isset($trainer_basic_info[0]->drinks) &&  $trainer_basic_info[0]->drinks != ''){ ?> 
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" m-b-0">Drinks</label>
                                                    <p>{{ isset($trainer_basic_info[0]->drinks) && $trainer_basic_info[0]->drinks != '' ?$trainer_basic_info[0]->drinks : ''}} </p>
                                                </div>
                                            </div>
                                             <?php  } 
                                                ?>
                                        </div>
                                    </div><!-- /.panel-body -->
                                </div><!-- /.panel -->
                                                <?php  } ?>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <?php 
                                             if(isset($trainer_basic_info[0]->about_me) &&  $trainer_basic_info[0]->about_me != ''){ ?> 
                                        <h4 class="font-size-15">About me</h4>
                                        <p>{{ $trainer_basic_info[0]->about_me}}</p>
                                             <?php } ?>
                                        <h4 class="font-size-15 m-t-20">What I&rsquo;m looking for</h4>
                                        <div class="m-b-10">
                                          <?php 
                                          
                                          $looking_tags_arr = explode('^',$trainer_basic_info[0]->looking_tags);
                                          if(!empty($looking_tags_arr)){
                                            foreach($looking_tags_arr as $looking_tags_val){
                                          ?>
                                            <a href="" class="btn btn-ghost btn-xs">{{ $looking_tags_val}}</a> &nbsp; 
                                          <?php }  }else{ ?>
                                            <a href="" class="btn btn-ghost btn-xs"></a> &nbsp; 
                                          <?php  } ?>
                                        </div>
                                           <?php 
                                             if(isset($trainer_basic_info[0]->look_up) &&  $trainer_basic_info[0]->look_up != ''){ ?> 
                                        <p>{{ $trainer_basic_info[0]->look_up }}</p>
                                             <?php  } ?>
                                    </div>
                                </div><!-- /.panel -->                                

                            </div>
                        </div>
                    </div>
                </div>
            </section>

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
                    <div class="emoji-icon-container inline-block"></div>
                </div>
                <button type="button" class="btn btn-primary btn-send-msg">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    function add_fav(trainer_id){
        $.ajax({
            url: "{{ url('User/AddFavorite') }}",
            type: 'POST',
            data: {
                trainer_id: trainer_id
            },
            success: function (data) {
                if (data == 1){
                    $("#favorite").addClass("icon-heart5");
                    $("#favorite").removeClass("icon-heart6");
                }
                if (data == 0){
                    $("#favorite").addClass("icon-heart6");
                    $("#favorite").removeClass("icon-heart5");
            }
         }
        });
    }
    
    $(function () {
                $('#search-people').keyup(function () {
                    var inputText = $(this).val();
                    if (inputText.length > 2) {
                        $('.contact-suggestion').show();
                    } else {
                        $('.contact-suggestion').hide();
                    }
                });

                $('.contact-suggestion li').click(function () {
                    var contactId = $(this).attr('data-contactId');
                    var title = $(this).find('.contact-info').children('span').text();

                    $('.selected-contact-list li.input-people-name').before('<li class="contact last">' + title + ' <a href="" class="remove-contact"><i class="icon-cross2"></i></a></li>');
                    $('.contact-suggestion').hide();
                    $('#search-people').val('').focus();
                });

                $('.selected-contacts').click(function () {
                    $(this).find('input[type=text]').focus();
                });

                $('.selected-contact-list').on('click', 'a.remove-contact', function (e) {
                    e.preventDefault();
                    $(this).parent('li').remove();
                });


                $('#message_body').pickMoji({
                    iconContainer: '.emoji-icon-container',
                    targetArea: 'message_body',
                    positionVertical: 'dropup', /* dropdown, dropup */
                    /*positionHorizontal: 'dropdown-menu-right',*/
                    pickerIcon: '<img src="images/icons/Icon/smile.svg" width="20" />'
                });

                $('#message_body').autogrow({
                    onInitialize: true,
                    animate: false
                });
            });
    
    
    </script>

@endsection