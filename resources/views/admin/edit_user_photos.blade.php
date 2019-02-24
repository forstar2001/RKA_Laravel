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

{!!Form::open(array('url' => '/Admin/EditUserPhotos', 'method' => 'post','enctype' => 'multipart/form-data'))!!}

<!-- general form elements -->
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Photos</h3>
    </div><!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">
                <ul class="nav nav-tabs">
                  <li><a href="{{ URL::to($tab1_url) }}">Basic Info</a></li>
                  <li><a href="{{ URL::to($tab2_url) }}">Fitness Info</a></li>
                  <li><a href="{{ URL::to($tab3_url) }}">Personal Info</a></li>
                  <li class="active"><a href="{{ URL::to($tab4_url) }}">Photos</a></li>
                  <li><a href="{{ URL::to($tab5_url) }}">Location Info</a></li>
                  <li><a href="{{ URL::to($tab6_url) }}">User Description</a></li>
                </ul>
                <br>
                <input type="hidden" name="redirect_url" value="{{ $tab4_url }}">
<?php
if(!empty($data))
{
?>        
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" name="user_id" value="{{ $data[0]->user_id }}">
                <div class="form-group">
                        <h3>Public Photos</h3>
                        <div class="row">                            
                            <?php foreach($photos['public_photos'] as $public_pic){ 
                                ?>
                                    <div class="col-md-3">
                                    <img src="{{ url('/').'/public/uploads/user_public_photos/'.$public_pic->profile_image }}" height="60" width="90">
                                    <a href="{{ URL::to('Admin/DeleteUserPhoto/'.$public_pic->id.'/'.$data[0]->user_id) }}" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this Photo?');" class="text-muted"><i class="fa fa-trash-o fa-lg"></i></a>
                                    </div>
                            <?php } ?>                            
                        </div>
                </div>
                <div class="form-group">
                        <div class="row">
                        <div class="col-md-12">
                            <input type="file" name="public_photos[]" multiple class="form-control"/>
                        </div>
                        </div>                                     
                </div>

                <div class="form-group">
                    <h3>Private Photos</h3>
                    <div class="row">                            
                            <?php foreach($photos['private_photos'] as $private_pic){ ?>
                                    <div class="col-md-3">
                                    <img src="{{ url('/').'/public/uploads/user_private_photos/'.$private_pic->profile_image }}" height="60" width="90">
                                    <a href="{{ URL::to('Admin/DeleteUserPhoto/'.$private_pic->id.'/'.$data[0]->user_id) }}" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this Photo?');" class="text-muted"><i class="fa fa-trash-o fa-lg"></i></a>
                                    </div>
                            <?php } ?>                            
                        </div>
                </div>
                <div class="form-group">
                        <div class="row">
                        <div class="col-md-12">
                            <input type="file" name="private_photos[]" multiple class="form-control"/>
                        </div>
                        </div>                                      
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