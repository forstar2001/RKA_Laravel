@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
                <div class="content">
                    @include("home.myprofile_menu")                   
                    
                    <form class="m-t-40" action="{{url("/User/UpdateUserDescription")}}" method="POST" enctype="multipart/form-data">
                            
                        @if (Session::has('msg'))
                            <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif 

                            <div class="panel panel-default">
                                <div class="panel-body p-30">
    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textarea">
                                                    <label class="control-label">About me</label>
                                                    <textarea class="form-control" name="about_me" placeholder="About me"><?php echo(isset($user_description[0]->about_me) && $user_description[0]->about_me!="")?$user_description[0]->about_me:''; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                            <div class="form-group-material select-input">
                                                <label class="control-label">What I'm Looking for</label>
                                                    <?php
                                                        $looking_for = array();
                                                        if(isset($user_description[0]->looking_for))
                                                        {
                                                            $looking_for = explode('|',$user_description[0]->looking_for);
                                                        }
                                                    ?>
                                                    <select data-placeholder="What I'm Looking for" multiple="multiple" class="select" name="looking_for[]" required>
                                                        <option></option>
                                                        <?php foreach($looking_for_tags as $key=>$val) { ?>
                                                            <option value="{{ $key }}" <?php echo(in_array($key,$looking_for))?'selected':''; ?>>{{ $val }}</option>
                                                        <?php } ?>
                                                    </select>
                                            </div>
                                        </div>
                                            
                                        </div>
    
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material textarea">
                                                    <label class="control-label">Describe What You're Looking For</label>
                                                    <textarea class="form-control" name="look_up" placeholder="Describe What You're Looking For"><?php echo(isset($user_description[0]->look_up) && $user_description[0]->look_up!="")?$user_description[0]->look_up:''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center-xs text-right-sm">
                                <input type="hidden" name="user_id" value="<?php echo(isset($user_description[0]->user_id) && $user_description[0]->user_id!="") ? $user_description[0]->user_id : ''; ?>">
                                <button class="btn btn-default text-uppercase" type="submit">Reset</button>
                                <button class="btn btn-primary text-uppercase" type="submit">Save Changes</button>
                            </div>
                        </form>
                </div>
            </section>

@endsection