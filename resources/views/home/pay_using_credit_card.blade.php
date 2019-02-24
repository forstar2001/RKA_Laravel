@extends("layouts.user_dashboardlayout")
@section('content')
<?php

use App\UserDetail;

$countries = new UserDetail();
$country = $countries->getCountries();
?>

<section class="right-section">

    <div class="content">
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="#">Trainers</a></li>
            <li><a href="#"><?php echo $user_credit_details[0]->first_name; ?></a></li>
            <li class="active"><?php echo $user_credit_details[0]->profile; ?></li>
        </ol>
        <div class="panel panel-default">
            <div class="panel-body p-0">
                <div class="clearfix product-checkout-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product-cell">Product</th>
                                <th class="price-cell">Price</th>
                                <th class="amount-cell">Amount of hours</th>
                                <th class="total-price-cell">Total price</th>
                                <th class="blank"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="trainer-info">
                                    <div class="media">
                                        <a class="pull-left m-r-10" href="#"> <img class="media-object" src="{{url('/') }}/public/uploads/user_profile_pictures/{{$user_credit_details[0]->profile_picture}}" style="width: 120px; height: 120px;"> </a>
                                        <div class="media-body">
                                            <h4 class="media-heading"><a href="#"><?php echo $user_credit_details[0]->first_name; ?></a></h4>
                                            <h5 class="media-heading"><?php echo $user_credit_details[0]->profile; ?></h5>
                                            <span class="address"><?php echo $user_credit_details[0]->location; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="trainer-price-perhour"><span class="price">$<span id="rate"><?php echo $user_credit_details[0]->rate; ?></span> / per hour</span></td>
                                <td class="trainer-hour">
                                    <div class="number-counter">
                                        <a href="" class="number-decrease" onclick="calculateminus()">-</a>
                                        <input type="text" class="form-control" id="hours">
                                        <a href="" class="number-increase" onclick="calculateplus()">+</a>
                                    </div>
                                </td>
                                <td class="trainer-total-price"><span class="price">$<span id="total">0</span></td>
                                <td class="remove-trainer">
                                    <a href="#" class="close-line-icon-grey">
                                        <span class="close-line"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="p-30 p-t-0">
                    <div class="product-checkout-totalpricing">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="p-5"><h5>Subtotal</h5></td>
                                    <td class="text-right p-5"><h5><strong><span id="subtotal">0</span></strong></h5></td>
                                </tr>
                                <tr>
                                    <td class="p-5"><h5>Other RKA Charge (If any):</h5></td>
                                    <td class="text-right p-5"><h5><strong>$2.00</strong></h5></td>
                                </tr>
                                <tr class="border-top-cc">
                                    <td class="p-5"><h3>Total</h3></td>
                                    <td class="text-right p-5"><h3><strong>$<span id="alltotal">2</span></strong></h3></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <ul class="payment-tab clearfix m-t-40">
                    <li class="active"><a href="{{url("/User/PayWithCreditCard")}}"><svg viewBox="0 0 24 24"><use xlink:href="#ic_payment"></use></svg> Credit Card</a></li>
                    <li><a href="{{url("/User/PayWithPayPal")}}"><img src="{{url('/') }}/public/default/images/icons/Icon/paypal.png" alt="" width="100"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <form class="panel-body p-30" action="{{url('/User/CreditCardDetailsAdd/'.$user_credit_details[0]->id)}}" method="post" onsubmit="return validate()">
                <span class="pull-right"><img src="{{url('/') }}/public/default/images/icons/Icon/cards.svg"></span>
                <h4 class="m-b-0 m-t-0">Payment Details</h4><input type="hidden" value="2" id="total1" name="amount">
                <hr class="m-t-10">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Card number</label>
                                <input class="form-control" placeholder="Card number" type="text" name="card_no" id="card_number">
                                <svg viewBox="0 0 24 24"><use xlink:href="#ic_payment"></use></svg>
                            </div>
                            <div id="card_no_err" ></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">MM/YY</label>
                                <input class="form-control" placeholder="MM/YY" type="text"  name="expiary" id="expiary_date" readonly>
                            </div>
                            <div id="expiary_date_err" ></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Name on card</label>
                                <input class="form-control" placeholder="Name on card" type="text" name="name_on_card" id="name_card">
                            </div>
                            <div id="name_card_err" ></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">CVV</label>
                                <input class="form-control" placeholder="CVV" type="text" name="cvv" id="cvv1">
                            </div>
                            <div id="cvv_err" ></div>
                        </div>
                    </div>
                </div>
                <h4 class="m-b-0 m-t-30">Billing Details</h4>
                <hr class="m-t-10">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">First Name</label>
                                <input class="form-control" placeholder="First Name" type="text" name="billing_firstname" id="firstname">
                            </div>
                            <div id="firstname_err" ></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Last Name</label>
                                <input class="form-control" placeholder="Last Name" type="text" name="billing_lastname" id="lastname">
                            </div>
                            <div id="lastname_err" ></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Address Line 1</label>
                                <input class="form-control" placeholder="Address Line 1" type="text" name="address_line1" id="address1">
                            </div>
                            <div id="address1_err" ></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Address Line 2</label>
                                <input class="form-control" placeholder="Address Line 2" type="text" name="address_line2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material select-input">
                                <label class="control-label">Select Country</label>
                                <select data-placeholder="Select Country" class="select" name="country" id="country1">
                                    <option value="" selected>Select</option>
                                    <!--                                    <option>United States</option>
                                                                        <option value=>Alaska</option>
                                                                        <option value="HI">Hawaii</option>
                                                                        <option value="CA">California</option>
                                                                        <option value="NV">Nevada</option>
                                                                        <option value="WA">Washington</option>
                                                                        <option value="AZ">Arizona</option>
                                                                        <option value="CO">Colorado</option>
                                                                        <option value="WY">Wyoming</option>-->
                                    <?php foreach ($country as $key => $value) { ?>
                                        <option value="{{$value->id}}">{{$value->country_name }}</option>
<?php } ?>
                                </select>
                            </div>
                            <div id="country1_err" ></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!--                        <div class="form-group ">
                                                    <div class="form-group-material select-input">
                                                        <label class="control-label">City</label>
                                                        <select data-placeholder="City" class="select">
                                                            <option></option>
                                                            <option value="AK">Alaska</option>
                                                            <option value="HI">Hawaii</option>
                                                            <option value="CA">California</option>
                                                            <option value="NV">Nevada</option>
                                                            <option value="WA">Washington</option>
                                                            <option value="AZ">Arizona</option>
                                                            <option value="CO">Colorado</option>
                                                            <option value="WY">Wyoming</option>
                                                        </select>
                                                    </div>
                                                </div>-->

                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">City</label>
                                <input class="form-control" placeholder="City" type="text" name="city" id="city1">
                            </div>
                            <div id="city1_err" ></div>
                        </div>
                        
                        

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">State Province</label>
                                <input class="form-control" placeholder="State/Province" type="text" name="state" id="state1">
                            </div>
                             <div id="state1_err" ></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Zip/Postal Code</label>
                                <input class="form-control" placeholder="Zip/Postal Code" type="text" name="zip" id="zip1">
                            </div>
                             <div id="zip1_err" ></div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Phone Number</label>
                                <input class="form-control" placeholder="Phone Number" type="text" name="phone_number" id="phoneno">
                            </div>
                            <div id="phoneno_err" ></div>
                            
                        </div>
                    </div>
                </div>
                <h4 class="m-b-0 m-t-30">Create Your 4-Digit Passcode to Mark Training/Coaching Completed</h4>
                <hr class="m-t-10">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Enter Passcode</label>
                                <input class="form-control" placeholder="Enter Passcode" type="password" name="passcode" id="passcode1">
                            </div>
                            <div id="passcode1_err" ></div>
                        </div>
                    </div>
                </div>
                <p class="pstyle3">For your protection, your credit card statement wil read "amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus "</p>
                <div class="panel-info-style">
                    <div class="help-block d-i-b"><i class="info-icon"></i></div>
                    <p class="pstyle2"> Credit card or prepaid card used must permit international transactions. Purchase may be made via our sales agent xcxcxxc, xcvsxsgsg
                    </p>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary text-uppercase btn-custom" >Proceed to pay</button>
<!--                <input type="submit" value="Proceed to pay" class="btn btn-primary text-uppercase btn-custom"> -->
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function calculateplus()
    {
        var hours = document.getElementById("hours").value;
        var rate = document.getElementById("rate").innerHTML;
        var hours1 = parseInt(hours) + 1;

        document.getElementById("total").innerHTML = hours1 * rate;
        document.getElementById("subtotal").innerHTML = hours1 * rate;
        document.getElementById("alltotal").innerHTML = (hours1 * rate) + 2;
        document.getElementById("total1").value=document.getElementById("alltotal").innerHTML;
    }

    function calculateminus()
    {

        var hours = document.getElementById("hours").value;
        var rate = document.getElementById("rate").innerHTML;
        if (hours == 0)
        {
            var hours1 = hours;
        } else
        {
            var hours1 = parseInt(hours) - 1;
        }
        document.getElementById("total").innerHTML = hours1 * rate;
        document.getElementById("subtotal").innerHTML = hours1 * rate;
        document.getElementById("alltotal").innerHTML = (hours1 * rate) + 2;
        document.getElementById("total1").value=document.getElementById("alltotal").innerHTML;
    }
    
    var startDate = new Date();


     $(document).ready(function(){
        $('#expiary_date').datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'mm/yyyy',
        })
 });
    
    function validate()
    {
       
        var card_no=document.getElementById("card_number").value;
        if(card_no=="")
        {
          
            document.getElementById("card_no_err").innerHTML="Enter card number";
            document.getElementById("card_no_err").style.color="red";
            document.getElementById("card_number").focus();
            return false;
        }
        else if(isNaN(card_no))
        {
               
            document.getElementById("card_no_err").innerHTML="Enter numeric value";
            document.getElementById("card_no_err").style.color="red";
            document.getElementById("card_number").focus();
             return false;
        }
       
        else
        {
            document.getElementById("card_no_err").innerHTML="";
          
            
        }
        var expiary_date=document.getElementById("expiary_date").value;
        if(expiary_date!="")
        {
            
             document.getElementById("expiary_date_err").innerHTML="";
        }
        else
        {
           
            document.getElementById("expiary_date_err").innerHTML="Enter expiry date";
            document.getElementById("expiary_date_err").style.color="red";
            document.getElementById("expiary_date").focus();
             return false;
        }
        var name_card=document.getElementById("name_card").value;
        if(name_card!="")
        {
          
            document.getElementById("name_card_err").innerHTML="";
        }
        else
        {
          
            document.getElementById("name_card_err").innerHTML="Enter name on card";
            document.getElementById("name_card_err").style.color="red";
            document.getElementById("name_card").focus();
             return false;
            
        }
        var cvv=document.getElementById("cvv1").value;
        if(cvv=="")
        {
            
          
            document.getElementById("cvv_err").innerHTML="Enter cvv number";
            document.getElementById("cvv_err").style.color="red";
            document.getElementById("cvv1").focus();
             return false;
        }
        else if(isNaN(cvv))
        {
            
               
            document.getElementById("cvv_err").innerHTML="Enter numeric value";
            document.getElementById("cvv_err").style.color="red";
            document.getElementById("cvv1").focus();
             return false;
        }
       
        else
        {
            document.getElementById("cvv_err").innerHTML="";
            
            
        }
         var firstname_billing=document.getElementById("firstname").value;
        if(firstname_billing!="")
        {
            
            document.getElementById("firstname_err").innerHTML="";
        }
        else
        {
          
            document.getElementById("firstname_err").innerHTML="Enter billing firstname";
            document.getElementById("firstname_err").style.color="red";
            document.getElementById("firstname").focus();
             return false;
            
        }
          var lastname_billing=document.getElementById("lastname").value;
        if(lastname_billing!="")
        {
           
            document.getElementById("lastname_err").innerHTML="";
        }
        else
        {
            
            document.getElementById("lastname_err").innerHTML="Enter billing lastname";
            document.getElementById("lastname_err").style.color="red";
            document.getElementById("lastname").focus();
             return false;
            
        }
      
        var address1=document.getElementById("address1").value;
        if(address1!="")
        {
           
            document.getElementById("address1_err").innerHTML="";
        }
        else
        {
          
            document.getElementById("address1_err").innerHTML="Enter address";
            document.getElementById("address1_err").style.color="red";
            document.getElementById("address1").focus();
             return false;
            
        }
        var country1=document.getElementById("country1").value;
        if(country1!="")
        {
          
            document.getElementById("country1_err").innerHTML="";
        }
        else
        {
            
            document.getElementById("country1_err").innerHTML="Enter country";
            document.getElementById("country1_err").style.color="red";
            document.getElementById("country1").focus();
             return false;
            
        }
         var city=document.getElementById("city1").value;
        if(city!="")
        {
           
            document.getElementById("city1_err").innerHTML="";
        }
        else
        {
          
            document.getElementById("city1_err").innerHTML="Enter city";
            document.getElementById("city1_err").style.color="red";
            document.getElementById("city1").focus();
             return false;
            
        }
         var state=document.getElementById("state1").value;
        if(state!="")
        {
          
            document.getElementById("state1_err").innerHTML="";
        }
        else
        {
          
            document.getElementById("state1_err").innerHTML="Enter state";
            document.getElementById("state1_err").style.color="red";
            document.getElementById("state1").focus();
             return false;
            
        }
         var zip1=document.getElementById("zip1").value;
         if(zip1!="")
        {
           
            document.getElementById("zip1_err").innerHTML="";
        }
        else
        {
            
            document.getElementById("zip1_err").innerHTML="Enter zip code";
            document.getElementById("zip1_err").style.color="red";
            document.getElementById("zip1").focus();
             return false;
            
        }
        var phoneno=document.getElementById("phoneno").value;
         if(phoneno=="")
        {
           
            document.getElementById("phoneno_err").innerHTML="Enter phone number ";
            document.getElementById("phoneno_err").style.color="red";
            document.getElementById("phoneno").focus();
             return false;
        }
         else if(isNaN(phoneno))
        {
          
            document.getElementById("phoneno_err").innerHTML="Enter numeric value";
            document.getElementById("phoneno_err").style.color="red";
            document.getElementById("phoneno").focus();
             return false;
        }
        else
        {
            document.getElementById("phoneno_err").innerHTML="";
        
            
        }
          var passcode1=document.getElementById("passcode1").value;
         if(passcode1!="")
        {
           
            document.getElementById("passcode1_err").innerHTML="";
        }
        else
        {
            
            document.getElementById("passcode1_err").innerHTML="Enter passcode value";
            document.getElementById("passcode1_err").style.color="red";
            document.getElementById("passcode1").focus();
             return false;
            
        }
            return true;
        
        
    }
</script>



@endsection