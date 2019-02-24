@extends("layouts.user_dashboardlayout")
@section('content')
<section class="right-section">
    <div class="content">
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="#">Trainers</a></li>
            <li><a href="#">Randy Lyons</a></li>
            <li class="active">Request Trainer</li>
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
                                        <a class="pull-left m-r-10" href="#"> <img class="media-object" src="{{url('/') }}/public/default/images/img_bg_login.png" style="width: 120px; height: 120px;"> </a>
                                        <div class="media-body">
                                            <h4 class="media-heading"><a href="#">Randy Lyons</a></h4>
                                            <h5 class="media-heading">Personal trainer</h5>
                                            <span class="address">28, VA, United States</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="trainer-price-perhour"><span class="price">$ 25.00 / per hour</span></td>
                                <td class="trainer-hour">
                                    <div class="number-counter">
                                        <a href="" class="number-decrease">-</a>
                                        <input type="text" class="form-control">
                                        <a href="" class="number-increase">+</a>
                                    </div>
                                </td>
                                <td class="trainer-total-price"><span class="price">$ 100.00</span></td>
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
                    <table class="pull-right">

                        <tr>

                            <td class="p-5"><h5>Subtotal</h5></td>
                            <td class="text-right p-5"><h5><strong>100</strong></h5></td>
                        </tr>
                        <tr>

                            <td class="p-5"><h5>Other RKA Charge (If any):</h5></td>
                            <td class="text-right p-5"><h5><strong>$2.00</strong></h5></td>
                        </tr>

                        <tr class="border-top-cc">
                            <td class="p-5"><h3>Total</h3></td>
                            <td class="text-right p-5"><h3><strong>$102.00</strong></h3></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <ul class="payment-tab clearfix m-t-40">
                    <li><a href="{{url("/User/PayWithCreditCard")}}"><svg viewBox="0 0 24 24"><use xlink:href="#ic_payment"></use></svg> Credit Card</a></li>
                    <li class="active"><a href="{{url("/User/PayWithPayPal")}}"><img src="{{url('/') }}/public/default/images/icons/Icon/paypal.png" alt="" width="100"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <form class="panel-body p-30" action="dashboard-PaymentSuccess.html">
                <h4 class="m-b-0 font-bold m-t-0">Create Your 4-Digit Passcode to Mark Training/ Coaching Completed</h4>
                <hr class="m-t-10">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group ">
                            <div class="form-group-material textbox animate">
                                <label class="control-label">Enter Passcode</label>
                                <input class="form-control" placeholder="Enter Passcode" type="password" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-info-style">
                    <div class="help-block d-i-b"><i class="info-icon"></i></div>
                    <p class="pstyle2"> You will be redirected to PayPal website to complete your purchase securely.
                    </p>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary text-uppercase btn-custom" type="submit">Continue to PayPal</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection