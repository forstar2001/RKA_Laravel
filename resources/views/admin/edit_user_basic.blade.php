@extends('layouts.adminlayout')

@section('title')
{{ $title }}
@endsection

@section('content_header')
<?php
    $tab1_url = 'Admin/EditUser/' . $data[0]->id.'/1';
    $tab2_url = 'Admin/EditUser/' . $data[0]->id.'/2';
    $tab3_url = 'Admin/EditUser/' . $data[0]->id.'/3';
    $tab4_url = 'Admin/EditUser/' . $data[0]->id.'/4';
    $tab5_url = 'Admin/EditUser/' . $data[0]->id.'/5';
    $tab6_url = 'Admin/EditUser/' . $data[0]->id.'/6';
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

{!!Form::open(array('url' => '/Admin/EditUserBasic', 'method' => 'post','enctype' => 'multipart/form-data'))!!}

<!-- general form elements -->
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Basic Info</h3>
    </div><!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="{{ URL::to($tab1_url) }}">Basic Info</a></li>
                  <li><a href="{{ URL::to($tab2_url) }}">Fitness Info</a></li>
                  <li><a href="{{ URL::to($tab3_url) }}">Personal Info</a></li>
                  <li><a href="{{ URL::to($tab4_url) }}">Photos</a></li>
                  <li><a href="{{ URL::to($tab5_url) }}">Location Info</a></li>
                  <li><a href="{{ URL::to($tab6_url) }}">User Description</a></li>
                </ul>
                <br>

        <div class="row">

            <div class="col-md-6">

                <b><h4>Basic Information</h4></b>
                <hr>
                <input type="hidden" name="redirect_url" value="{{ $tab1_url }}">
                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("first_name","Full Name")!!}
                        {!!Form::text("first_name",$data[0]->first_name,array("required"=>"required","maxlength"=>255,"placeholder"=>"Enter Full Name","class"=>"form-control"))!!}
                        @if($errors->has('first_name'))
                        {!!$errors->first('first_name') !!}
                        @endif
                    </div>                                         
                </div>

                {{-- <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("last_name","Last Name")!!}
                        {!!Form::text("last_name",$data[0]->last_name,array("required"=>"required","maxlength"=>255,"placeholder"=>"Enter Last Name","class"=>"form-control"))!!}
                        @if($errors->has('last_name'))
                        {!!$errors->first('last_name') !!}
                        @endif
                    </div>                                         
                </div> --}}

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("username","User Name")!!}
                        {!!Form::text("username",$data[0]->username,array("required"=>"required","maxlength"=>255,"placeholder"=>"User Name","class"=>"form-control"))!!}
                        @if($errors->has('username'))
                        {!!$errors->first('username') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("about_me","Heading")!!}
                        {!!Form::textArea("profile_heading",$data[0]->profile_heading,array("required"=>"required","maxlength"=>255,"placeholder"=>"About User","class"=>"form-control"))!!}
                        @if($errors->has('about_me'))
                        {!!$errors->first('about_me') !!}
                        @endif
                    </div>                                         
                </div>
				
				<div class="form-group">
                    <div class="input text required">                       
                        {!!Form::label("date_of_birth","Date of Birth")!!}
                        <input required="required" maxlength="255" placeholder="Enter Date of Birth" class="form-control" name="date_of_birth" value={{$data[0]->date_of_birth}} id="date_of_birth" type="date">
                        @if($errors->has('date_of_birth'))
                        {!!$errors->first('date_of_birth') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("gender","Gender")!!}
                        <br>
                        <?php
                        if($data[0]->gender!='')
                        $data[0]->gender=array_search($data[0]->gender, array('Male','Female'));
                        ?>
                        {!! Form::select('gender', array('Male','Female'), $data[0]->gender, ['class' => 'form-control']) !!}
                        @if($errors->has('gender'))
                        {!!$errors->first('gender') !!}
                        @endif
                    </div>                                         
                </div>
<!--
                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("looking_tags","Looking For")!!}
                        <br>
                        <?php
                        ?>
                        {!! Form::select('looking_tags', $looking_for_arr, $data[0]->looking_tags, ['class' => 'form-control']) !!}
                        @if($errors->has('looking_tags'))
                        {!!$errors->first('looking_tags') !!}
                        @endif
                    </div>                                         
                </div>
-->

<div class="form-group">
{!!Form::label("looking_tags","Looking For")!!}
                <div class="checkbox">
                <?php
                $looking_tags_arr=explode('^',$data[0]->looking_tags);
                foreach($looking_for_arr as $looking_for_val)
                {
                ?>
                        <label>
                        <?php
                        if(in_array($looking_for_val,$looking_tags_arr))
                        {
                        ?>
                          <input type="checkbox" name="looking_tags[<?php echo $looking_for_val; ?>]" checked="checked">
                        <?php
                        }
                        else
                        {
                        ?>
                        <input type="checkbox" name="looking_tags[<?php echo $looking_for_val; ?>]">
                        <?php
                        }
                        ?>
                          {{$looking_for_val}}
                        </label>
                <?php
                }
                ?>
                      </div>
</div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("video_link","Video")!!}
                        {!!Form::text("video_link",$data[0]->video_link,array("maxlength"=>255,"placeholder"=>"Paste the link to your YouTube video here","class"=>"form-control"))!!}
                        @if($errors->has('video_link'))
                        {!!$errors->first('video_link') !!}
                        @endif
                    </div>                                         
                </div>

                <br><b><h4>Financial Information</h4></b>
                <hr>
<?php
if($data[0]->profile_id==2 || $data[0]->profile_id==5)
{
?>
                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("fitness_budget","Fitness Budget")!!}
                        <br>
                        <?php
                        ?>
                        {!! Form::select('fitness_budget', $fitness_budget_arr, $data[0]->fitness_budget, ['class' => 'form-control']) !!}
                        @if($errors->has('fitness_budget'))
                        {!!$errors->first('fitness_budget') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("allowance_expectations","Allowance Expectations")!!}
                        <br>
                        <?php
                        ?>
                        {!! Form::select('allowance_expectations', $allowance_expectations_arr, $data[0]->allowance_expectations, ['class' => 'form-control']) !!}
                        @if($errors->has('allowance_expectations'))
                        {!!$errors->first('allowance_expectations') !!}
                        @endif
                    </div>                                         
                </div>
<?php
}
?>

<?php
if($data[0]->profile_id==3 || $data[0]->profile_id==4)
{
?>
                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("rate_expectations","Rate Expectations")!!}
                        <br>
                        <?php
                        ?>
                        {!! Form::select('rate_expectations', $rate_expectation_arr, $data[0]->rate_expectations, ['class' => 'form-control', 'onChange' => 'selectRate();']) !!}
                        @if($errors->has('rate_expectations'))
                        {!!$errors->first('rate_expectations') !!}
                        @endif
                    </div>                                         
                </div>

<?php
if($data[0]->rate_expectations=='Negotiable Rates (I don\'t have a set rate)' || $data[0]->rate_expectations=='')
{
?>
                <div class="form-group" id="rate_amount" style="display:none;">
<?php
}
else
{
?>
                <div class="form-group" id="rate_amount">
<?php
}
?>
                    <div class="input text required">
                        {!!Form::label("rate","Rate $")!!}
                        {!!Form::text("rate",$data[0]->rate,array("required"=>"required","maxlength"=>255,"placeholder"=>"Enter Rate","class"=>"form-control"))!!}
                        @if($errors->has('rate'))
                        {!!$errors->first('rate') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("rate_description","Rate Description")!!}
                        {!!Form::text("rate_description",$data[0]->rate_description,array("required"=>"required","maxlength"=>255,"placeholder"=>"Enter Rate Description","class"=>"form-control"))!!}
                        @if($errors->has('rate_description'))
                        {!!$errors->first('rate_description') !!}
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
        <input type="hidden" name="id" value="<?php echo $data[0]->id ?>">
        {!!Form::submit("Save",array("class"=>"btn bg-blue-custom"))!!}
        <a class="btn btn-default bg-blue-custom" href="{{ URL::to('AdminHome') }}">Cancel</a>
    </div>


</div><!-- /.box -->

{!!Form::token()!!}
{!!Form::close()!!}
@endsection

<script>
function selectRate()
{
    if($('#rate_expectations').val()!='Negotiable Rates (I don\'t have a set rate)')
    $('#rate_amount').show();
    else
    $('#rate_amount').hide();
}
</script>