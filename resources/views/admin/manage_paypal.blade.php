@extends('layouts.adminlayout')

@section('title')
@endsection

@section('content_header')

<h1>
    <?php
    echo 'Manage Paypal';
    ?>
</h1>
You need Business-Pro account for payment through credit/debit card
@endsection
@section('content')

<?php 
if (count($show_paypal_account) > 0) { ?>
    <script>
        $(document).ready(function () {
            $('#example2').dataTable();
        });
    </script>
<?php } ?>
<br/>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
               <form action='{{ route('AddPayPalInfo') }}' method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input text required">
                        <label >Account Holder Name</label>
                        <input class = "form-control" type="text"  name ="account_holder_name" placeholder="Account Holder Name" value="<?php echo isset($show_paypal_account) && !empty($show_paypal_account) ?$show_paypal_account[0]->name : ''?>">
                    </div>                                         
                </div>
                <div class="form-group">
                    <div class="input text required">
                        <label >Account Holder Email</label>
                        <input class = "form-control" type="text"  name = "account_holder_email" placeholder="Account Holder Email" value="<?php echo isset($show_paypal_account) && !empty($show_paypal_account) ?$show_paypal_account[0]->account_email : ''?>">
                    </div>                                         
                </div>
                <div class="form-group">
                    <div class="input text required">
                        <label >Account Holder API Username</label>
                        <input class = "form-control" type="text"  name = "account_holder_api_username" placeholder="Account Holder API Username" value="<?php echo isset($show_paypal_account) && !empty($show_paypal_account) ?$show_paypal_account[0]->account_api : ''?>">
                    </div>                                         
                </div>
                 <div class="form-group">
                    <div class="input text required">
                        <label >Account Holder API Signature</label>
                        <input class = "form-control" type="text"  name= "account_holder_api_signature" placeholder="Account Holder API Signature" value="<?php echo isset($show_paypal_account) && !empty($show_paypal_account) ?$show_paypal_account[0]->account_signature : ''?>">
                    </div>                                         
                </div>
                 <div class="form-group">
                    <div class="input text required">
                        <label >Account Holder API Password</label>
                        <input class = "form-control" type="text"  name= "account_holder_api_password" placeholder="Account Holder API Password" value="<?php echo isset($show_paypal_account) && !empty($show_paypal_account) ?$show_paypal_account[0]->account_password : ''?>">
                    </div>                                         
                </div>
                <div class="box-footer">
                    <input class="btn bg-blue-custom" type="submit" value="Submit">
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

<script type="text/javascript">
      $(function () {
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
      
    </script>
