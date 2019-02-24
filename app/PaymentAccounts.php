<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class PaymentAccounts extends Model
{
    public $timestamps = false;
    protected $table = 'payment_accounts';
}
