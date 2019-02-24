@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
                <div class="content">
                    @include("home.myprofile_menu")                   
                    <form class="m-t-40" action="{{url("/User/UpdateFitnessInfo")}}" method="POST" enctype="multipart/form-data">
                        @if (Session::has('msg'))
                            <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif 

                            <div class="panel panel-default">
                                <div class="panel-body p-30">
                                    <?php
                                    if($user_details[0]->profile_id!=2 && $user_details[0]->profile_id!=5)
                                    {
                                    $philosophy_label='Training Philosophy';
                                    if($user_details[0]->profile_id==4)
                                    $philosophy_label='Repair/ Recovery Philosophy';
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textarea">
                                                    <label class="control-label">{{ $philosophy_label }}</label>
                                                    <textarea class="form-control" name="training_philosophy" placeholder="{{ $philosophy_label }}" required><?php echo(isset($fitness_info[0]->training_philosophy) && $fitness_info[0]->training_philosophy!="")?$fitness_info[0]->training_philosophy:''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textarea">
                                                    <label class="control-label">Experience</label>
                                                    <textarea class="form-control" name="experience" placeholder="Experience" required><?php echo(isset($fitness_info[0]->experience) && $fitness_info[0]->experience!="") ? $fitness_info[0]->experience : ''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textbox animate">
                                                    <label class="control-label">Certifications</label>
                                                    <input class="form-control" placeholder="Certifications" type="text" value="<?php echo(isset($fitness_info[0]->certifications) && $fitness_info[0]->certifications!="") ? $fitness_info[0]->certifications : ''; ?>" name="certifications" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Group Workout Info and Location</label>
                                                    <?php
                                                        $workout_info_location = array();
                                                        if(isset($fitness_info[0]->workout_info_location))
                                                        {
                                                            $workout_info_location = explode('^',$fitness_info[0]->workout_info_location);
                                                        }
                                                    ?>
                                                    <select data-placeholder="Group Workout Info and Location" multiple="multiple" class="select" name="workout_info_location[]" required>
                                                        <option></option>
                                                        <?php foreach($group_workout_info_locations as $val) { ?>
                                                            <option value="{{ $val->id }}" <?php echo(in_array($val->id,$workout_info_location))?'selected':''; ?>>{{ $val->tag_title }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Fitness Level</label>
                                                    <select data-placeholder="Fitness Level" class="select" name="fitness_level" required>
                                                        <option value="" selected="">-- Select --</option>
                                                        <?php
                                                            $fitness_level = '';
                                                            if(isset($fitness_info[0]->fitness_level))
                                                            {
                                                                $fitness_level = $fitness_info[0]->fitness_level;
                                                            }
                                                        ?>
                                                         <?php foreach($fitness_level_arr as $key=>$val) { ?>
                                                        <option value="{{ $key }}" <?php if($key==$fitness_level) echo 'selected'?>>{{ $val }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textbox animate">
                                                    <label class="control-label">Fitness Goals</label>
                                                    <input class="form-control" placeholder="Fitness Goals" type="text" value="<?php echo(isset($fitness_info[0]->fitness_goals) && $fitness_info[0]->fitness_goals!="") ? $fitness_info[0]->fitness_goals : ''; ?>" name="fitness_goals" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Gym Membership</label>
                                                    <?php
                                                        $gym_membership = array();
                                                        if(isset($fitness_info[0]->gym_memberships))
                                                        {
                                                            $gym_membership = explode('^',$fitness_info[0]->gym_memberships);
                                                        }
                                                    ?>
                                                    <select data-placeholder="Gym Membership" multiple="multiple" class="select" name="gym_memberships[]" required>
                                                        <option></option>
                                                        <?php foreach($gym_memberships as $val) { ?>
                                                            <option value="{{ $val->id }}" <?php echo(in_array($val->id,$gym_membership))?'selected':''; ?>>{{ $val->tag_title }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                 <a class="help-block"><i class="info-icon"></i> Place help text info</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Outdoor Work-Out Locations</label>
                                                    <?php
                                                        $outdoor_location = array();
                                                        if(isset($fitness_info[0]->outdoor_locations))
                                                        {
                                                            $outdoor_location = explode('^',$fitness_info[0]->outdoor_locations);
                                                        }
                                                    ?>
                                                    <select data-placeholder="Outdoor Work-Out Locations" multiple="multiple" class="select" name="outdoor_locations[]" required>
                                                        <option></option>
                                                        <?php foreach($outdoor_workout_locations as $val) { ?>
                                                            <option value="{{ $val->id }}" <?php echo(in_array($val->id,$outdoor_location))?'selected':''; ?>>{{ $val->tag_title }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                
                                                <a class="help-block"><i class="info-icon"></i> Place help text info</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textarea">
                                                    <label class="control-label">Personal Trainers / Coaches</label>
                                                    <textarea class="form-control" name="personal_trainers" placeholder="Personal Trainers / Coaches" required><?php echo(isset($fitness_info[0]->personal_trainers) && $fitness_info[0]->personal_trainers!="") ? $fitness_info[0]->personal_trainers : ''; ?></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textbox animate">
                                                    <label class="control-label">Athletic Achievements</label>
                                                    <input class="form-control" placeholder="Athletic Achievements" type="text" value="<?php echo(isset($fitness_info[0]->athletic_achievements) && $fitness_info[0]->athletic_achievements!="") ? $fitness_info[0]->athletic_achievements : ''; ?>" name="athletic_achievements" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Scheduled Races</label>
                                                    <?php
                                                        $scheduled_race = array();
                                                        if(isset($fitness_info[0]->scheduled_races))
                                                        {
                                                            $scheduled_race = explode('^',$fitness_info[0]->scheduled_races);
                                                        }
                                                    ?>
                                                    <select data-placeholder="Scheduled Races" multiple="multiple" class="select" name="scheduled_races[]" required>
                                                        <option></option>
                                                        <?php foreach($scheduled_races as $val) { ?>
                                                            <option value="{{ $val->id }}" <?php echo(in_array($val->id,$scheduled_race))?'selected':''; ?>>{{ $val->tag_title }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <a class="help-block"><i class="info-icon"></i> Place help text info</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textbox animate">
                                                    <label class="control-label">Triathlon Club</label>
                                                    <input class="form-control" placeholder="Triathlon Club" type="text" value="<?php echo(isset($fitness_info[0]->triathlon_club) && $fitness_info[0]->triathlon_club!="") ? $fitness_info[0]->triathlon_club : ''; ?>" name="triathlon_club" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Avg. 1-mile swim time</label>
                                                    <select data-placeholder="Avg. 1-mile swim time" class="select" name="avg_swim_time" required>
                                                        <option value="" selected="">-- Select --</option>
                                                        <?php
                                                            $avg_swim_time = '';
                                                            if(isset($fitness_info[0]->avg_swim_time))
                                                            {
                                                                    $avg_swim_time = $fitness_info[0]->avg_swim_time;
                                                            }
                                                        ?>
                                                         <?php foreach($swim_time_arr as $key=>$val) { ?>
                                                        <option value="{{ $key }}" <?php if($key==$avg_swim_time) echo 'selected'?>>{{ $val }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Avg. mph bike speed</label>
                                                    <select data-placeholder="Avg. mph bike speed" class="select" name="avg_bike_speed" required>
                                                        <option value="" selected="">-- Select --</option>
                                                        <?php
                                                            $avg_bike_speed = '';
                                                            if(isset($fitness_info[0]->avg_bike_speed))
                                                            {
                                                                $avg_bike_speed = $fitness_info[0]->avg_bike_speed;
                                                            }
                                                        ?>
                                                         <?php foreach($bike_speed_arr as $key=>$val) { ?>
                                                        <option value="{{ $key }}" <?php if($key==$avg_bike_speed) echo 'selected'?>>{{ $val }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Avg. 1-mile run time</label>
                                                    <select data-placeholder="Avg. 1-mile run time" class="select" name="avg_run_time" required>
                                                        <option value="" selected="">-- Select --</option>
                                                        <?php
                                                            $avg_run_time = '';
                                                            if(isset($fitness_info[0]->avg_run_time))
                                                            {
                                                                $avg_run_time = $fitness_info[0]->avg_run_time;
                                                            }
                                                        ?>
                                                         <?php foreach($run_time_arr as $key=>$val) { ?>
                                                        <option value="{{ $key }}" <?php if($key==$avg_run_time) echo 'selected'?>>{{ $val }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
if($user_details[0]->profile_id==2 || $user_details[0]->profile_id == 5)
{
?>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textbox animate">
                                                    <label class="control-label">Medical Issues</label>
                                                    <input class="form-control" placeholder="Medical Issues" type="text" value="<?php echo(isset($fitness_info[0]->medical_issues) && $fitness_info[0]->medical_issues!="") ? $fitness_info[0]->medical_issues : ''; ?>" name="medical_issues" required>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
}
?>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="text-center-xs text-right-sm">
                                <input type="hidden" name="id" value="<?php echo $user_details[0]->id; ?>">
                                <input type="hidden" name="user_id" value="<?php echo(isset($fitness_info[0]->user_id) && $fitness_info[0]->user_id!="") ? $fitness_info[0]->user_id : ''; ?>">
                                <button class="btn btn-default text-uppercase" type="reset">Reset</button>
                                <button class="btn btn-primary text-uppercase" type="submit">Save Changes</button>
                            </div>
                        </form>

                </div>
            </section>

@endsection