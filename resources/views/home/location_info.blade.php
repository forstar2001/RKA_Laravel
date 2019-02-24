@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
                <div class="content">
                    @include("home.myprofile_menu")                   
                    
                    <form class="m-t-40" action="{{url("/User/AddLocation")}}" method="POST" enctype="multipart/form-data">
                        @if (Session::has('msg'))
                            <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif

                        @if (isset($msg) && $msg!="")
                            <div class="alert alert-success">{{ $msg }}</div>
                        @endif

                        <?php 
                        if((isset($location_info) && !empty($location_info)))
                        {
                            if((isset($primary_location) && !empty($primary_location)))
                            {
                        ?>
                            <div class="panel panel-default map-list" id="map_div_<?php echo $primary_location[0]->id; ?>" style="background:linear-gradient(to right , rgba(255, 255, 255, 0.99), rgba(255, 255, 255, 0.88), rgba(255, 255, 255, 0.77), rgba(255, 255, 255, 0.55)), url('https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $primary_location[0]->latitude.','.$primary_location[0]->longitude; ?>&zoom=16&scale=2&size=640x200&maptype=roadmap&format=png&visual_refresh=true&key=AIzaSyBcBrT9JVZ-HRF-FH8TfYAozG67i6q1tUI')">
                                <div class="panel-body p-30">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-8">
                                            <h4 class='m-t-0'>Primary Location</h4>
                                            <p class='location-address'><svg viewBox="0 0 24 24"><use xlink:href="#location-outline"></use></svg> <?php echo(isset($primary_location[0]->location) && $primary_location[0]->location !="" ? $primary_location[0]->location : ''); ?></p>
                                        </div>
                                        <div class="col-xs-12 col-md-4 text-right-lg text-right-md">
                                            <a href="javascript:void(0)" class="icon-edit btn-circle" onclick="showEditDiv(<?php echo $primary_location[0]->id; ?>)"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default" style="display:none" id="edit_div_<?php echo $primary_location[0]->id; ?>">
                                <div class="panel-body p-30">
                                    <h4 class='m-t-0 m-b-20'>Edit Location</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group search-form p-0">                                                
                                                <input type="text" class="form-control" id="edit_loc_<?php echo $primary_location[0]->id; ?>" name="edit_location" value="{{ $primary_location[0]->location }}" onfocus="initAutocomplete(this.id)" required>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary text-uppercase" type="button" onclick="editLocation(<?php echo $primary_location[0]->id; ?>)">Update Location</button>
                                            <a href="javascript:void(0);" onclick="cancelUpdate(<?php echo $primary_location[0]->id; ?>)" class="btn btn-default text-uppercase">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            if((isset($secondary_location) && !empty($secondary_location)))
                            {
                                foreach($secondary_location as $secondary_loc)
                                {
                                    $imageMap = 'https://maps.googleapis.com/maps/api/staticmap?center='.$secondary_loc->latitude.','.$secondary_loc->longitude.'&zoom=13&scale=2&size=640x200&maptype=roadmap&format=png&visual_refresh=true&key=AIzaSyBcBrT9JVZ-HRF-FH8TfYAozG67i6q1tUI';
                            ?>
                            <div class="panel panel-default map-list" id="map_div_<?php echo $secondary_loc->id; ?>" style="background:linear-gradient(to right , rgba(255, 255, 255, 0.99), rgba(255, 255, 255, 0.88), rgba(255, 255, 255, 0.77), rgba(255, 255, 255, 0.55)), url('<?php echo $imageMap; ?>')">
                                <div class="panel-body p-30">
                                    
                                    <div class="row">
                                    
                                        <div class="col-xs-12 col-md-8">
                                            <h4 class='m-t-0'>Secondary Location</h4>                                    
                                                <p class='location-address'><svg viewBox="0 0 24 24"><use xlink:href="#location-outline"></use></svg>{{ $secondary_loc->location }}</p>
                                            </div>
                                        <div class="col-xs-12 col-md-4 text-right-lg text-right-md">
                                            <a href="{{ URL::to('User/SetPrimaryUserLocation/'.$secondary_loc->id.'/'.$user_details[0]->id) }}" class="btn btn-white">Set as Primary</a>
                                            <a href="{{ URL::to('User/DeleteLocation/'.$secondary_loc->id) }}" class="icon-delete btn-circle" onclick="return confirm('Are you sure you want to delete this Location?');"></a>
                                            <a href="javascript:void(0)" class="icon-edit btn-circle" onclick="showEditDiv(<?php echo $secondary_loc->id; ?>)"></a>
                                        </div>                                        
                                    </div>                                    
                                </div>
                            </div>
                            <div class="panel panel-default" style="display:none" id="edit_div_<?php echo $secondary_loc->id; ?>">
                                <div class="panel-body p-30">
                                    <h4 class='m-t-0 m-b-20'>Edit Location</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group search-form p-0">                                                
                                                <input type="text" class="form-control" id="edit_loc_<?php echo $secondary_loc->id; ?>" name="edit_location" value="{{ $secondary_loc->location }}" onfocus="initAutocomplete(this.id)" required>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary text-uppercase" type="button" onclick="editLocation(<?php echo $secondary_loc->id; ?>)">Update Location</button>
                                            <a href="javascript:void(0);" onclick="cancelUpdate(<?php echo $secondary_loc->id; ?>)" class="btn btn-default text-uppercase">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                                }
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger text-center">No Data Found !!!</div>';
                        }
                        ?>
                            <div class="panel panel-default">
                                <div class="panel-body p-30">
                                    <h4 class='m-t-0 m-b-20'>Add Location</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group search-form p-0">
                                                <input type="hidden" name="user_id" value="<?php echo $user_details[0]->id; ?>">
                                                <input type="text" class="form-control" id="loc_txt" name="location" onfocus="initAutocomplete(this.id)" required>
                                                <input type="hidden" name="state" id="administrative_area_level_1" value="">
                                                <input type="hidden" name="city" id="locality" value="">
                                                <input type="hidden" name="country" id="country" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary text-uppercase" type="submit">Save Location</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </section>

            
<script>
    function initAutocomplete(id) {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById(id)),
            {types: ['geocode']});
    }

    function showEditDiv(divId){
        $("#edit_div_"+divId).show();
        $("#map_div_"+divId).hide();
    }

    function cancelUpdate(divId){
        $("#edit_div_"+divId).hide();
        $("#map_div_"+divId).show();
    }
    
    function editLocation(locid){
        var location = $("#edit_loc_"+locid).val();
        $.ajax({
            url:'{{ url('User/EditLocation') }}',
            data:{"location_id":locid, "location":location},
            method:'POST',
            success:function(result)
            {
                if(result==1)
                {
                    //alert("Location Updated Successfully !!!");
                    window.location.href = '{{ url('User/LocationInfo/1') }}';
                }
                else
                {
                    alert("Location Updation Failed !!!");
                }
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&libraries=places" async defer></script>


@endsection
