<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    public function user_list()
    {
        $details=DB::select("select * from user_details");
        return $details;
    }
    
    public function getGroupWorkoutInfo()
    {
     try {
        $select = 'SELECT * FROM group_workout_info_locations';
        $data = DB::select($select);
        return $data;
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function addGroupWorkoutInfo($request)
    {
     try {
         $title = $request->title;
         $description = $request->description;
         
         $values = array('tag_title' => $title,'tag_desc' => $description);
         DB::table('group_workout_info_locations')->insert($values);
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function selectGroupWorkoutInfo($id)
    {
     try {
        $select = 'SELECT * FROM group_workout_info_locations WHERE id='.$id;
        $data = DB::select($select);
        return $data;
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function editGroupWorkoutInfo($request)
    {
     try {
         $id = $request->id;
         $title = $request->title;
         $description = $request->description;
         
         $values = array('tag_title' => $title,'tag_desc' => $description);
         
         DB::table('group_workout_info_locations')
        ->where('id', $id)
        ->update($values);
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function deleteGroupWorkoutInfo($id)
    {
     try {
         DB::table('group_workout_info_locations')
        ->where('id', $id)
        ->delete();
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getGymMembership()
    {
     try {
        $select = 'SELECT * FROM gym_memberships';
        $data = DB::select($select);
        return $data;
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function addGymMembership($request)
    {
     try {
         $title = $request->title;
         $description = $request->description;
         
         $values = array('tag_title' => $title,'tag_desc' => $description);
         DB::table('gym_memberships')->insert($values);
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function selectGymMembership($id)
    {
     try {
        $select = 'SELECT * FROM gym_memberships WHERE id='.$id;
        $data = DB::select($select);
        return $data;
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function editGymMembership($request)
    {
     try {
         $id = $request->id;
         $title = $request->title;
         $description = $request->description;
         
         $values = array('tag_title' => $title,'tag_desc' => $description);
         
         DB::table('gym_memberships')
        ->where('id', $id)
        ->update($values);
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function deleteGymMembership($id)
    {
     try {
         DB::table('gym_memberships')
        ->where('id', $id)
        ->delete();
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getScheduledRacesInfo()
    {
     try {
        $select = 'SELECT * FROM scheduled_races';
        $data = DB::select($select);
        return $data;
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function addScheduledRacesInfo($request)
    {
     try {
         $title = $request->title;
         $description = $request->description;
         
         $values = array('tag_title' => $title,'tag_desc' => $description);
         DB::table('scheduled_races')->insert($values);
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function selectScheduledRacesInfo($id)
    {
     try {
        $select = 'SELECT * FROM scheduled_races WHERE id='.$id;
        $data = DB::select($select);
        return $data;
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function selectOutdoorWorkoutInfo($id)
    {
     try {
        $select = 'SELECT * FROM outdoor_workout_locations WHERE id='.$id;
        $data = DB::select($select);
        return $data;
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function editScheduledRacesInfo($request)
    {
     try {
         $id = $request->id;
         $title = $request->title;
         $description = $request->description;
         
         $values = array('tag_title' => $title,'tag_desc' => $description);
         
         DB::table('scheduled_races')
        ->where('id', $id)
        ->update($values);
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editOutdoorWorkoutInfo($request)
    {
     try {
         $id = $request->id;
         $title = $request->title;
         $description = $request->description;
         
         $values = array('tag_title' => $title,'tag_desc' => $description);
         
         DB::table('outdoor_workout_locations')
        ->where('id', $id)
        ->update($values);
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function deleteScheduledRacesInfo($id)
    {
     try {
         DB::table('scheduled_races')
        ->where('id', $id)
        ->delete();
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getOutdoorInfo()
    {
       try {
        $select = 'SELECT * FROM outdoor_workout_locations';
        $data = DB::select($select);
        return $data;
         } catch (Exception $e) {
            echo $e->getMessage();
        } 
    }
    
    public function addOutdoorWorkoutLocationInfo($request)
    {
        
     try {
         $tag_title = $request->title;
         $tag_description = $request->description;
         
         $values = array('tag_title' => $tag_title,'tag_desc' => $tag_description);
         DB::table('outdoor_workout_locations')->insert($values);
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function deleteWorkoutLocation($id)
    {
        try {
         DB::table('outdoor_workout_locations')
        ->where('id', $id)
        ->delete();
         
         } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getPaypalInfo()
    {
       try {
        $select = 'SELECT * FROM payment_accounts WHERE user_id = '.session('admin_userid');
        $data = DB::select($select);
        if(!empty($data)){
             return $data;
        }else{
            return '';
        }
         } catch (Exception $e) {
            echo $e->getMessage();
        } 
    }
    
    public function addPayPalInfo($request) {
        try {
            $check = $this->getPaypalInfo();
            if (empty($check)) {
                $values = array('user_id' => session('admin_userid'), 'name' => $request->account_holder_name,
                    'account_signature' => $request->account_holder_api_signature, 'account_email' => $request->account_holder_email,
                    'account_api' => $request->account_holder_api_username, 'account_password' => $request->account_holder_api_password);
                DB::table('payment_accounts')->insert($values);
            } else {
                DB::table('payment_accounts')
                        ->where('user_id', session('admin_userid'))
                        ->update(['name' => $request->account_holder_name, 'account_signature' => $request->account_holder_api_signature,
                            'account_email' => $request->account_holder_email, 'account_api' => $request->account_holder_api_username,
                            'account_password' => $request->account_holder_api_password]);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
