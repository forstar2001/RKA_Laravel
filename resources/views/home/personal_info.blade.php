@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
                <div class="content">
                    @include("home.myprofile_menu")                   
                    
                    <form action="{{url("/User/UpdatePersonalInfo")}}" method="POST" enctype="multipart/form-data" class="m-t-40" >
                            @if (Session::has('msg'))
                                <div class="alert alert-success">{{ Session::get('msg') }}</div>
                                @endif  
                        <div class="panel panel-default">
                                <div class="panel-body p-30">
    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Height</label>
                                                    <?php   
                                                    if(isset($data[0]->height) && $data[0]->height!="")
                                                         $user_height_arr = explode('^', $data[0]->height); 
                                                    else
                                                        $user_height_arr = array();
                                                    ?>
                                                    <select id="u4387_input" data-placeholder="Height" class="select" name='height' required>
                                                        <option value=""> Select </option>
                                                        <?php     
                                                        if(!empty($height_arr)){                 
                                                        foreach ($height_arr as $height_arr_val) { 
                                                        ?>
                                                        <option value={{$height_arr_val}} <?php echo in_array($height_arr_val,$user_height_arr)?'selected':''; ?>>{{$height_arr_val}}</option>
                                                        <?php } }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Ethnicity</label>
                                                    <?php   
                                                    if(isset($data[0]->ethnicity) && $data[0]->ethnicity!="")
                                                         $user_ethnicity_arr = explode('^', $data[0]->ethnicity);
                                                    else
                                                        $user_ethnicity_arr = array();
                                                        ?>
                                                    <select data-placeholder="Group Workout Info and Location" class="select" name='ethnicity' required>
                                                        <option value=""> Select </option>
                                                        <?php
                                                        if(!empty($ethnicity_arr)){        
                                                        foreach ($ethnicity_arr as $ethnicity_arr_val) {
                                                        ?>
                                                        <option  value="<?php echo $ethnicity_arr_val;?>"<?php echo in_array($ethnicity_arr_val,$user_ethnicity_arr)?'selected':''; ?>>{{$ethnicity_arr_val}}</option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Education</label>
                                                    <?php   
                                                    if(isset($data[0]->education) && $data[0]->education!="")
                                                         $user_education_arr = explode('^', $data[0]->education);
                                                         else
                                                        $user_education_arr = array();
                                                        ?>
                                                    <select data-placeholder="Education" class="select" name='education' required>
                                                        <option value=""> Select </option>
                                                        <?php
                                                        if(!empty($education_arr)){ 
                                                        foreach ($education_arr as $education_arr_val) {
                                                        ?>
                                                        <option  value="<?php echo $education_arr_val;?>" <?php echo in_array($education_arr_val,$user_education_arr)?'selected':''; ?>><?php echo $education_arr_val;?></option>
                                                   <?php    } } ?>
                                                    </select>
                                                     
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Children</label>
                                                    <?php   
                                                    if(isset($data[0]->children) && $data[0]->children!="")
                                                         $user_children_arr = explode('^', $data[0]->children);
                                                         else
                                                        $user_children_arr = array();
                                                        ?>
                                                    <select data-placeholder="Children" class="select" name='children' required>
                                                        <option value=""> Select </option>
                                                        <?php
                                                        if(!empty($education_arr)){ 
                                                        foreach ($children_arr as $children_arr_val) { 
                                                        ?>
                                                        <option  value="<?php echo $children_arr_val;?>"<?php echo in_array($children_arr_val,$user_children_arr)?'selected':''; ?>><?php echo $children_arr_val;?></option>
                                                        <?php    } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Drinking</label>
                                                    <?php   
                                                    if(isset($data[0]->drinks) && $data[0]->drinks!="")
                                                         $user_drinks_arr = explode('^', $data[0]->drinks);
                                                         else
                                                        $user_drinks_arr = array();
                                                        ?>
                                                    <select data-placeholder="Drinking" class="select" name='drinks' required>
                                                        <option value=""> Select </option>
                                                        <?php
                                                        if(!empty($drinking_arr)){ 
                                                        foreach ($drinking_arr as $drinking_arr_val) {
                                                        ?>
                                                        <option value="<?php echo $drinking_arr_val;?>"<?php echo in_array($drinking_arr_val,$user_drinks_arr)?'selected':''; ?>><?php echo $drinking_arr_val;?></option>
                                                        <?php    } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Body Type</label>
                                                    <?php   
                                                    if(isset($data[0]->body_type) && $data[0]->body_type!="")
                                                         $user_body_type_arr = explode('^', $data[0]->body_type);
                                                         else
                                                        $user_body_type_arr = array();
                                                        ?>
                                                    <select data-placeholder="Group Workout Info and Location" class="select" name='body_type' required> 
                                                        <option value=""> Select </option>
                                                        <?php          
                                                        if(!empty($body_type_arr)){  
                                                        foreach ($body_type_arr as $body_type_arr_val) {
                                                        ?>
                                                        <option value="<?php echo $body_type_arr_val;?>"<?php echo in_array($body_type_arr_val,$user_body_type_arr)?'selected':''; ?>>{{$body_type_arr_val}}</option>
                                                           <?php   } } ?>
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="form-group ">
                                                <div class="form-group-material textbox animate">
                                                    <label class="control-label">Occupation</label>
                                                    <input class="form-control" placeholder="Occupation" required type="text" name='occupation' value='{{ (isset($data[0]->occupation) && $data[0]->occupation!="")?$data[0]->occupation:"" }}'>
                                                </div>
                                            </div>    
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Relationship</label>
                                                     <?php   
                                                     if(isset($data[0]->relationship) && $data[0]->relationship!="")
                                                         $user_relationship_arr = explode('^', $data[0]->relationship);   
                                                         else
                                                        $user_relationship_arr = array();
                                                        ?>
                                                    <select data-placeholder="Relationship" class="select" name='relationship' required>
                                                        <option value=""> Select </option>
                                                        <?php 
                                                        if(!empty($relationship_arr)){  
                                                        foreach ($relationship_arr as $relationship_arr_val) { 
                                                        ?>
                                                        <option  value="<?php echo $relationship_arr_val;?>"<?php echo in_array($relationship_arr_val,$user_relationship_arr)?'selected':''; ?>>{{$relationship_arr_val}}</option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Smoking</label>
                                                    <?php   
                                                    if(isset($data[0]->smokes) && $data[0]->smokes!="")
                                                         $user_smokes_arr = explode('^', $data[0]->smokes);
                                                         else
                                                        $user_smokes_arr = array();
                                                        ?>
                                                    <select data-placeholder="Smoking" class="select" name='smokes' required>
                                                        <option value=""> Select </option>
                                                        <?php  
                                                        if(!empty($smoking_arr)){  
                                                        foreach ($smoking_arr as $smoking_arr_val) {
                                                        ?>
                                                        <option value="<?php echo $smoking_arr_val;?>"<?php echo in_array($smoking_arr_val,$user_smokes_arr)?'selected':''; ?>>{{$smoking_arr_val}}</option>
                                                         <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="form-group-material select-input">
                                                    <label class="control-label">Language</label>
                                                    <?php   
                                                    if(isset($data[0]->language) && $data[0]->language!="")
                                                         $user_language_arr = explode('^', $data[0]->language);
                                                         else
                                                        $user_language_arr = array();
                                                        ?>
                                                    <select data-placeholder="Language" class="select" name='language' required>
                                                        <option value=""> Select </option>
                                                        <?php     
                                                         if(!empty($language_arr)){                                          
                                                        foreach ($language_arr as $language_arr_val) {
                                                        ?>
                                                        <option value="<?php echo $language_arr_val;?>"<?php echo in_array($language_arr_val,$user_language_arr)?'selected':''; ?>>{{$language_arr_val}}</option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
    
                                </div>
                            </div>
                            <div class="text-center-xs text-right-sm">
                                <input type="hidden" name="id" value="<?php echo(isset($user_details[0]->id) && $user_details[0]->id!="")?$user_details[0]->id:''; ?>">
                                <button class="btn btn-default text-uppercase" type="submit">Reset</button>
                                <button class="btn btn-primary text-uppercase" type="submit">Save Changes</button>
                            </div>
                        </form>

                </div>
            </section>

@endsection