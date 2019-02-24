@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
        <div class="content">
            @include("home.account_settings_menu")
            <form class="m-t-40" action="{{url("/User/UpdateAccountSettings")}}" method="POST" enctype="multipart/form-data">
                    @if (Session::has('msg'))
                        <div class="alert alert-success">{{ Session::get('msg') }}</div>
                    @endif 
                <div class="panel panel-default">
                    <div class="panel-body p-30">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material textbox animate">
                                        <label class="control-label">Email</label>
                                        <input class="form-control" name="user_name" value="{{ $user_details[0]->username }}" placeholder="Email" type="text" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-t-15">
                                <label> Password</label>
                                <a href="javascript:void(0)" class="btn btn-primary m-l-15" data-toggle="modal" data-target="#change_password">Change password</a>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h4 class="m-b-5 font-bold">Secret questions</h4>
                                    <p>Security questions wil be used for your password recovery if you forgot password and cannot access your email.</p>
                                    
                                    <label class="radio-inline custom-radio"><input name="secutiry_question" type="radio" <?php if($user_details[0]->secret_qus_ans==1) echo 'checked'?> id="secutiry_question_enable" value="1"><span></span> Enable</label>
                                    <label class="radio-inline custom-radio"><input name="secutiry_question" <?php if($user_details[0]->secret_qus_ans==0) echo 'checked'?> id="secutiry_question_disable" value="0" type="radio"><span></span> Disable</label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row" id="sec_qus_ans" <?php if($user_details[0]->secret_qus_ans==0) echo 'style="display: none"'?>>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material select-input">
                                        <label class="control-label">Select a question</label>
                                        <select data-placeholder="Select a question" class="select" name="sec_qus">
                                            <option></option>
                                            <option value="what is your nick name ?" selected>What is your nick name ?</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <div class="form-group-material textbox">
                                        <label class="control-label">Answer</label>
                                        <input type="password" class="form-control" name="sec_ans" value="<?php echo(isset($user_details[0]->secret_answer) && $user_details[0]->secret_answer!="") ? $user_details[0]->secret_answer : ''; ?>" placeholder="Answer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="m-b-0 font-bold m-t-40">Activity & Profile Information</h4>
                <hr class="m-t-10">
                <div class="panel panel-default">
                    <div class="panel-body p-30">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group m-b-30">
                                    <label class="switch pull-right">
                                        <input type="checkbox" name="online_status" value="1" <?php if($user_details[0]->online_status==1) echo 'checked'?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <label class="font-bold">Online status</label>
                                </div>
                                <div class="form-group m-b-30">
                                    <label class="switch pull-right">
                                        <input type="checkbox" name="last_active_status" value="1" <?php if($user_details[0]->last_active_status==1) echo 'checked'?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <label class="font-bold">Last active</label>
                                </div>
                                <div class="form-group">
                                    <label class="switch pull-right">
                                        <input type="checkbox" name="view_someone" value="1" <?php if($user_details[0]->view_someone==1) echo 'checked'?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <label class="font-bold">When you view someone</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-1">
                                <div class="form-group m-b-30">
                                    <label class="switch pull-right">
                                        <input type="checkbox" name="favourite_someone" value="1" <?php if($user_details[0]->favourite_someone==1) echo 'checked'?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <label class="font-bold">When you favorite someone</label>
                                </div>
                                <div class="form-group m-b-30">
                                    <label class="switch pull-right">
                                        <input type="checkbox" name="join_date_status" value="1" <?php if($user_details[0]->join_date_status==1) echo 'checked'?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <label class="font-bold">Join date</label>
                                </div>
                                <div class="form-group">
                                    <label class="switch pull-right">
                                        <input type="checkbox" name="recent_login_location" value="1" <?php if($user_details[0]->recent_login_location==1) echo 'checked'?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <label class="font-bold">Recent login location</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center-xs text-right-sm">
                    <button class="btn btn-default text-uppercase" type="reset">Reset</button>
                    <button class="btn btn-primary text-uppercase" type="submit">Save Changes</button>
                </div>
            </form>
    </div>
    
<!--  Change Password Modal  -->
<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Password</h4>
            </div>
            <form class="m-t-30" id="edit_password" action="{{ url("/User/UpdateOldPassword") }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="f-name">Old Password</label>
                        <input type="password" class="form-control" name="old_password" id="old_password" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="l-name">New Password</label>
                        <input type="password" class="form-control" name="new_password" id="new_password" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="tel">Re Enter New Password</label>
                        <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="change_pass_button" class="btn btn-primary">Save</button>
                </div> 
            </form>  
        </div>
    </div>
</div>
<!--   end modal  -->
</section>

        

<script>
    $(function () {

        $('.input-group.date').datepicker({
            autoclose: true
        });
        
        $("#change_pass_button").click(function()
        {
            var old_password = $("#old_password").val();
            var new_password = $("#new_password").val();
            var confirm_new_password = $("#confirm_new_password").val();

            if(new_password!=confirm_new_password)
            {
                alert("Password Missmatch !!!");
                return false;
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/User/MatchPassword') }}",
                    data: {old_password: old_password},
                    success: function(result){
                        //alert(result);
                        //return false;
                        if(result==1){
                             $("#edit_password").submit();
                             return true;
                        } else {
                            alert("Wrong Old Password !!!");
                            return false;
                        }
                    }
                });
            } 
        });
        
        $("#secutiry_question_enable").click(function() {
            $("#sec_qus_ans").show();
        });
        $("#secutiry_question_disable").click(function() {
            $("#sec_qus_ans").hide();
        });
    });
</script>
@endsection
