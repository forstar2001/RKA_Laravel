
<ul>
    <?php foreach($private_photos as $private_pic){ 
        ?>
    <li style="background-image: url('{{ url('/') }}/public/uploads/user_private_photos/{{ $private_pic->profile_image }}');">
        <a href="{{ URL::to('User/DeletePhotos/'.$private_pic->id.'/'.$user_details[0]->id) }}" onclick="return confirm('Are you sure you want to delete this Photo?');"><i class="modal-close-icon"></i></a>
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

<script>
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

</script>