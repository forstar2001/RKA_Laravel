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

{!!Form::open(array('url' => '/Admin/EditUserDescription', 'method' => 'post','enctype' => 'multipart/form-data'))!!}

<!-- general form elements -->
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">User Description</h3>
    </div><!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">
                <ul class="nav nav-tabs">
                  <li><a href="{{ URL::to($tab1_url) }}">Basic Info</a></li>
                  <li><a href="{{ URL::to($tab2_url) }}">Fitness Info</a></li>
                  <li><a href="{{ URL::to($tab3_url) }}">Personal Info</a></li>
                  <li><a href="{{ URL::to($tab4_url) }}">Photos</a></li>
                  <li><a href="{{ URL::to($tab5_url) }}">Location Info</a></li>
                  <li class="active"><a href="{{ URL::to($tab6_url) }}">User Description</a></li>
                </ul>
                <br>
<?php
if(!empty($data))
{
?>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="user_id" value="{{ $data[0]->user_id }}">
                <input type="hidden" name="redirect_url" value="{{ $tab6_url }}">
                <div class="form-group">
                    
                        <label>About Me</label>
                        <div class="row">  
                            <div class="col-md-12">
                            <textarea name="about_me" class="form-control" required>{{ $data[0]->about_me }}</textarea>                          
                            </div>                          
                        </div>
                </div>
                <div class="form-group">
                    <label>Describe What You're Looking For</label>
                    <div class="row">  
                            <div class="col-md-12">
                            <textarea name="look_up" class="form-control" required>{{ $data[0]->look_up }}</textarea>                          
                            </div>                          
                    </div>
                </div>
                <div class="form-group">
                    <label>What I'm Looking for</label>
                    <?php 
                    $looking_for = explode('|',$data[0]->looking_for);
                    ?>
                    <select class="form-control select2" multiple="multiple" data-placeholder="What I'm Looking for"
                            style="width: 100%;" name="looking_for[]" required>
                            <?php foreach($looking_for_tags as $key => $tag) { ?>
                                <option value="{{ $key }}" <?php echo(in_array($tag,$looking_for))?'selected':''; ?>>{{ $tag }}</option>
                            <?php } ?>
                    </select>
                </div>              

            </div>

        </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
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
