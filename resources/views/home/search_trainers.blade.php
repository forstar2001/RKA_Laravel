<?php
if(!empty($all_user_details)){
foreach ($all_user_details as $val) { 
    ?>
    <a class="list" href="{{ url("/User/TrainerProfile/".$val->user_id) }}">
        <div class="trainer-img">
            <div class="profile-img">
                <?php
                    $prof_pic = url('/').'/public/default/images/demo-avatar.png';
                    if(isset($val->profile_picture) && $val->profile_picture!=""){
                        if (file_exists( public_path().'/uploads/user_profile_pictures/'.$val->profile_picture)) {
                            $prof_pic = url('/').'/public/uploads/user_profile_pictures/'.$val->profile_picture;
                        } 
                    }
                ?>
                <img src="{{ $prof_pic }}" alt="profile-pic">
            </div>
            <?php if($val->online_status == 1){  ?>
            <span class="online"></span>
            <?php  } else{ ?>
            <span ></span>
            <?php } ?>
        </div>
        <div class="profile-info">
            <div class="pull-right">
                <ul class="small-info">
                    <li>
                        <h5>{{ $val->trainer_distance }}Km</h5>
                        <p>nearby</p>
                    </li>
                    <li>
                        <?php if($val->rate != ''){ ?>
                        <h5>${{$val->rate}}</h5>
                        <p>per hour</p>
                        <?php }else{ ?>
                        <h5>  N/A</h5>
                        <p></p>
                        <?php } ?>
                    </li>
                </ul>
            </div>
            <h3 class="user-name"><?php echo $val->name; ?></h3>
            <p class="designation"><?php echo $val->profile_type; ?></p>
            <p class="address"><?php echo $val->primary_location; ?></p>
        </div>
    </a>
    <?php
 }
} else{ ?>
<div class='text-center text-danger alert alert-danger'> No trainers found or primary location is not added </div>
<?php    }
?>