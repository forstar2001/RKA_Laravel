<p>
Hello {{ $data['name'] }},<br><br>

Please click on the following link to activate your profile.<br>
<a href="{{ route('UserVerifyStatus', ['user_id' => base64_encode($data['user_id'])]) }}"><strong>Activate Your Profile</strong></a><br><br>

With Regards,<br>
RKA Admin
</p>

