@extends("layouts.dashboardlayout")
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
                    <li></li>
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
                        <form action="{{ url("/User/SignUpStepTwo") }}" method="POST" onsubmit="return validate()">
                    {{ csrf_field() }}
                    <div class="form-group custom-radio-form-inline clearfix">
                        <label class="text-uppercase control-label">I'm a</label>
                        <div>
                            <ul class="chec-radio text-left">
                                <li class="pz">
                                    <label class="radio-inline">
                                                <input type="radio"  id="pro-chx-residential" name="property_type" class="pro-chx" value="1">
                                        <span class="clab">ELITE CHAMPION</span>
                                    </label>
                                </li>
                                <li class="pz">
                                    <label class="radio-inline">
                                                <input type="radio" id="pro-chx-commercial" name="property_type" class="pro-chx" value="2" >
                                        <span class="clab">PERFORMANCE RACER</span>
                                    </label>
                                </li>
                                <li class="pz">
                                    <label class="radio-inline">
                                        <input type="radio" id="pro-chx-open" name="property_type" class="pro-chx" value="3">
                                        <span class="clab">ASPIRING ATHLETE</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr class="text-center text-danger" id="property_type_err" />
                    <div class="text-right">
                                <button type="submit" class="text-uppercase btn btn-primary btn-lg right-arrow-btn text-left" id="next" >Continue</button>
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
        var val = document.getElementsByName("property_type");
        for (i = 0; i < val.length; ++i)
        {
            if (val[i].checked)
            {
                flag = flag + 1;
            }
        }
        if (flag == 0)
        {
         $("#property_type_err").html("Please select an option");
            return false;
        } else
        {
            $("#property_type_err").html();
            return true;
        }

    }

</script>
@endsection