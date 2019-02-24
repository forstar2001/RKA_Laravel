@extends('layouts.adminlayout')

@section('title')
{{ $title }}
@endsection

@section('content_header')
<?php
    $tab1_url = 'Admin/EditUser/' . $id.'/1';
    $tab2_url = 'Admin/EditUser/' . $id.'/2';
    $tab3_url = 'Admin/EditUser/' . $id.'/3';
    $tab4_url = 'Admin/EditUser/' . $id.'/4';
    $tab5_url = 'Admin/EditUser/' . $id.'/5';
    $tab6_url = 'Admin/EditUser/' . $id.'/6';
    ?>
<h1>
    {{ $title }}
    <a class="btn btn-default pull-right" href="{{ URL::to('AdminHome') }}">
    Back
    </a>    
</h1>
@endsection
@section('content')

@if(Session::has("global"))
{!!Session::get("global")!!}
@endif

{!!Form::open(array('url' => '/Admin/EditUserFitness', 'method' => 'post','enctype' => 'multipart/form-data'))!!}

<!-- general form elements -->
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Fitness Info</h3>
    </div><!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">
                <ul class="nav nav-tabs">
                  <li><a href="{{ URL::to($tab1_url) }}">Basic Info</a></li>
                  <li class="active"><a href="{{ URL::to($tab2_url) }}">Fitness Info</a></li>
                  <li><a href="{{ URL::to($tab3_url) }}">Personal Info</a></li>
                  <li><a href="{{ URL::to($tab4_url) }}">Photos</a></li>
                  <li><a href="{{ URL::to($tab5_url) }}">Location Info</a></li>
                  <li><a href="{{ URL::to($tab6_url) }}">User Description</a></li>
                </ul>
                <br>
<?php
if(!empty($data))
{
?>
        <div class="row">

            <div class="col-md-6">

<?php
if($data[0]->profile_id!=2 && $data[0]->profile_id!=5)
{
$philosophy_label='Training Philosophy';
if($data[0]->profile_id==4)
$philosophy_label='Repair/ Recovery Philosophy';
?>
                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("training_philosophy",$philosophy_label)!!}
                        {!!Form::textArea("training_philosophy",$data[0]->training_philosophy,array("maxlength"=>255,"placeholder"=>"Enter $philosophy_label","class"=>"form-control"))!!}
                        @if($errors->has('training_philosophy'))
                        {!!$errors->first('training_philosophy') !!}
                        @endif
                    </div>                                         
                </div>   
                
                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("experience","Experience")!!}
                        {!!Form::textArea("experience",$data[0]->experience,array("required"=>"required","maxlength"=>255,"placeholder"=>"Enter Experience","class"=>"form-control"))!!}
                        @if($errors->has('experience'))
                        {!!$errors->first('experience') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("certifications","Certifications")!!}
                        {!!Form::text("certifications",$data[0]->certifications,array("required"=>"required","maxlength"=>255,"placeholder"=>"Enter Certifications","class"=>"form-control"))!!}
                        @if($errors->has('certifications'))
                        {!!$errors->first('certifications') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        <label>Group Workout Info And Location</label>
                        <?php 
                        $workout_info_location = explode('^',$data[0]->workout_info_location);
                        ?>
                        <select class="form-control select2" multiple="multiple" data-placeholder="Group Workout Info And Location"
                                style="width: 100%;" name="workout_info_location[]" required>
                                <?php foreach($dropdown_values['group_workout_info_locations'] as $tags) { ?>
                                    <option value="{{ $tags->id }}" <?php echo(in_array($tags->id,$workout_info_location))?'selected':''; ?>>{{ $tags->tag_title }}</option>
                                <?php } ?>
                        </select>
                    </div>                                         
                </div>

<?php
}
?>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("fitness_level","Fitness Level")!!}
                        <br>
                        {!! Form::select('fitness_level', $fitness_level_arr, $data[0]->fitness_level, ['class' => 'form-control']) !!}
                        @if($errors->has('fitness_level'))
                        {!!$errors->first('fitness_level') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("fitness_goals","Fitness Goals")!!}
                        {!!Form::text("fitness_goals",$data[0]->fitness_goals,array("required"=>"required","maxlength"=>255,"placeholder"=>"Enter Fitness Goals","class"=>"form-control"))!!}
                        @if($errors->has('fitness_goals'))
                        {!!$errors->first('fitness_goals') !!}
                        @endif
                    </div>                                         
                </div>

                <!-- <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("gym_memberships","Gym Memberships")!!}
                        {!!Form::text("gym_memberships",$data[0]->gym_memberships,array("maxlength"=>255,"placeholder"=>"Enter Gym Memberships","class"=>"form-control"))!!}
                        @if($errors->has('gym_memberships'))
                        {!!$errors->first('gym_memberships') !!}
                        @endif
                    </div>                                         
                </div> -->
                <div class="form-group">
                    <div class="input text required">
                        <label>Gym Memberships</label>
                        <?php 
                        $gym_memberships = explode('^',$data[0]->gym_memberships);
                        ?>
                        <select class="form-control select2" multiple="multiple" data-placeholder="Gym Memberships"
                                style="width: 100%;" name="gym_memberships[]" required>
                                <?php foreach($dropdown_values['gym_memberships'] as $tags) { ?>
                                    <option value="{{ $tags->id }}" <?php echo(in_array($tags->id,$gym_memberships))?'selected':''; ?>>{{ $tags->tag_title }}</option>
                                <?php } ?>
                        </select>
                    </div>                                         
                </div>

                <!-- <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("outdoor_locations","Outdoor Work-Out Locations")!!}
                        {!!Form::text("outdoor_locations",$data[0]->outdoor_locations,array("maxlength"=>255,"placeholder"=>"Enter Outdoor Locations","class"=>"form-control"))!!}
                        @if($errors->has('outdoor_locations'))
                        {!!$errors->first('outdoor_locations') !!}
                        @endif
                    </div>                                         
                </div> -->

                <div class="form-group">
                    <div class="input text required">
                        <label>Outdoor Work-Out Locations</label>
                        <?php 
                        $outdoor_locations = explode('^',$data[0]->outdoor_locations);
                        ?>
                        <select class="form-control select2" multiple="multiple" data-placeholder="Outdoor Work-Out Locations"
                                style="width: 100%;" name="outdoor_locations[]" required>
                                <?php foreach($dropdown_values['outdoor_workout_locations'] as $tags) { ?>
                                    <option value="{{ $tags->id }}" <?php echo(in_array($tags->id,$outdoor_locations))?'selected':''; ?>>{{ $tags->tag_title }}</option>
                                <?php } ?>
                        </select>
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("personal_trainers","Personal Trainers/ Coaches")!!}
                        {!!Form::textArea("personal_trainers",$data[0]->personal_trainers,array("maxlength"=>255,"placeholder"=>"Enter Personal Trainers","class"=>"form-control"))!!}
                        @if($errors->has('personal_trainers'))
                        {!!$errors->first('personal_trainers') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("athletic_achievements","Athletic Achievements")!!}
                        {!!Form::text("athletic_achievements",$data[0]->athletic_achievements,array("maxlength"=>255,"placeholder"=>"Enter Athletic Achievements","class"=>"form-control"))!!}
                        @if($errors->has('athletic_achievements'))
                        {!!$errors->first('athletic_achievements') !!}
                        @endif
                    </div>                                         
                </div>

                <!-- <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("scheduled_races","Scheduled Races")!!}
                        {!!Form::text("scheduled_races",$data[0]->scheduled_races,array("maxlength"=>255,"placeholder"=>"Enter Scheduled Races","class"=>"form-control"))!!}
                        @if($errors->has('scheduled_races'))
                        {!!$errors->first('scheduled_races') !!}
                        @endif
                    </div>                                         
                </div> -->

                <div class="form-group">
                    <div class="input text required">
                        <label>Scheduled Races</label>
                        <?php 
                        $scheduled_races = explode('^',$data[0]->scheduled_races);
                        ?>
                        <select class="form-control select2" multiple="multiple" data-placeholder="Scheduled Races"
                                style="width: 100%;" name="scheduled_races[]" required>
                                <?php foreach($dropdown_values['scheduled_races'] as $tags) { ?>
                                    <option value="{{ $tags->id }}" <?php echo(in_array($tags->id,$scheduled_races))?'selected':''; ?>>{{ $tags->tag_title }}</option>
                                <?php } ?>
                        </select>
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("triathlon_club","Triathlon Club")!!}
                        {!!Form::text("triathlon_club",$data[0]->triathlon_club,array("maxlength"=>255,"placeholder"=>"Enter Triathlon Club","class"=>"form-control"))!!}
                        @if($errors->has('triathlon_club'))
                        {!!$errors->first('triathlon_club') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("avg_swim_time","Avg. 1-mile swim time")!!}
                        <br>
                        {!! Form::select('avg_swim_time', $swim_time_arr, $data[0]->avg_swim_time, ['class' => 'form-control']) !!}
                        @if($errors->has('avg_swim_time'))
                        {!!$errors->first('avg_swim_time') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("avg_bike_speed","Avg. mph bike speed")!!}
                        <br>
                        {!! Form::select('avg_bike_speed', $bike_speed_arr, $data[0]->avg_bike_speed, ['class' => 'form-control']) !!}
                        @if($errors->has('avg_bike_speed'))
                        {!!$errors->first('avg_bike_speed') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("avg_run_time","Avg. 1-mile run time")!!}
                        <br>
                        {!! Form::select('avg_run_time', $run_time_arr, $data[0]->avg_run_time, ['class' => 'form-control']) !!}
                        @if($errors->has('avg_run_time'))
                        {!!$errors->first('avg_run_time') !!}
                        @endif
                    </div>                                         
                </div>
<?php
if($data[0]->profile_id==2 || $data[0]->profile_id!=5)
{
?>
                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("medical_issues","Medical Issues")!!}
                        {!!Form::text("medical_issues",$data[0]->medical_issues,array("maxlength"=>255,"placeholder"=>"Enter Medical Issues","class"=>"form-control"))!!}
                        @if($errors->has('medical_issues'))
                        {!!$errors->first('medical_issues') !!}
                        @endif
                    </div>                                         
                </div>
<?php
}
?>

            </div>

        </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
        <input type="hidden" name="id" value="<?php echo $data[0]->user_id ?>">
        <input type="hidden" name="redirect_url" value="{{ $tab2_url }}">
        {!!Form::submit("Save",array("class"=>"btn bg-blue-custom"))!!}
        <a class="btn btn-default bg-blue-custom" href="{{ URL::to('AdminHome') }}">Cancel</a>
    </div>
<?php
}
?>

</div><!-- /.box -->

{!!Form::token()!!}
{!!Form::close()!!}

@endsection