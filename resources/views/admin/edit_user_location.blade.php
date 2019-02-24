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

{!!Form::open(array('url' => '/Admin/EditUserLocation', 'method' => 'post','enctype' => 'multipart/form-data'))!!}

<!-- general form elements -->
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Location Info</h3>
    </div><!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">
                <ul class="nav nav-tabs">
                  <li><a href="{{ URL::to($tab1_url) }}">Basic Info</a></li>
                  <li><a href="{{ URL::to($tab2_url) }}">Fitness Info</a></li>
                  <li><a href="{{ URL::to($tab3_url) }}">Personal Info</a></li>
                  <li><a href="{{ URL::to($tab4_url) }}">Photos</a></li>
                  <li class="active"><a href="{{ URL::to($tab5_url) }}">Location Info</a></li>
                  <li><a href="{{ URL::to($tab6_url) }}">User Description</a></li>
                </ul>
                <br>

        <input type="hidden" name="redirect_url" value="{{ $tab5_url }}">
<?php
if(!empty($data))
{
?> 
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="user_id" value="{{ $data[0]->user_id }}">
                <div class="form-group">
                        <h3>Primary Location</h3>
                        <div class="row">  
                            <div class="col-md-12">
                            <h4>{{ $location['primary_location'][0]->location }}</h4>                            
                            </div>                          
                        </div>
                </div>

                <div class="form-group">
                    <h3>Secondary Locations</h3>
                    <div class="row">                            
                            <?php foreach($location['secondary_location'] as $secondary_loc){ ?>
                                    <div class="col-md-12">
                                    <h4>
                                    {{ $secondary_loc->location }}
                                    <a href="{{ URL::to('Admin/DeleteUserLocation/'.$secondary_loc->id.'/'.$data[0]->user_id) }}" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this Location?');" class="text-muted"><i class="fa fa-trash-o fa-lg"></i></a>
                                    <a href="{{ URL::to('Admin/SetPrimaryUserLocation/'.$secondary_loc->id.'/'.$data[0]->user_id) }}" title="Set as Primary Location" class="text-muted"><i class="fa fa-thumb-tack fa-lg"></i></a>    
                                    </h4>
                                    </div>
                            <?php } ?>                            
                        </div>
                </div>
                <div class="form-group">
                        <div class="row">
                        <div class="col-md-12">
                            <h3>Add Location</h3>
                <input type="text" class="form-control" id="loc_txt" name="location" onfocus="initAutocomplete(this.id)" required>
                <input type="hidden" name="state" id="administrative_area_level_1" value="">
                <input type="hidden" name="city" id="locality" value="">
                <input type="hidden" name="country" id="country" value="">
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

<script type="text/javascript">
        var componentForm = {
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
        };
        var total_location="";
        function initAutocomplete(id) {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById(id)),
                {types: ['geocode']});
                
            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
           // alert(a);
            document.getElementById(id).removeAttr('placeholder');
            //alert(a);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();            
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    $("#" + addressType).val(val);
                   total_location=total_location+val;
                }
            }
        }
        </script>
        
         <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&libraries=places" async defer></script>