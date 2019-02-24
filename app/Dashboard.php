<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    public $timestamps = false;
    
    
     public function check_user_email($mail_id) {
        try {
            $query_uesr = 'SELECT COUNT(id) AS total_mail_no FROM user_credentials WHERE username="' . $mail_id . '"  ';
            $data = DB::select($query_uesr);
            $total_mail_no = $data[0]->total_mail_no;
            return $total_mail_no;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    
}
