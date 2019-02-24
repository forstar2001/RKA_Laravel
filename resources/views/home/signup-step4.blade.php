@extends('layouts.dashboardlayout')
@section('content')

 <section class="step-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="site-titel-dashboard">So far so good. Let’s talk about your interests.</h2>
                        <p class="desp">Please answer few questions to set up your profile</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="progressbar m-t-40 clearfix p-l-0">
                            <li class="active"></li>
                            <li class="active"></li>
                            <li class="active"></li>
                            <li class="active"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="form-sec-input p-b-30">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ url("/User/Add") }}" method="POST"  onsubmit="return validate()">
                            {{ csrf_field() }}
                            <div class="form-group custom-radio-form-inline clearfix">
                                <label class="text-uppercase control-label">WHO IS INTERESTED IN</label>
                                <div>
                                    <ul class="chec-radio">
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="look_1" name="looking_tags[]" class="pro-chx chkbox" value="Personal trainers / coaches">
                                                <span class="clab">
                                                    Personal trainers / coaches
                                                </span>
                                            </label>
                                        </li>
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox" id="look_2" name="looking_tags[]" class="pro-chx chkbox" value="Racing Partners" >
                                                <span class="clab">
                                                    Racing partners
                                                </span>
                                            </label>
                                        </li>
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="look_3" name="looking_tags[]" class="pro-chx chkbox" value="Training Partners">
                                                <span class="clab">
                                                    Training partners
                                                </span>
                                            </label>
                                        </li>
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="look_4" name="looking_tags[]" class="pro-chx chkbox" value="Fitness Buddies">
                                                <span class="clab">
                                                    Fitness buddies
                                                </span>
                                            </label>
                                        </li>
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="look_5" name="looking_tags[]" class="pro-chx chkbox" value="Repair / recovery specialists">
                                                <span class="clab">
                                                    Repair / recovery specialists
                                                </span>
                                            </label>
                                        </li>
                                       <?php    if(session()->get('temp_profile_id')==3 || session()->get('temp_profile_id')==4)
                                        {   ?>
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="look_5" name="looking_tags[]" class="pro-chx chkbox" value="Elite Champion">
                                                <span class="clab">
                                                   Elite Champion
                                                </span>
                                            </label>
                                        </li>
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="look_5" name="looking_tags[]" class="pro-chx chkbox" value="Performance Racers">
                                                <span class="clab">
                                                   Performance Racers
                                                </span>
                                            </label>
                                        </li>
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="look_5" name="looking_tags[]" class="pro-chx chkbox" value="Aspiring Athletes">
                                                <span class="clab">
                                                   Aspiring Athletes
                                                </span>
                                            </label>
                                        </li>
                                        <?php  }  ?>
                                        <li class="pz">
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="look_All" name="looking_tags[]" class="pro-chx" value="All of them">
                                                <span class="clab">
                                                    All of them
                                                </span>
                                            </label>
                                        </li>                                
                                    </ul>
                                </div>
                            </div>
                            <hr class="text-center text-danger" id="looking_tags_err" />
                            <div class="text-right">
                                <button type="submit" class="text-uppercase btn btn-primary btn-lg right-arrow-btn text-left">Let's Start</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

<script>

$(document).ready(function () {

    $('#look_All').on('click',function(){
        if(this.checked){
            $('.chkbox').each(function(){
                this.checked = true;
            });
        }else{
            $('.chkbox').each(function(){
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

});

function validate()
    {
        
        var count=0;
        var i=0;
        var flag=0;
        var val=document.getElementsByName("looking_tags[]");
        for(i=0;i< val.length;++i)
        {
            if(val[i].checked)
            {
                flag=flag+1;
            }
        }
        if(flag==0)
        {
             $("#looking_tags_err").html("Please Select Atleast One Option");
            return false;
        }
        else
        {
             $("#looking_tags_err").html("");
            return true;
        }
       
    }
</script>

@endsection