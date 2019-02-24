@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
    <div class="content">
        @include("home.myprofile_menu")

        <form action="{{url("/User/UpdateBasicProfile")}}" id="form_val_id" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="m-t-40">
                @if (Session::has('msg'))
                <div class="alert alert-success">{{ Session::get('msg') }}</div>
                @endif                            
                <div class="panel panel-default">
                    <div class="panel-body p-30 text-center" id="loaderDiv" style="display:none">                                         
                        <img src="{{ url('/').'/public/default/images/wait.gif' }}" alt="Please Wait...">
                    </div>
                    <div class="panel-body p-30" id="photoDiv" style="display:block">
                        <div class="row m-b-30">
                            <div class="col-xs-12 col-sm-3 col-md-2 text-center-xs text-center-sm" id="show_avter_pic">
                                <?php
                                    $prof_pic = url('/').'/public/default/images/demo-avatar.png';
                                    if(isset($user_details[0]->profile_picture) && $user_details[0]->profile_picture!=""){
                                        if (file_exists( public_path().'/uploads/user_profile_pictures/'.$user_details[0]->profile_picture)) {
                                            $prof_pic = url('/').'/public/uploads/user_profile_pictures/'.$user_details[0]->profile_picture;
                                        } 
                                    }
                                ?>
                                <div class="custom-rounded-avatar inline-block" style="background-image: url('{{ $prof_pic }}');">
                                    <div class="icon-edit btn-circle">
                                        <input type="file" class="upload" name="avter_pic" id="profile_picture">
                                        <input type="hidden" name="x1"  id="x1" value="" >
                                        <input type="hidden" name="y1"  id="y1" value="" >
                                        <input type="hidden" name="width"  id="width" value="" >
                                        <input type="hidden" name="height"  id="height" value="" >
                                        <input type="hidden" name="imgPreviewHeight" id="imgHeight" />
                                        <input type="hidden" name="imgPreviewWidth" id="imgWidth" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-9 col-md-4 p-t-20">
                                <div class="m-t-15 m-b-5 clearfix">
                                     <label class="show font-bold ">Profile complete <span class="pull-right">{{ $profile_complete }}%</span></label>

                                    <p>Complete your profile for better search results</p>
                                </div>
                                <div class="progress profile-progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $profile_complete }}"
                                         aria-valuemin="0" aria-valuemax="100" style="width:{{ $profile_complete }}%">
                                        <span class="sr-only">{{ $profile_complete }}% Complete</span>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material textbox animate">
                                        <label class="control-label">Full Name</label>
                                        <input class="form-control" placeholder="Full Name" type="text" value="{{$user_details[0]->first_name }}" name="first_name" required>
                                    </div>
                                </div>
                            </div>         --}}
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material textbox animate">
                                        <label class="control-label">User Name</label>
                                        <input class="form-control" placeholder="User Name" type="text" value="{{$user_details[0]->first_name }}" name="first_name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material date-input is-visible">
                                        <label class="control-label">Date of Birth</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" placeholder="Date of Birth" value="<?php echo (isset($user_details[0]->date_of_birth) && $user_details[0]->date_of_birth != '') ? $user_details[0]->date_of_birth : '' ?>" name="date_of_birth" required>
                                            <span class="input-group-addon"><i class="calendar-icon"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                                                                   
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material select-input">
                                        <label class="control-label">Gender</label>
                                        <select data-placeholder="Gender" class="select" name="gender" required>
                                            <option value="Male" <?php echo ($user_details[0]->gender == 'Male') ? 'selected' : '' ?>>Male</option>
                                            <option value="Female" <?php echo ($user_details[0]->gender == 'Female') ? 'selected' : '' ?>>Female</option>
                                            {{-- <option value="Other">Other</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material textbox animate">
                                        <label class="control-label">Video</label>
                                        <input class="form-control" placeholder="Paste your YouTube video link" type="text" value="{{$user_details[0]->video_link }}" name="video_link" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material textarea">
                                        <label class="control-label">Add a short summary of yourself that will grab a member’s attention</label>
                                        <textarea class="form-control" placeholder="Add a short summary of yourself that will grab a member’s attention" name="profile_heading" required><?php echo (isset($user_details[0]->profile_heading) && $user_details[0]->profile_heading != '') ? $user_details[0]->profile_heading : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <h4 class="m-b-30 font-bold m-t-40 text-left-lg  text-left-md text-center-sm ">Looking for:</h4>
                        <ul class="custom-radio-form-inline chec-radio p-b-0 clearfix">
                            <?php
                                             
                            $looking_tags_arr = explode('^', $user_details[0]->looking_tags);
                            foreach ($looking_for_arr as $looking_for_val) {
                                ?>
                                <li class="pz">
                                    <label class="radio-inline">
                                        <?php
                                        if (in_array($looking_for_val, $looking_tags_arr)) {
                                            ?>                                                
                                            <input type="checkbox" checked="" id="look_<?php echo $looking_for_val; ?>"  name="looking_tags[<?php echo $looking_for_val; ?>]" class="pro-chx <?php echo($looking_for_val!="All")?'chkbox':''; ?>" value="<?php echo $looking_for_val; ?>">
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" id="look_<?php echo $looking_for_val; ?>" name="looking_tags[<?php echo $looking_for_val; ?>]" class="pro-chx <?php echo($looking_for_val!="All")?'chkbox':''; ?>" value='<?php echo $looking_for_val; ?>'>
                                            <?php
                                        }
                                        ?>
                                        <span class="clab">
                                            {{$looking_for_val}}
                                        </span>
                                    </label>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>                                    
                    </div>
                </div>

                <h4 class="m-b-0 font-bold m-t-40">Financial Information</h4>
                <hr class="m-t-10">
                <div class="panel panel-default">
                    <div class="panel-body p-30">
                        <?php
                        if ($user_details[0]->profile_id == 2 || $user_details[0]->profile_id == 5) {
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <div class="form-group-material select-input">
                                            <label class="control-label">Fitness Budget</label>
                                            <?php
                                            $fitness_arr = explode('^', $user_details[0]->fitness_budget);
                                            ?>

                                            <select data-placeholder="Single Select" class="select" name="fitness_budget" required>
                                                <?php
                                                foreach ($fitness_budget_arr as $fitness_budget_val) {
                                                    ?>
                                                    <option value="<?php echo $fitness_budget_val; ?>" <?php echo in_array($fitness_budget_val, $fitness_arr) ? 'selected' : ''; ?>> {{$fitness_budget_val}}</option>

    <?php } ?>
                                            </select>

                                        </div>
                                        <div class="help-block"><i class="info-icon"></i> What I'm Willing to Pay</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <div class="form-group-material select-input">
                                            <label class="control-label">Allowance Expectations</label>
    <?php
    $allowance_arr = explode('^', $user_details[0]->allowance_expectations);
    ?>

                                            <select data-placeholder="Single Select" class="select" name="allowance_expectations" required>
    <?php
    foreach ($allowance_expectations_arr as $allowance_expectations_val) {
        ?>
                                                    <option value="<?php echo $allowance_expectations_val; ?>" <?php echo in_array($allowance_expectations_val, $allowance_arr) ? 'selected' : ''; ?>> {{$allowance_expectations_val}}</option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="help-block"><i class="info-icon"></i> What I'm Willing to Pay</div>
                                    </div>
                                </div>
    <?php
}
?>

                            <?php
                            if ($user_details[0]->profile_id == 3 || $user_details[0]->profile_id == 4) {
                                ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-group-material select-input">
                                                <label class="control-label">Rate Expectations</label>
                                                <?php
                                                $rate_arr = explode('^', $user_details[0]->rate_expectations);
                                                ?>

                                                <select data-placeholder="Single Select" class="select" name="rate_expectations" required onChange='selectRate()' id="rate_expectations">
                                                {{-- <option value=""></option> --}}
                                                <?php
                                                foreach ($rate_expectation_arr as $rate_expectation_val) {
                                                    ?>
                                                        <option value="<?php echo $rate_expectation_val; ?>" <?php echo in_array($rate_expectation_val, $rate_arr) ? 'selected' : ''; ?>> {{$rate_expectation_val}}</option>

                                                    <?php } ?>
                                                </select>
                                            </div>                                       
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            <div class="form-group">

                                                <div class="form-group-material textbox animate">
                                                    <label class="control-label">Rate Description</label>
                                                    <input class="form-control" placeholder="Enter Rate Description" type="text" value="{{$user_details[0]->rate_description }}" name="rate_description" required>
                                                </div>

                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        <?php
                                        if ($user_details[0]->rate_expectations == 'Negotiable Rates (I don\'t have a set rate)' || $user_details[0]->rate_expectations == '') {
                                        ?>
                                            <div class="form-group" id="rate_amount" style="display:none;">
                                            <?php
                                                } else {
                                            ?>
                                            <div class="form-group" id="rate_amount">
                                            <?php
                                            }
                                            ?>
                                            <div class="form-group-material textbox animate">
                                                <label class="control-label">Rate $</label>
                                                <input class="form-control" placeholder="Enter Rate" type="text" value="{{$user_details[0]->rate }}" name="rate">
                                            </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <?php
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <input type="hidden" name="id" value="<?php echo $user_details[0]->id ?>">
                        <button class="btn btn-default text-uppercase" type="reset">Reset</button>
                        <button class="btn btn-primary text-uppercase" type="submit">Save Changes</button>
                    </div>
                </div>
        </form>

    </div>
</section>

<div id="cropModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form id='form_val'>
            <div class="modal-content styled-modal" >
                <div class="modal-header">
                    <h4 class="modal-title">Crop Your Avatar</h4>
                </div>
                <div class="modal-body p-30">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="img-preview-wrapper">
                                    <img src="" alt="" class="img-responsive" id="img-preview"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" id="cropper_close_btn">DONE</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function imagePreview(input) {

        if (input.files && input.files[0]) {
            var _URL = window.URL || window.webkitURL;

            var img = new Image();

            img.onload = function () {
                var width = this.width;
                var height = this.height;
                var field_id = "#" + $(input).attr('id');
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-preview').attr('src', e.target.result);
                    $('#img-preview').imgAreaSelect({
                        aspectRatio: '1:1',
                        handles: true,
                        onSelectEnd: function (obj, selection) {
                            $("#x1").val(selection.x1);
                            $("#y1").val(selection.y1);
                            $("#width").val(selection.width);
                            $("#height").val(selection.height);
                        }
                    });

                }

                reader.readAsDataURL(input.files[0]);
            };
            img.src = _URL.createObjectURL(input.files[0]);
        }
    }

    $(document).ready(function () {

        $('#look_All').on('click',function(){
            if(this.checked){
                $('.pro-chx').each(function(){
                    this.checked = true;
                });
            }else{
                $('.pro-chx').each(function(){
                    this.checked = false;
                });
            }
        });
        
        $('.chkbox').on('click',function(){
            if($('.chkbox:checked').length == $('.chkbox').length){
                $('#look_All').prop('checked',true);
            }else{
                $('#look_All').prop('checked',false);
            }
        });


        $("#profile_picture").change(function () {
            $("#cropModal").modal('show');
            imagePreview(this);
        });

        $('#cropModal').on('hidden.bs.modal', function () {
            $('img#img-preview').imgAreaSelect({remove: true});
        });

        $('#cropper_close_btn').click(function(){
                $('#imgWidth').val($('.img-preview-wrapper').width());
                $('#imgHeight').val($('.img-preview-wrapper').height());
                $("#photoDiv").hide();
                $("#loaderDiv").show();
                var formData = new FormData(document.getElementById('form_val_id'));
                $.ajax({
                url: '{{ url('/User/UploadProfilePhotos') }}',
                        dataType: 'text',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        enctype:'multipart/form-data',
                        cache: false,
                        type: 'post',
                        success: function (response) {
                        if (response == 1)
                                window.location.href = '{{ url('/User/BasicProfile') }}';
                        }
                });
            }
        );
    });


    function selectRate()
    {
        if ($('#rate_expectations').val() != 'Negotiable Rates (I don\'t have a set rate)')
            $('#rate_amount').show();
        else
            $('#rate_amount').hide();
    }
</script>

@endsection
