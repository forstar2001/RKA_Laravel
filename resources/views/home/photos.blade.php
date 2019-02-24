@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
                <div class="content">
                    @include("home.myprofile_menu")                   
                    <p id='msg'></p>
                  
                    <form class="m-t-40" id="form_id">
                        @if (Session::has('msg'))
                                <div class="alert alert-success">{{ Session::get('msg') }}</div>
                                @endif 
                            <h4 class="m-b-5 font-bold m-t-40">Photos</h4>
                             <input type="hidden" name="user_id" value="<?php echo $user_details[0]->id ?>">
                            <p class="pstyle1">Public photos that you add can be seen by all team members that visit your profile.</p>
                            <hr class="m-t-10">
                            <div class="panel panel-default" id='show_photos'>
                                <div class="panel-body p-30">
                                    <div class="panel-info-style">
                                        <div class="help-block d-i-b"><i class="info-icon"></i></div>
                                        <p class="pstyle1"> Photos need to be larger than 400px x
                                            400px and you should be in the photo. For personal trainers, clients need to see your 
                                            physique and how fit you are. Please, no nudity. Once uploaded, photos can take up 
                                            to 48 hours to be reviewed before they are visible on your profile. Read our photo help and guidelines.
                                        </p>
                                    </div>
                                    <div class="attached-files text-center" id="loaderPublicDiv" style="display:none">                                         
                                        <img src="{{ url('/').'/public/default/images/wait.gif' }}" alt="Please Wait...">
                                    </div>
                                    <div class="attached-files" id="publicPhoto" style="display:block">                                        
                                        <ul>
                                            <?php foreach($public_photos as $public_pic){ 
                                             ?>
                                            <li style="background-image: url('{{ url('/') }}/public/uploads/user_public_photos/{{ $public_pic->profile_image }}');">
                                                <a href="{{ URL::to('User/DeletePhotos/'.$public_pic->id.'/'.$data[0]->user_id) }}" onclick="return confirm('Are you sure you want to delete this Photo?');"><i class="modal-close-icon"></i></a>
                                            </li>
                                             <?php } ?> 
                                            <li>
                                                <div class="file is-boxed">
                                                    <label class="file-label">
                                                        <input class="file-input" type="file" name="public_photos[]" multiple id="public_photos">
                                                        <span class="file-cta">
                                                            <span class="file-icon">
                                                                <i class="add-file-icon"></i>
                                                            </span>
                                                            <span class="file-label">
                                                                Upload photos
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                        
                                    </div>
    
                                </div>
                            </div>
                            <h4 class="m-b-5 font-bold m-t-40">Private Photos</h4>
                            <p class="pstyle1">Private photo can only be seen by team members that you have shared access with.</p>
                            <hr class="m-t-10">                            
                            <div class="panel panel-default" id='show_private_photos'>
                                <div class="panel-body p-30">
                                    <div class="attached-files text-center" id="loaderPrivateDiv" style="display:none">                                         
                                        <img src="{{ url('/').'/public/default/images/wait.gif' }}" alt="Please Wait...">
                                    </div>
                                    <div class="attached-files" id="privatePhoto" style="display:block"> 
                                        <ul>
                                            <?php foreach($private_photos as $private_pic){ 
                                             ?>
                                            <li style="background-image: url('{{ url('/') }}/public/uploads/user_private_photos/{{ $private_pic->profile_image }}');">
                                                <a href="{{ URL::to('User/DeletePhotos/'.$private_pic->id.'/'.$data[0]->user_id) }}" onclick="return confirm('Are you sure you want to delete this Photo?');"><i class="modal-close-icon"></i></a>
                                            </li>
                                             <?php } ?> 
                                            <li>
                                                <div class="file is-boxed">
                                                    <label class="file-label">
                                                        <input class="file-input" type="file" name="private_photos[]" multiple id="private_photos">
                                                        <span class="file-cta">
                                                            <span class="file-icon">
                                                                <i class="add-file-icon"></i>
                                                            </span>
                                                            <span class="file-label">
                                                                Upload photos
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
    
                                </div>
                            </div>
                            {{-- <a href="#" class="pull-right m-t-20"><i class="add-file-blue-icon"></i> <span class=" p-l-10">Share Photo</span></a>
                            <h4 class="m-b-5 font-bold m-t-40">Who I’ve share with</h4>
                            <hr class="m-t-10">
                            <ul class="profile-list-small">
                                <li>
                                    <div class="profile-pic">
                                        <img src="images/buddy-avatar.jpg" alt="">
                                    </div>
                                    <div class="pro-info">
                                        <h4>Randy Schmidt</h4>
                                        <p>duane.jordan@gmail.com</p>
                                    </div>
                                    <a href="#" class="close-line"></a>
                                </li>
                                <li>
                                    <div class="profile-pic">
                                        <img src="images/img_bg.png" alt="">
                                    </div>
                                    <div class="pro-info">
                                        <h4>Bertha Rios</h4>
                                        <p>bertha.rios@gmail.com</p>
                                    </div>
                                    <a href="#" class="close-line"></a>
                                </li>
                                <li>
                                    <div class="profile-pic">
                                        <img src="images/demo-avatar.png" alt="">
                                    </div>
                                    <div class="pro-info">
                                        <h4>hannah.tyler@gmail.com</h4>
                                        <p>hannah.tyler@gmail.com</p>
                                    </div>
                                    <a href="#" class="close-line"></a>
                                </li>
                            </ul> --}}
                        </form>

                </div>
            </section>

            
<script>
    $(function () {
        $('#public_photos').on('change', function() {
                $("#publicPhoto").hide();
                $("#loaderPublicDiv").show();
           var formData = new FormData(document.getElementById('form_id'));
           $.ajax({
               url: '{{ url('/User/UploadPhotos') }}', 
               dataType: 'text', 
               cache: false,
               contentType: false,
               processData: false,
               data: formData,
               enctype:'multipart/form-data',
               cache: false,
               type: 'post',
               success: function (response) {
                   $("#loaderPublicDiv").hide();
                   $("#publicPhoto").show();                            
                   $('#publicPhoto').html(response); 
               }
           });    
       });

       $('#private_photos').on('change', function() {
            $("#privatePhoto").hide();
            $("#loaderPrivateDiv").show();
        var formData = new FormData(document.getElementById('form_id'));
        $.ajax({
               url: '{{ url('/User/UploadPrivatePhotos') }}', 
               dataType: 'text', 
               cache: false,
               contentType: false,
               processData: false,
               data: formData,
               enctype:'multipart/form-data',
               cache: false,
               type: 'post',
               success: function (response) {
                   $("#loaderPrivateDiv").hide();
                   $("#privatePhoto").show();   
                   $('#privatePhoto').html(response); 
               }
           });
       });
       
    });
</script>
@endsection
