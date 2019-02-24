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
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="form-sec-input p-b-30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                        <form action="{{ url("/User/SignUpStepThree") }}" method="POST"  onsubmit="return validate()">
                    {{ csrf_field() }}
                    <div class="form-group custom-radio-form-inline clearfix">
                        <label class="text-uppercase control-label">AND</label>
                        <div>
                            <ul class="chec-radio">
                                <li class="pz">
                                    <label class="radio-inline">
                                                <input type="radio"  id="pro-chx-residential" name="profile_type" class="pro-chx" value="personal_trainer">
                                        <span class="clab">Personal trainer / coach</span>
                                    </label>
                                </li>
                                <li class="pz">
                                    <label class="radio-inline">
                                                <input type="radio" id="pro-chx-commercial" name="profile_type" class="pro-chx" value="recovery_specialist" >
                                        <span class="clab">Repair / recovery specialist</span>
                                    </label>
                                </li>
                                <li class="pz">
                                    <label class="radio-inline">
                                        <input type="radio" id="pro-chx-open" name="profile_type" class="pro-chx" value="neither">
                                        <span class="clab">Neither</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr class="text-center text-danger" id="profile_type_err" />
                    <div class="text-right">
                        <button type="submit" class="text-uppercase btn btn-primary btn-lg right-arrow-btn text-left">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    function validate()
    {
//        alert("hello");
        var count = 0;
        var i = 0;
        var flag = 0;
        var val = document.getElementsByName("profile_type");
        for (i = 0; i < val.length; ++i)
        {
            if (val[i].checked)
            {
                flag = flag + 1;
            }
        }
        if (flag == 0)
        {
            
          $("#profile_type_err").html("Please Select One Profile");
            return false;
        } else
        {
             $("#profile_type_err").html();
            return true;
        }

    }

</script>
@endsection
