<?php 
$option_data = array(
    'Photos' => 'Photos',
    'Scheduled Races' => 'Scheduled Races',
    'Achievements' => 'Achievements',
    'Gym Memberships' => 'Gym Memberships',
    'Outdoor Work-Out Location' => 'Outdoor Work-Out Location',
    'Premium' => 'Premium',
    'Unviewed' => 'Unviewed',
    'Viewed Me' => 'Viewed Me',
    'Favorited Me' => 'Favorited Me',
    'Background Check' => 'Background Check',
    'Viewed' => 'Viewed',
    'Favorited' => 'Favorited'
); 

$education_arr = array(
    'High School'=>'High School',
    'Some College'=>'Some College',
    'Asociates Degree'=>'Associates Degree',
    'Bachelors Degree'=>'Bachelors Degree',
    'Graduate Degree'=>'Graduate Degree',
    'PhD / Post Doctoral'=>'PhD / Post Doctoral'
);

$children_arr = array(
    '0'=>'0',
    '1'=>'1',
    '2'=>'2',
    '3'=>'3',
    '4'=>'4',
    '5'=>'5',
    '6+'=>'6+'
);

$language_arr = array(
    'English'=>'English',
    'Espanol'=>'Espanol',
    'Francais'=>'Francais',
    'Deutsch'=>'Deutsch',
    'Chinese symbols'=>'Chinese symbols',
    'Japanese symbols'=>'Japanese symbols',
    'Nederlandse'=>'Nederlandse',
    'Portugues'=>'Portugues'
);

$looking_for_arr = array(
    'Runner' => 'Runner',
    "10k runner"=>"10k runner",
    "Marathoner"=>"Marathoner",
    "Bicyclist"=>"Bicyclist",
    "Triathlete"=>"Triathlete",
    "Tough Mudder competitor"=>"Tough Mudder competitor",
    "Orange Theory Fitness fanatic"=>"Orange Theory Fitness fanatic",
    "WYCrossFit member"=>"CrossFit member"
);
?>

<div class="search-filter-scrollbar">
        <form id="search_filter" name="search_filter">
    <div class="p-15 clearfix">
        <a href="javascript:void(0)" class="pull-right m-t-15 filter-close"><span><svg viewBox="0 0 24 24"><use xlink:href="#close"></use></svg></span></a>
        <h4 class="header-title m-t-15 pull-left">Filters <span class="bullet"></span></h4>
        <a href="javascript:void(0)" class="pull-left m-t-15  font-size-13">Clear all</a>
    </div>
    <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#Options" class="colapse-link clearfix">
                <h5 class="header-title  pull-left">Options <span class="bullet"></span></h5>
            <span  class="pull-left   font-size-13">{{ count($option_data) }}</span>
            </a>
        </div>
        <div id="Options" class="label-set-content collapse in">
            @foreach($option_data as $option)
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" value="{{ $option }}" name="option[]">
                    <span class="checkmark"></span><span>{{ $option }}</span>
                </label>
            </div>
            @endforeach
            {{-- <div id="more-option" class="collapse">
                <div class="checkbox checkbox-custom">
                    <label>
                        <input type="checkbox" >
                        <span class="checkmark"></span><span>Unviewed</span>
                    </label>
                </div>
            </div>
            <span  class="link-show btn p-0" data-toggle="collapse" data-target="#more-option"><span><svg viewBox="0 0 24 24"><use xlink:href="#plus"></use></svg></span> Show all</span> --}}
        </div>
    </div>
    <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#Gender" class="colapse-link clearfix collapsed">
                <h5 class="header-title  pull-left">Gender</h5>
            </a>
        </div>
        <div id="Gender" class="label-set-content collapse">
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" id="male" value="Male" name="gender[]">
                    <span class="checkmark"></span><span>Male</span>
                </label>
            </div>
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" id="female" value="Female" name="gender[]">
                    <span class="checkmark"></span><span>Female</span>
                </label>
            </div>
        </div>
    </div>
    <div class="label-set">
            <div class="label-set-header clearfix">
                <a href="javascript:void(0)" data-toggle="collapse" data-target="#UserType" class="colapse-link clearfix collapsed">
                    <h5 class="header-title  pull-left">User Type</h5>
                </a>
            </div>
            <div id="UserType" class="label-set-content collapse">
                <?php foreach($user_profiles as $val) { ?>
                    <div class="checkbox checkbox-custom">
                        <label>
                            <input type="checkbox" id="{{ $val->profile }}" value="{{ $val->id }}" name="user_type[]">
                            <span class="checkmark"></span><span>{{ $val->profile }}</span>
                        </label>
                    </div>
                <?php } ?>                
            </div>
        </div>

    <div class="list-other clearfix">
        <a href="javascript:void(0)" class="pull-right"><span><svg viewBox="0 0 24 24"><use xlink:href="#lock"></use></svg></span></a>
        <h4> Body Type</h4>
    </div>
    <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#Age" class="colapse-link clearfix collapsed">
                <h5 class="header-title  pull-left">Age</h5>
            </a>
        </div>
        <div id="Age" class="label-set-content collapse">
            <input type="text" id="range_age" value="" name="age" />
        </div>
    </div>
        <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#height" class="colapse-link clearfix collapsed">
                <h5 class="header-title  pull-left">Height</h5>
            </a>
        </div>
        <div id="height" class="label-set-content collapse">
            <input type="text" id="range_height" value="" name="height" />
        </div>
    </div>
    <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#smoking" class="colapse-link clearfix collapsed">
                <h5 class="header-title  pull-left">Smoking</h5>
            </a>
        </div>
        <div id="smoking" class="label-set-content collapse">
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="smoking[]" value="Non Smoker">
                    <span class="checkmark"></span><span>Non Smoker</span>
                </label>
            </div>
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="smoking[]" value="Light Smoker">
                    <span class="checkmark"></span><span>Light Smoker</span>
                </label>
            </div>
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="smoking[]" value="Heavy Smoker">
                    <span class="checkmark"></span><span>Heavy Smoker</span>
                </label>
            </div>
        </div>
    </div>
    <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#drinking" class="colapse-link clearfix collapsed">
                <h5 class="header-title  pull-left">Drinking</h5>
            </a>
        </div>
        <div id="drinking" class="label-set-content collapse">
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="drinking[]" value="Non Drinker">
                    <span class="checkmark"></span><span>Non Drinker</span>
                </label>
            </div>
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="drinking[]" value="Social Drinker">
                    <span class="checkmark"></span><span>Social Drinker</span>
                </label>
            </div>
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="drinking[]" value="Heavy Drinker">
                    <span class="checkmark"></span><span>Heavy Drinker</span>
                </label>
            </div>
        </div>
    </div>
    <div class="list-other clearfix">
        <a href="javascript:void(0)" class="pull-right"><span><svg viewBox="0 0 24 24"><use xlink:href="#lock"></use></svg></span></a>
        <h4> Relationship Status</h4>
    </div>
    
    <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#education" class="colapse-link clearfix collapsed">
                <h5 class="header-title  pull-left">Education</h5>
            </a>
        </div>
        <div id="education" class="label-set-content collapse">
            <?php foreach ($education_arr as $key => $value)
            {
            ?>
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="education[]" value="<?php echo $value; ?>">
                    <span class="checkmark"></span><span><?php echo $value; ?></span>
                </label>
            </div>
            <?php
            } 
            ?>
        </div>
    </div>
    
    <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#children" class="colapse-link clearfix collapsed">
                <h5 class="header-title  pull-left">Children</h5>
            </a>
        </div>
        <div id="children" class="label-set-content collapse">
            <?php foreach ($children_arr as $key => $value)
            {
            ?>
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="children[]" value="<?php echo $value; ?>">
                    <span class="checkmark"></span><span><?php echo $value; ?></span>
                </label>
            </div>
            <?php
            } 
            ?>
        </div>
    </div>
    
    <div class="label-set">
        <div class="label-set-header clearfix">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#language" class="colapse-link clearfix collapsed">
                <h5 class="header-title  pull-left">Language</h5>
            </a>
        </div>
        <div id="language" class="label-set-content collapse">
            <?php foreach ($language_arr as $key => $value)
            {
            ?>
            <div class="checkbox checkbox-custom">
                <label>
                    <input type="checkbox" name="language[]" value="<?php echo $value; ?>">
                    <span class="checkmark"></span><span><?php echo $value; ?></span>
                </label>
            </div>
            <?php
            } 
            ?>
        </div>
    </div>
    
    <div class="list-other clearfix">
        <a href="javascript:void(0)" class="pull-right"><span><svg viewBox="0 0 24 24"><use xlink:href="#lock"></use></svg></span></a>
        <h4> Income</h4>
    </div>
    <div class="list-other clearfix">
        <a href="javascript:void(0)" class="pull-right"><span><svg viewBox="0 0 24 24"><use xlink:href="#lock"></use></svg></span></a>
        <h4> Net Worth</h4>
    </div>
    <div class="list-other clearfix">
        <a href="javascript:void(0)" class="pull-right"><span><svg viewBox="0 0 24 24"><use xlink:href="#lock"></use></svg></span></a>
        <h4> Lifestyle</h4>
    </div>
    <div class="label-set">
            <div class="label-set-header clearfix">
                <a href="javascript:void(0)" data-toggle="collapse" data-target="#Allowance" class="colapse-link clearfix collapsed">
                    <h5 class="header-title  pull-left">Allowance Expectations</h5>
                </a>
            </div>
            <div id="Allowance" class="label-set-content collapse">
                <div class="checkbox checkbox-custom">
                    <label>
                        <input type="checkbox" value="Yes" name="allowance[]">
                        <span class="checkmark"></span><span>Yes</span>
                    </label>
                </div>
                <div class="checkbox checkbox-custom">
                    <label>
                        <input type="checkbox" value="No" name="allowance[]">
                        <span class="checkmark"></span><span>No</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="label-set">
            <div class="label-set-header clearfix">
                <a href="javascript:void(0)" data-toggle="collapse" data-target="#Rate" class="colapse-link clearfix collapsed">
                    <h5 class="header-title  pull-left">Rates</h5>
                </a>
            </div>
            <div id="Rate" class="label-set-content collapse">        
                <input type="text" id="range_rate" value="" name="rate" />
            </div>
        </div>
        <div class="label-set">
                <div class="label-set-header clearfix">
                    <a href="javascript:void(0)" data-toggle="collapse" data-target="#looking_for" class="colapse-link clearfix collapsed">
                        <h5 class="header-title  pull-left">Show Members looking for</h5>
                    </a>
                </div>
                <div id="looking_for" class="label-set-content collapse">   
                    @foreach($looking_for_arr as $looking_for)
                    <div class="checkbox checkbox-custom">
                        <label>
                            <input type="checkbox" value="{{ $looking_for }}" name="looking_for[]">
                            <span class="checkmark"></span><span>{{ $looking_for }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="label-set">
                    <div class="label-set-header clearfix">
                        <a href="javascript:void(0)" data-toggle="collapse" data-target="#dont_looking_for" class="colapse-link clearfix collapsed">
                            <h5 class="header-title  pull-left">Don't Show Members looking for</h5>
                        </a>
                    </div>
                    <div id="dont_looking_for" class="label-set-content collapse"> 
                        @foreach($looking_for_arr as $looking_for)
                        <div class="checkbox checkbox-custom">
                            <label>
                                <input type="checkbox" value="{{ $looking_for }}" name="dont_looking_for[]">
                                <span class="checkmark"></span><span>{{ $looking_for }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="list-other clearfix">
                        <a href="javascript:void(0)" class="pull-right"><span><svg viewBox="0 0 24 24"><use xlink:href="#lock"></use></svg></span></a>
                        <h4> Profile Text</h4>
                    </div>
                <div class="label-set">
                        <div class="label-set-header clearfix">
                                <a href="javascript:void(0)" data-toggle="collapse" data-target="#fitness_goal" class="colapse-link clearfix collapsed">
                                        <h5 class="header-title  pull-left">Fitness Goal Text</h5>
                                    </a>
                        </div>
                        <div id="fitness_goal" class="label-set-content collapse">        
                            <input type="text" id="" value="" name="fitness_goal"/>
                        </div>
                    </div>
                    <div class="label-set">                             
                            <button id="search_btn" type="button">Search</button>
                            <a href="javascript:void(0)"><span>Reset All</span></a>
                        </div>
                    </div>
                    
</form>
</div>


<script>
$('#search_btn').click(function(){
    var form_data = $("#search_filter").serialize();
    $.ajax({
        url: '{{ url('/User/SearchFilter') }}', 
        data: form_data,
        type: 'post',
        success: function (response) {
            alert(response);
        }
    });
});
</script>

