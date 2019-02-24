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
                        <form action="{{ url("/User/SignUpStepFour") }}" method="POST" onsubmit="return validate()">
                    {{ csrf_field() }}
                    <div class="form-group custom-radio-form-inline clearfix">
                        <label class="text-uppercase control-label">AND</label>
                        <div>
                            <ul class="chec-radio text-center">
                                <li class="pz">
                                    <label class="radio-inline">
                                                <input type="radio"  id="pro-chx-residential" name="gender" class="pro-chx" value="Male">
                                        <span class="clab">
                                            <span class="svgicon"><svg viewBox="0 0 24 24"><use xlink:href="#male"></use></svg> </span><span>Man</span>
                                        </span>
                                    </label>
                                </li>
                                <li class="pz">
                                    <label class="radio-inline">
                                                <input type="radio" id="pro-chx-commercial" name="gender" class="pro-chx" value="Female" >
                                        <span class="clab">
                                            <span class="svgicon"><svg viewBox="0 0 24 24"><use xlink:href="#female"></use></svg> </span><span>Woman</span>
                                        </span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr class="text-center text-danger" id="gender_err" />
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
        
        var count = 0;
        var i = 0;
        var flag = 0;
        var val = document.getElementsByName("gender");
        for (i = 0; i < val.length; ++i)
        {
            if (val[i].checked)
            {
                flag = flag + 1;
            }
        }
        if (flag == 0)
        {
            
            $("#gender_err").html("Please Select Gender");
            return false;
        } else
        {
             $("#gender_err").html("");
            return true;
        }

    }

</script>
@endsection