@extends("layouts.user_dashboardlayout")
@section('content')
<?php  
use App\UserDetail;
$rate_obj = new UserDetail();?>
<section class="right-section" onload="getGeolocation()">
                <div class="right-section-content" >
                    <div class="welcome-text">
                        <h1>Hello {{ $user_details[0]->first_name }}!</h1>
                        <h5>Welcome to RKA Athletes. Let's find the best trainer for you</h5>
                    </div>
                    <div class="search">
                        <div class="search-result">
                            <div class="search-header">
                                <div class="row">
                                    <div class="col-sm-6 text-center-xs">
                                        <h4 class="header-title">{{ $user_details[0]->location }}</h4>
                                        <span class="result-info" id="user_count">About {{count($all_user_details)}} result</span>
                                    </div>
                                    <div class="col-sm-6 text-center-xs text-right-sm">
                                        <a href="" class="btn btn-default btn-toggle-mapview">Map</a>
                                        <a href="" class="btn btn-default btn-toggle-listview">List</a>
                                        <a href="#" class="filter-btn btn" id="show_filter"><span class="text pull-left">Filters</span></a>
                                    </div>
                                </div>
                            </div>
                            <form class="search-form" id="search_form">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-lg-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="loc_txt" name="location" placeholder="Search" onfocus="initAutocomplete(this.id)" required >
                                            <input type="hidden" name="user_id" value="<?php echo $user_details[0]->id ?>" id="user_id">
                                            <input type="hidden" id="lat" name="lat">
                                            <input type="hidden" id="lng" name="lng">
                                            <input type='hidden' id='profile_id' value=''>   
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-6">
                                        <div class="form-group">
                                            <select class="form-control" name="profile" id="profile" onchange="profSearch(this.value)">
                                             
                                            <option value="">Select Profile</option>
                                            <?php foreach($user_profiles as $val) { ?>
                                                <option value="{{ $val->id }}">{{ $val->profile }}</option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-6">
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Recently Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="search-body" id="search_trainers">
                                <?php  
                                if(!empty($all_user_details)){
                                foreach($all_user_details as $val)
                                {
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
                                                  <?php   $rate = $rate_obj->getRate($val->user_id) ;?>
                                                    <?php if($rate != ''){ ?>
                                                    <h5>${{$rate}}</h5>
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
                                  }else{ ?>
                                      <div class='text-center text-danger alert alert-danger'> No trainers found for your location </div>
                              <?php    }
                                ?>
                            </div>
                        </div>
                        <div class="search-filter">
                            @include("home.search_filter")
                        </div>
                    </div>

                <div id="map"></div>

            </section>
        <script>

            $(function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else { 
                    var x = "Geolocation is not supported by this browser.";
                }

            function showPosition(position) {
                    var latlng = position.coords.latitude+","+position.coords.longitude;
                    $.ajax({
                        url: "https://maps.googleapis.com/maps/api/geocode/json?latlng="+latlng+"&sensor=false&key=AIzaSyC5XKIfIhFlDrBNKBzGb617fRNtqHHbTYA",
                        data: {},
                        type: 'GET',
                        success: function (response) {
                            if(response.status=="OK"){
                                $.ajax({
                                    url: '{{ url('/User/UpdateCurrentLocation') }}', 
                                    data: {'location':response.results[0].formatted_address,'latlng':latlng},
                                    type: 'POST',
                                    success: function (response) {}
                                });
                            } else {
                                alert(response.error_message);
                            }
                        }
                    });
                }
            }); 
                
            function TrainerSearch(){
                var location = $("#loc_txt").val();
                var user_id = $("#user_id").val();
                var profile_id = $("#profile_id").val();
                
                if(location!=""){
                    $.ajax({
                        url: '{{ url('/User/TrainerSearch') }}', 
                        data: {'location':location,'user_id':user_id,'profile_id':profile_id},
                        type: 'post',
                        success: function (response) {                            
                            $('#search_trainers').html(response); 
                            var a = $('#search_trainers').find("a").length;
                            $("#user_count").html("About "+a+" result");
                            
                        }
                    });
                }
            }

            function profSearch(profile_id){
                    var location = $("#loc_txt").val();
                    var user_id = $("#user_id").val();
                    var profile = $("#profile_id").val(profile_id);
                    
                        $.ajax({
                            url: '{{ url('/User/TrainerSearch') }}', 
                            data: {'location':location,'user_id':user_id,'profile_id':profile_id},
                            type: 'post',
                            success: function (response) {
                                $('#search_trainers').html(response); 
                                var a = $('#search_trainers').find("a").length;
                                $("#user_count").html("About "+a+" result");
                            }
                        });
            }
      </script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&callback=initMap&libraries=places" async defer></script>

<script>    
            var center_lat = '<?php echo(isset($user_location[0]) && $user_location[0] != "")? $user_location[0]->latitude : '-33.91722' ?>';
            var center_lng = '<?php echo(isset($user_location[0]) && $user_location[0] != "")?$user_location[0]->longitude : '151.23064'?>';
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: parseFloat(center_lat), lng: parseFloat(center_lng)},
                    zoom: 12,
                    mapTypeControl: false
                });                
                
                var iconBase = '{{ url('/') }}/public/timthumb.php?src={{ url('/') }}/public/uploads/user_profile_pictures/';

                var icons = {
                    <?php 
                    if(!empty($all_user_details)){
                    foreach($all_user_details as $user_arr){ 

                        $prof_pic = url('/').'/public/timthumb.php?src='.url('/').'/public/default/images/demo-avatar.png';
                        if(isset($user_arr->profile_picture) && $user_arr->profile_picture!=""){
                            if (file_exists( public_path().'/uploads/user_profile_pictures/'.$user_arr->profile_picture)) {
                                $prof_pic = url('/').'/public/timthumb.php?src='.url('/').'/public/uploads/user_profile_pictures/'.$user_arr->profile_picture;
                            } 
                        }

                        $profile_picture = $prof_pic;
                        $name = $user_arr->name;
                    ?>
                    "<?php echo $name; ?>": {
                        icon: '<?php echo $profile_picture; ?>' + '&w=20&h=20'
                    },      
                    <?php } } ?>              
                };

                var features = [
                    <?php 
                    if(!empty($all_user_details)){
                    foreach($all_user_details as $user_arr){
                        $lat = $user_arr->latitude;
                        $lng = $user_arr->longitude;
                        $name = $user_arr->name;

                        $prof_pic = url('/').'/public/default/images/demo-avatar.png';
                        if(isset($user_arr->profile_picture) && $user_arr->profile_picture!=""){
                            if (file_exists( public_path().'/uploads/user_profile_pictures/'.$user_arr->profile_picture)) {
                                $prof_pic = url('/').'/public/timthumb.php?src='.url('/').'/public/uploads/user_profile_pictures/'.$user_arr->profile_picture;
                            } 
                        }

                        $image = $prof_pic;
                        $profile = $user_arr->profile_type;
                        $location = $user_arr->primary_location;
                        $distance = $user_arr->trainer_distance;
                        $profile_type = $user_arr->profile_type;
						$profile_id = $user_arr->user_id;
                    ?>                    
                    {
                        position: new google.maps.LatLng(parseFloat('<?php echo $lat; ?>'), parseFloat('<?php echo $lng; ?>')),
                        name:'<?php echo $name; ?>',
                        image:'<?php echo $image; ?>',
                        profile:'<?php echo $profile; ?>',
                        location:'<?php echo $location; ?>',
                        distance:'<?php echo $distance; ?>',
                        profile:'<?php echo $profile_type; ?>',
						profile_id:'<?php echo $profile_id; ?>',
						profile_link:'<?php echo url("/User/TrainerProfile/").'/'; ?>',
                    },
                    <?php } } ?>                    
                ];
                // Create markers.
                var myoverlay = new google.maps.OverlayView();
  

                features.forEach(function (feature) {
                    var marker = new google.maps.Marker({
                        position: feature.position,
                        icon: icons[feature.name].icon,
                        map: map
                    });
					
                    var contentString = '<div class="map-info trainer-list"><div class="user-img-div"><div class="rounded-avatar"><img src="'+feature.image+'" alt=""></div></div><div class="user-info text-center"><a href="'+feature.profile_link+feature.profile_id+'"><h3>'+feature.name+'</h3></a><p class="small-info">'+feature.location+'</p><p class="small-info">'+feature.profile+'</p></div><ul class="count-info"><li><h6>'+feature.distance+' km</h6><p>nearby</p></li><li><h6>$15.00</h6><p>per hour</p></li></ul></div>';

                    myoverlay.draw = function () {
                        //this assigns an id to the markerlayer Pane, so it can be referenced by CSS
                        this.getPanes().markerLayer.id='markerLayer'; 
                    };

                    google.maps.event.addListener(marker,'click',function() {
                        var infowindow = new google.maps.InfoWindow({
                        content: contentString
                        });
                    infowindow.open(map,marker);
                    });
                });
                
                myoverlay.setMap(map);    

            }

    function initAutocomplete(id) {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById(id)),
            {types: ['geocode']});

         autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            $("#lat").val(place.geometry.location.lat());
            $("#lng").val(place.geometry.location.lng());
            TrainerSearch();
        }        
    </script>
    
@endsection
