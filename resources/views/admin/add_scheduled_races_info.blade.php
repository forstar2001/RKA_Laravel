@extends('layouts.adminlayout')
@section('title')
{{ $title }}
@endsection

@section('content_header')

<h1>
    {{ $title }}
    
</h1>
@endsection
@section('content')
{!!Form::open(array('url' => '/Admin/AddScheduledRacesInfoAction', 'method' => 'post','enctype' => 'multipart/form-data'))!!}

<!-- general form elements -->
<div class="box box-default">
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Title</label>
                    <div class="row"> 
                        <div class="col-md-12"> 
                            <input type="text" class="form-control" name="title" required/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <div class="row">  
                        <div class="col-md-12">
                            <textarea class="form-control" name="description" required></textarea>                          
                        </div>                          
                    </div>
                </div>                          
            </div>
        </div>
    </div><!-- /.box-body -->

    <div class="box-footer">
        {!!Form::submit("Save",array("class"=>"btn bg-blue-custom"))!!}
        <a class="btn btn-default bg-blue-custom" href="{{ route('ScheduledRacesInfo') }}">Cancel</a>
    </div>
</div>



{!!Form::token()!!}
{!!Form::close()!!}
@endsection
