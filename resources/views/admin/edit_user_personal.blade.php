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

{!!Form::open(array('url' => '/Admin/EditUserPersonal', 'method' => 'post','enctype' => 'multipart/form-data'))!!}

<!-- general form elements -->
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Personal Info</h3>
    </div><!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">
                <ul class="nav nav-tabs">
                  <li><a href="{{ URL::to($tab1_url) }}">Basic Info</a></li>
                  <li><a href="{{ URL::to($tab2_url) }}">Fitness Info</a></li>
                  <li class="active"><a href="{{ URL::to($tab3_url) }}">Personal Info</a></li>
                  <li><a href="{{ URL::to($tab4_url) }}">Photos</a></li>
                  <li><a href="{{ URL::to($tab5_url) }}">Location Info</a></li>
                  <li><a href="{{ URL::to($tab6_url) }}">User Description</a></li>
                </ul>
                <br>
                <input type="hidden" name="redirect_url" value="{{ $tab3_url }}">
<?php
if(!empty($data))
{
?>        
        
        <div class="row">

            <div class="col-md-6">

                <b><h4>Appearance</h4></b>
                <hr>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("height","Height")!!}
                        <br>
                        {!! Form::select('height', $height_arr, $data[0]->height, ['class' => 'form-control']) !!}
                        @if($errors->has('height'))
                        {!!$errors->first('height') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("body_type","Body Type")!!}
                        <br>
                        {!! Form::select('body_type', $body_type_arr, $data[0]->body_type, ['class' => 'form-control']) !!}
                        @if($errors->has('body_type'))
                        {!!$errors->first('body_type') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("ethnicity","Ethnicity")!!}
                        <br>
                        {!! Form::select('ethnicity', $ethnicity_arr, $data[0]->ethnicity, ['class' => 'form-control']) !!}
                        @if($errors->has('ethnicity'))
                        {!!$errors->first('ethnicity') !!}
                        @endif
                    </div>                                         
                </div>

                <br><b><h4>Personal Information</h4></b>
                <hr>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("occupation","Occupation")!!}
                        {!!Form::text("occupation",$data[0]->occupation,array("required"=>"required","maxlength"=>255,"placeholder"=>"Enter Occupation","class"=>"form-control"))!!}
                        @if($errors->has('occupation'))
                        {!!$errors->first('occupation') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("education","Education")!!}
                        <br>
                        {!! Form::select('education', $education_arr, $data[0]->education, ['class' => 'form-control']) !!}
                        @if($errors->has('education'))
                        {!!$errors->first('education') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("relationship","Relationship")!!}
                        <br>
                        {!! Form::select('relationship', $relationship_arr, $data[0]->relationship, ['class' => 'form-control']) !!}
                        @if($errors->has('relationship'))
                        {!!$errors->first('relationship') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("children","Children")!!}
                        <br>
                        {!! Form::select('children', $children_arr, $data[0]->children, ['class' => 'form-control']) !!}
                        @if($errors->has('children'))
                        {!!$errors->first('children') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("smokes","Smoking")!!}
                        <br>
                        {!! Form::select('smokes', $smoking_arr, $data[0]->smokes, ['class' => 'form-control']) !!}
                        @if($errors->has('smokes'))
                        {!!$errors->first('smokes') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("drinks","Drinking")!!}
                        <br>
                        {!! Form::select('drinks', $drinking_arr, $data[0]->drinks, ['class' => 'form-control']) !!}
                        @if($errors->has('drinks'))
                        {!!$errors->first('drinks') !!}
                        @endif
                    </div>                                         
                </div>

                <div class="form-group">
                    <div class="input text required">
                        {!!Form::label("language","Language")!!}
                        <br>
                        {!! Form::select('language', $language_arr, $data[0]->language, ['class' => 'form-control']) !!}
                        @if($errors->has('language'))
                        {!!$errors->first('language') !!}
                        @endif
                    </div>                                         
                </div>

            </div>

        </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
        <input type="hidden" name="id" value="<?php echo $data[0]->user_id ?>">
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