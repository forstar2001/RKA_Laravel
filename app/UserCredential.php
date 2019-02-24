<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class UserCredential extends Model
{
    public $timestamps = false;
    protected $table = 'user_credentials';
    
    protected $fillable = [
         'email', 'password',
    ];
    
    public function checkLoginCredentials($request){
      $username = $request->username;
      $password = md5($request->password);

      if ($request->remember_me == 'Y') {
          setcookie('username', $request->username, time() + (86400 * 30));
          setcookie('password', $request->password, time() + (86400 * 30));
      } else {
          if (isset($_COOKIE['username']) && $_COOKIE['username']!="")
              setcookie('username', $request->username, time() - (86400 * 30));

          if (isset($_COOKIE['password']) && $_COOKIE['password']!="")
              setcookie('password', $request->password, time() - (86400 * 30));   
      }

      $data =  DB::select("SELECT *  FROM user_credentials WHERE username = '$username' and password = '$password';");
      
      if(!empty($data)){
          
          $current_date_time = date('Y-m-d H:i:s');
          DB::table('user_details')
            ->where('id', $data[0]->user_id)
            ->update(array('last_active' => $current_date_time));
          
        $user_count = $data[0];
        return $user_count;
      } else {
          return $data;
      }
    }
    
    
    public function checkLoginCredentialsFB($username){
      $data =  DB::select("SELECT *  FROM user_credentials WHERE username = '$username';");
      if(!empty($data)){
        $user_count = $data[0];
        return $user_count;
      } else {
          return $data;
      }
    }
    
    public function getUserEmailStatus($request){
        
      $username = $request->username;
      $password = md5($request->password);
      $data =  DB::select("SELECT *  FROM user_credentials WHERE username = '$username' AND password = '$password' ;");
      if(!empty($data)){
        $user_count = $data[0];
        return $user_count;
      } else {
          return $data;
      }
    }
    
    
}
