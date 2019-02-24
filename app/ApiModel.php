<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class ApiModel extends Model {

    public function AuthAction($email = "", $password = "") {
        $password = md5($password);

        $sql = "SELECT ud.*,u.id as user_primary_id,u.profile_id,u.username,u.password,u.status "
                . "FROM user_details ud LEFT JOIN user_credentials u ON(ud.id=u.user_id) "
                . "WHERE u.username = '" . $email . "' AND u.password = '" . $password . "' "
                . "AND u.status = 1";

        $data = DB::select($sql);
        return $data;
    }

    public function getEmailCount($email) {

        try {
            $query_uesr = 'SELECT COUNT(id) AS total_mail_no FROM user_credentials WHERE username="' . $email . '"';
            $data = DB::select($query_uesr);
            $total_mail_no = $data[0]->total_mail_no;
            return $total_mail_no;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getUserProfiles() {
        try {
            
            $profile = 'SELECT id,profile FROM user_profiles WHERE id != 1';
            $data = DB::select($profile);
            return $data;
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getBasicInfo($id, $profile_id)
    {
        try {
            if($profile_id == 2 || $profile_id == 5)
            {
                $select = 'SELECT ud.id,uc.profile_id,uc.username,ud.first_name,ud.last_name,ud.date_of_birth,ud.gender,ud.profile_heading as about_me,ud.looking_tags,ud.video_link,uf.fitness_budget,uf.allowance_expectations,ud.profile_picture,ul.location FROM user_details ud INNER JOIN user_credentials uc ON(uc.user_id=ud.id) INNER JOIN user_profiles up ON(up.id=uc.profile_id)  LEFT JOIN user_fields uf ON(uf.user_id=ud.id) LEFT JOIN user_locations ul ON(ul.user_id =ud.id AND ul.is_primary=1) WHERE ud.id=' . $id . '';
            }
            else if($profile_id == 3 || $profile_id == 4)
            {
                $select = 'SELECT ud.id,uc.profile_id,uc.username,ud.first_name,ud.last_name,ud.date_of_birth,ud.gender,ud.profile_heading as about_me,ud.looking_tags,ud.video_link,uf.rate_expectations,uf.rate,uf.rate_description,ud.profile_picture,ul.location FROM user_details ud INNER JOIN user_credentials uc ON(uc.user_id=ud.id) INNER JOIN user_profiles up ON(up.id=uc.profile_id)  LEFT JOIN user_fields uf ON(uf.user_id=ud.id) LEFT JOIN user_locations ul ON(ul.user_id =ud.id AND ul.is_primary=1) WHERE ud.id=' . $id . '';
            }
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function editUserBasicInfo($request, $user_id, $profile_id)
    {
        try {
            
            if (isset($request->looking_for) && !empty($request->looking_for)) {               
                
                $looking_for_json = $request->looking_for;
                $looking_for = json_decode($looking_for_json);
                
                foreach($looking_for as $value)
                {
                    $looking_for_val[]=$value->looking_tag;
                }
                
                $looking_for = implode('^', $looking_for_val);

                $sql = DB::table('user_details')->where('id', $user_id)->update([
                    'looking_tags' => $looking_for
                ]);
                
            }

            else if(isset($request->user_name,$request->dob,$request->profile_heading,$request->gender))
            {
                $sql = DB::table('user_details')->where('id', $user_id)->update([
                    'first_name' => $request->user_name,
                    'date_of_birth' => date('Y-m-d', strtotime($request->dob)),
                    'gender' => $request->gender,
                    'profile_heading' => $request->profile_heading
                ]);
            }

            else if(isset($request->about_me))
            {
                $sql = DB::table('user_details')->where('id', $user_id)->update([
                    'about_me' => $request->about_me
                ]);
            }
            else if(isset($request->fitness_budget,$request->allowance_expectations))
            {
                DB::table('user_fields')
                        ->where('user_id', $user_id)
                        ->update(array(
                            'fitness_budget' => $request->fitness_budget, 
                            'allowance_expectations' => $request->allowance_expectations
                        ));
            }
            
            else if(isset($request->rate_expectations,$request->rate,$request->rate_description))
            {
            $sql = DB::table('user_fields')
                ->where('user_id', $user_id)->first();

            if (count($sql) == 0)
            {
                if($profile_id == 3 || $profile_id == 4)
                {
                    DB::table('user_fields')->insert(
                        [
                            "user_id" => $user_id,
                            "rate_expectations" => $request->rate_expectations,
                            "rate" => $request->rate,
                            "rate_description" => $request->rate_description
                        ]
                    );
                }
            }
            else
            {
                if($profile_id == 3 || $profile_id == 4)
                {
                    DB::table('user_fields')
                        ->where('user_id', $user_id)
                        ->update(array('rate_expectations' => $request->rate_expectations, 'rate' => $request->rate, 'rate_description' => $request->rate_description));
                }
            }
            }

            /*    
            if (count($sql) == 0) {
                if($profile_id == 2 || $profile_id == 5)
                {
                    DB::table('user_fields')->insert(
                        [
                            "user_id" => $user_id,
                            "fitness_budget" => $request->fitness_budget,
                            "allowance_expectations" => $request->allowance_expectations,
                        ]
                    );
                }
                else if($profile_id == 3 || $profile_id == 4)
                {
                    DB::table('user_fields')->insert(
                        [
                            "user_id" => $user_id,
                            "rate_expectations" => $request->rate_expectations,
                            "rate" => $request->rate,
                            "rate_description" => $request->rate_description,
                        ]
                    );
                }
            } else {
                if($profile_id == 2 || $profile_id == 5)
                {
                    DB::table('user_fields')
                        ->where('user_id', $user_id)
                        ->update(array('fitness_budget' => $request->fitness_budget, 'allowance_expectations' => $request->allowance_expectations));
                }
                else if($profile_id == 3 || $profile_id == 4)
                {
                    DB::table('user_fields')
                        ->where('user_id', $user_id)
                        ->update(array('rate_expectations' => $request->rate_expectations, 'rate' => $request->rate, 'rate_description' => $request->rate_description));
                }
            }
            */

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editUserFitnessInfo($request, $user_id, $profile_id)
    {
        try {

            if(isset($request->avg_swim_time,$request->avg_bike_speed,$request->avg_run_time))
            {
            $sql = DB::table('user_fields')->where('user_id', $user_id)->first();
            
            if (count($sql) == 0)
            {
                $values = array('user_id' => $user_id, 'avg_swim_time' => $request->avg_swim_time, 'avg_bike_speed' => $request->avg_bike_speed, 'avg_run_time' => $request->avg_run_time);
                DB::table('user_fields')->insert($values);
            }
            else
            {
                DB::table('user_fields')
                ->where('user_id', $user_id)
                ->update(array('avg_swim_time' => $request->avg_swim_time, 'avg_bike_speed' => $request->avg_bike_speed, 'avg_run_time' => $request->avg_run_time));
            }      
            } 
            
            else if(isset($request->training_philosophy))
            {
            $sql = DB::table('user_fields')->where('user_id', $user_id)->first();
            
            if (count($sql) == 0)
            {
                $values = array('user_id' => $user_id, 'training_philosophy' => $request->training_philosophy);
                DB::table('user_fields')->insert($values);
            }
            else
            {
                DB::table('user_fields')
                ->where('user_id', $user_id)
                ->update(array('training_philosophy' => $request->training_philosophy));
            }      
            }

            else if(isset($request->experience))
            {
            $sql = DB::table('user_fields')->where('user_id', $user_id)->first();
            
            if (count($sql) == 0)
            {
                $values = array('user_id' => $user_id, 'experience' => $request->experience);
                DB::table('user_fields')->insert($values);
            }
            else
            {
                DB::table('user_fields')
                ->where('user_id', $user_id)
                ->update(array('experience' => $request->experience));
            }      
            }

            else if(isset($request->certifications))
            {
            $sql = DB::table('user_fields')->where('user_id', $user_id)->first();
            
            if (count($sql) == 0)
            {
                $values = array('user_id' => $user_id, 'certifications' => $request->certifications);
                DB::table('user_fields')->insert($values);
            }
            else
            {
                DB::table('user_fields')
                ->where('user_id', $user_id)
                ->update(array('certifications' => $request->certifications));
            }      
            }

            else if(isset($request->workout_info_location))
            {

                $workout_info_location_json = $request->workout_info_location;
                $workout_info_location = json_decode($workout_info_location_json);
                
                foreach($workout_info_location as $value)
                {
                    $workout_info_location_val[]=$value->id;
                }
                
                $request->workout_info_location = implode('^', $workout_info_location_val);                

            $sql = DB::table('user_fields')->where('user_id', $user_id)->first();
            
            if (count($sql) == 0)
            {
                $values = array('user_id' => $user_id, 'workout_info_location' => $request->workout_info_location);
                DB::table('user_fields')->insert($values);
            }
            else
            {
                DB::table('user_fields')
                ->where('user_id', $user_id)
                ->update(array('workout_info_location' => $request->workout_info_location));
            }      
            }

            else if(isset($request->fitness_level))
            {
                if (!empty($request->gym_memberships)) {
                
                    $gym_memberships_json = $request->gym_memberships;
                    $gym_memberships = json_decode($gym_memberships_json);
    
    
                    foreach($gym_memberships as $value)
                    {
                       $gym_memberships_val[]=$value->id;
                    }
    
                    $gym_memberships = implode('^', $gym_memberships_val);
                }  
                if (!empty($request->outdoor_locations)) {
                
                    $outdoor_locations_json = $request->outdoor_locations;
                    $outdoor_locations = json_decode($outdoor_locations_json);
    
    
                    foreach($outdoor_locations as $value)
                    {
                       $outdoor_locations_val[]=$value->id;
                    }
    
                    $outdoor_locations = implode('^', $outdoor_locations_val);
                }
                if (!empty($request->scheduled_races)) {
                    $scheduled_races_json = $request->scheduled_races;
                    $scheduled_races = json_decode($scheduled_races_json);
    
    
                    foreach($scheduled_races as $value)
                    {
                       $scheduled_races_val[]=$value->id;
                    }
    
                    $scheduled_races = implode('^', $scheduled_races_val);
                }

                $sql = DB::table('user_fields')->where('user_id', $user_id)->first();
            
                if (count($sql) == 0)
                {
                    $values = array('user_id' => $user_id, 'fitness_level' => $request->fitness_level, 'fitness_goals' => $request->fitness_goals, 'gym_memberships' => $gym_memberships, 'outdoor_locations' => $outdoor_locations, 'personal_trainers' => $request->personal_trainers, 'athletic_achievements' => $request->athletic_achievements, 'scheduled_races' => $scheduled_races, 'medical_issues' => $request->medical_issues, 'fitness_budget' => $request->fitness_budget);
                    DB::table('user_fields')->insert($values);
                }
                else
                {
                    DB::table('user_fields')
                    ->where('user_id', $user_id)
                    ->update(array('fitness_level' => $request->fitness_level, 'fitness_goals' => $request->fitness_goals, 'gym_memberships' => $gym_memberships, 'outdoor_locations' => $outdoor_locations, 'personal_trainers' => $request->personal_trainers, 'athletic_achievements' => $request->athletic_achievements, 'scheduled_races' => $scheduled_races, 'medical_issues' => $request->medical_issues, 'fitness_budget' => $request->fitness_budget));
                }           
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getFitnessInfo($id, $profile_id)
    {
        try {
            if($profile_id == 2 || $profile_id == 5)
            {
                $select = 'SELECT uf.user_id,uc.profile_id,uf.fitness_level,uf.fitness_goals,uf.gym_memberships,uf.outdoor_locations,uf.personal_trainers,uf.athletic_achievements,uf.scheduled_races,uf.avg_swim_time,uf.avg_bike_speed,uf.avg_run_time,uf.medical_issues,uf.triathlon_club FROM user_fields uf LEFT JOIN user_credentials uc ON(uc.user_id=uf.user_id) WHERE uf.user_id=' . $id . '';
            }
            else if($profile_id == 3 || $profile_id == 4)
            {
                $select = 'SELECT uf.user_id,uc.profile_id,uf.training_philosophy,uf.experience,uf.certifications,uf.fitness_level,uf.fitness_goals,uf.gym_memberships,uf.outdoor_locations,uf.personal_trainers,uf.athletic_achievements,uf.scheduled_races,uf.workout_info_location,uf.avg_swim_time,uf.avg_bike_speed,uf.avg_run_time,uf.medical_issues,uf.triathlon_club FROM user_fields uf LEFT JOIN user_credentials uc ON(uc.user_id=uf.user_id) WHERE uf.user_id=' . $id . '';
            }
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getGroupWorkoutInfoAndLocations()
    {
         try {
            $select = 'SELECT * FROM group_workout_info_locations';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
     public function getGymMembershipInfo()
    {
        try {
            $select = 'SELECT * FROM gym_memberships';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getGymOutdoorWorkOutLocations()
    {
        try {
            $select = 'SELECT * FROM outdoor_workout_locations';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    
    public function getScheduledRaces()
    {
        try {
            $select = 'SELECT * FROM scheduled_races';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
      public function insertUpdateUserDescription($request, $user_id)
    {
        try {
            
//            $looking_for = implode('|', $request->looking_for);
                $looking_for="";
                if (!empty($request->looking_for)) {

                    $looking_for_json = $request->looking_for;
                    $looking_for = json_decode($looking_for_json);

                    foreach($looking_for as $value)
                    {
                       $looking_for_val[]=$value->looking_tag;
                    }

                    $looking_for = implode('|', $looking_for_val);
                }
                
                if(isset($request->about_me))
                {
                    DB::table('user_details')
                    ->where('id', $user_id)
                    ->update(array('about_me' => $request->about_me));
                }
                
                if(isset($request->look_up))
                {
                    DB::table('user_details')
                    ->where('id', $user_id)
                    ->update(array('look_up' => $request->look_up));
                    
                    $result = DB::select("SELECT * FROM user_fields where user_id='$user_id'");
                    
                    if(!empty($result))
                    {
                         $valu2 = array('user_id' => $user_id, 'looking_for' => $looking_for);
                          DB::table('user_fields')
                                 ->where('user_id', $user_id)
                                 ->update($valu2);
                    }
                    else
                    {
                         $valu2 = array('user_id' => $user_id, 'looking_for' => $looking_for);
                         DB::table('user_fields')->insert($valu2);
                    }
                }
                return 1;
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getAllUsersByLocation($request,$user_id){
         try {
             
             $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $result = [];
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $radius = 15;
        if($latitude != '' && $longitude != ''){
         $radius_query = "SELECT `user_id`,
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
            COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
            FROM `user_locations` ul  WHERE
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) )
            * COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 < " . $radius." AND is_primary = 1 AND ul.user_id !=$user_id";
         
           $nearby = DB::select($radius_query);          
           if(!empty($nearby)){         
                foreach ($nearby as $trainers_obj) { 
                     if ($trainers_obj->user_id != "") {
                     $trainers[] = $trainers_obj->user_id;
              } 
                if (!empty($trainers)) {
                    $trainers_user_id = implode(',', $trainers);
                }
                
                 if ($trainers_obj->distance != '') { 
                        $trainers_distance[$trainers_obj->user_id] = $trainers_obj->distance;
                    }else{
                        $trainers_distance[$trainers_obj->user_id] = 0;
                    }
                }
                
                $select = "SELECT uc.user_id,up.profile as profile_type,ul.location as primary_location,ud.profile_picture,ud.id,uc.profile_id,uc.username, CONCAT(ud.first_name,' ',ud.last_name) AS name, ud.date_of_birth,ud.gender,ud.about_me,ud.looking_tags,ud.video_link,ud.online_status,ul.latitude,ul.longitude "
                . "FROM user_details ud "
                . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                . "WHERE ud.id IN($trainers_user_id) AND ud.id!=$user_id ";
                
               if(isset($request->profile_id) && $request->profile_id != ''){
                   $select .= " AND uc.profile_id =".$request->profile_id;
               }
                
                
               $result = DB::select($select);
               foreach($result as $index => $d){
                   if ($trainers_distance[$d->user_id] != "") {
                        $result[$index]->trainer_distance = number_format($trainers_distance[$d->user_id],2)." km";
                    } else {
                        $result[$index]->trainer_distance = '0'.' km';
                    }
                   if($d->profile_picture != ''){
                   $result[$index]->profile_picture = url("public/uploads/user_profile_pictures". $d->profile_picture);
                } else {
                   $result[$index]->profile_picture = '';
               }
           }
           if(!empty($result)){
            foreach($result as $key1 => $tobj1){
                foreach($result as $key2 => $tobj2){
                    if($tobj1->trainer_distance != $tobj2->trainer_distance){
                        $ar[$tobj1->trainer_distance] = $key1;
                    }
                }
            }
                    
                    if(!empty($ar)){
                        ksort($ar);                

                    foreach ($ar as $dis => $k){
                        $final[] = $result[$k];
                    }
                    } else {
                        $final = $result;
                    }
                }
                $response['result'] = $final;
                $response['lat'] = $latitude;
                $response['lon'] = $longitude;
                $response['success'] = 1;
                unset($response['msg'] );
                
           }else{
               $response['success'] = 0;
               $response['msg'] = 'No trainers found';
           }
    
      }else{
                $response['success'] = 0;
                $response['msg'] = 'Please fill up all the fields';
      }
      return $response;
      
    } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getTableValueByID($table="",$id="")
    {
        try {
            if($table!="" && $id!=""){
                $select = 'SELECT tag_title FROM '.$table.' WHERE id = '.$id;
                $data = DB::select($select);

                if(isset($data[0]->tag_title) && $data[0]->tag_title!="")
                    return $data[0]->tag_title;
                else
                    return "";
            } else {
                    return "";
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    
    public function getAllUsers($profile_id,$user_id)
    {
        try {
            $response = [
                'success' => 0,
                'msg' => ''
            ];
            
            
            $sql = DB::select("SELECT * FROM user_locations WHERE user_id =". $user_id." AND is_primary=1 ");
            
            if(!empty($sql)){
            
            $radius= 15;    
            $result =[]; 
            $latitude = $sql[0]->latitude;
            $longitude = $sql[0]->longitude;

            $radius_query = "SELECT `user_id`,
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
            COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
            FROM `user_locations` ul WHERE
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) )
            * COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 < " . $radius." AND is_primary = 1 AND ul.user_id != $user_id";
         
           $nearby = DB::select($radius_query);
           
           if(!empty($nearby)){
                foreach ($nearby as $trainers_obj) { 
                     if ($trainers_obj->user_id != "") { 
                     $trainers[] = $trainers_obj->user_id;
                     }
                     if ($trainers_obj->distance != "") { 
                        $trainers_distance[$trainers_obj->user_id] = $trainers_obj->distance;
                    }else{
                        $trainers_distance[$trainers_obj->user_id] = '';
                    }
              } 
                if (!empty($trainers)) {
                    $trainers_user_id = implode(',', $trainers);
                    
                    $select = "SELECT uc.user_id,up.profile as profile_type,ul.location as primary_location,ud.id,ud.profile_picture,uc.profile_id,uc.username, CONCAT(ud.first_name,' ',ud.last_name) AS name, ud.date_of_birth,ud.gender,ud.about_me,ud.looking_tags,ud.video_link,ud.online_status,ul.latitude,ul.longitude "
                . "FROM user_details ud "
                . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                . "WHERE ud.id IN($trainers_user_id) AND ud.id!=$user_id AND uc.profile_id = $profile_id";
                    
                     $result = DB::select($select);
                     //print_r($result);
                     //exit;
                     if(!empty($result)){
                     foreach($result as $index => $d){
                            if (isset($trainers_distance[$d->user_id]) && $trainers_distance[$d->user_id] != "") {
                                $result[$index]->trainer_distance = number_format($trainers_distance[$d->user_id],2);
                            } else {
                                $result[$index]->trainer_distance = 0;
                            }
                            
                            if ($result[$index]->profile_picture != "")
                            {
                                $result[$index]->profile_picture = url("public/uploads/user_profile_pictures/" . $result[$index]->profile_picture);
                            }
                            else
                            {
                                $result[$index]->profile_picture = '';
                            }
                        }
                    }
                    if(!empty($result)){
                    foreach($result as $key1 => $tobj1){
                        foreach($result as $key2 => $tobj2){
                            if($tobj1->trainer_distance != $tobj2->trainer_distance){
                                $ar[$tobj1->trainer_distance] = $key1;
                            }
                        }
                    }
                    
                    if(!empty($ar)){
                        ksort($ar);                

                    foreach ($ar as $dis => $k){
                        $final[] = $result[$k];
                    }
                    } else {
                        $final = $result;
                    }
                }
                 
                 $response['result'] = $final;
                 $response['lat'] = $latitude;
                 $response['lon'] = $longitude;
                }
              }else{
                 $response['success'] = 0;
                 $response['msg'] = 'No trainers found';
              }
            }else{
                $response['success'] = 0;
                $response['msg'] = "User doesn't have a primary address";
            }  
            return $response;  
             
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getUserDetails($id)
    {
        try
        {
            $select="SELECT ud.about_me,ud.look_up,uf.looking_for FROM user_details ud LEFT JOIN user_fields uf ON(ud.id=uf.user_id) where ud.id=".$id;
            $result=DB::select($select);
            return $result;
        }
         catch (Exception $e) {
            echo $e->getMessage();
        } 
    }
    
    public function getPrice($user_id)
    {
        try {
            
            $sql = DB::table('user_fields')->where('user_id', $user_id)->first();
            if (count($sql) != 0)
            {
                $select = 'SELECT rate FROM user_fields WHERE user_id = '.$user_id;
                $data = DB::select($select);
                return $data[0]->rate;
            }
            else
            {
                return '0.00';
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function countFav($user_id, $trainer_id) {
        try {
            $sql = 'SELECT * FROM favorite_users WHERE user_id=' .$user_id. ' AND favorite_profile = '.$trainer_id;
            $data = DB::select($sql);
            if(!empty($data)){
                return 1;
            }else{
                return 0;
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function addFavorite($user_id, $trainer_id) {
        try {
           $data['user_id'] = $user_id; 
           $data['favorite_profile'] = $trainer_id;            
           $sql =   DB::table('favorite_users')->insert($data);
            if($sql){
                return 1;
            }else{
                return 0;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function deleteFavorite($user_id, $trainer_id) {
        try {
           DB::table('favorite_users')-> where('user_id', $user_id)
                                       ->where('favorite_profile',$trainer_id)
                                       ->delete();
            return 2;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getTrainerBasicInfo($user_id, $id)
    {
        try {
           
            $viewed_me = DB::select("SELECT * FROM viewed_users WHERE user_id = ".$user_id. " AND viewed_profile = $id");
            if(empty($viewed_me)){ 
                DB::table('viewed_users')->insert(
                    [
                        "user_id" => $user_id,
                        "viewed_profile" => $id,
                    ]
                );
            }
            $select = 'SELECT ud.id as user_id,up.profile as profile_type,uc.profile_id,uc.username,uc.status,ud.first_name,ud.last_name,ud.date_of_birth,ud.gender,ud.about_me,ud.look_up,ud.looking_tags,ud.video_link,uf.looking_for, uf.training_philosophy, uf.experience, uf.certifications, uf.body_type, uf.height, uf.fitness_level, uf.fitness_goals, uf.scheduled_races, uf.avg_swim_time, uf.avg_bike_speed, uf.avg_run_time, uf.athletic_achievements, uf.gym_memberships, uf.outdoor_locations, uf.personal_trainers, uf.medical_issues, uf.relationship, uf.children, uf.language, uf.ethnicity, uf.workout_info_location, uf.rate_expectations, uf.rate, uf.rate_description, uf.fitness_budget, uf.allowance_expectations, uf.smokes, uf.drinks, uf.education, uf.occupation, uf.income, uf.net_worth, uf.lifestyle, uf.triathlon_club,ud.profile_picture,ud.last_active,ud.member_since,ul.location FROM user_details ud INNER JOIN user_credentials uc ON(uc.user_id=ud.id) INNER JOIN user_profiles up ON(up.id=uc.profile_id)  LEFT JOIN user_fields uf ON(uf.user_id=ud.id) INNER JOIN user_locations ul ON(ul.user_id =ud.id AND ul.is_primary=1) WHERE ud.id=' . $id . '';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function addCreditDetails($request, $user_id, $trainer_id, $transactionid, $order_no)
    {
        $user_info = $request->userInfo;
        $credit_obj = new UserDetail();
        //$expiary = explode("/", $request->expiary);
        $card_brand = $credit_obj->validatecard($request->card_no);
        
        $last_name = '';
        $address_line2 = '';
        
        if(isset($request->billing_lastname))
        {
            $last_name = $request->billing_lastname;
        }
        if(isset($request->address_line2))
        {
            $address_line2 = $request->address_line2;
        }

        try {
            
            if(isset($request->card_id))
            {
                DB::table("payment_accounts")
                ->where('id', $request->card_id)
                ->update([
                    'billing_firstname' => $request->billing_firstname,
                    'billing_lastname' => $last_name,
                    'cvv_no' => $request->cvv,
                    'billing_address' => $request->address_line1 . " " . $address_line2,
                    'country' => $request->country,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                    'phone_number' => $request->phone_number,
                ]); 
            }
            else
            {
                DB::table("payment_accounts")->insert([
                    'user_id' => $user_id,
                    'card_no' => $request->card_no,
                    'name' => $request->name_on_card,
                    'expiry_month' => $request->exp_month,
                    'expiry_year' => $request->exp_year,
                    'billing_firstname' => $request->billing_firstname,
                    'billing_lastname' => $last_name,
                    'cvv_no' => $request->cvv,
                    'billing_address' => $request->address_line1 . " " . $address_line2,
                    'country' => $request->country,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                    'phone_number' => $request->phone_number,
                    'card_brand' => $card_brand
                ]);
            }

            $user_requests_id = DB::table("user_requests")->insertGetId([
                'user_id' => $user_id,
                'trainer_id' => $trainer_id,
                'status' => 0
            ]);

            DB::table("user_payments")->insert([
                'user_id' => $user_id,
                'passcode' => $request->passcode,
                'request_id' => $user_requests_id,
                'trainer_id' => $trainer_id,
                'payment_date' => date('Y-m-d H:i:s'),
                'completion_date' => null,
                'amount' => $request->amount,
                'order_no' => $order_no,
                'transaction_id' => $transactionid,
                'transaction_type' => 'Credit Card'
            ]);
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function searchFilter($request, $user_id)
    {
        $searchArr = $request->all();
        $final = [];
        $id = $user_id;
        $sql = '';
        $sql_join = '';
        $sql_where = '';
        $sql1 = DB::select("SELECT * FROM user_locations WHERE user_id =" . $id . " AND is_primary=1 ");
        //print_r($searchArr);
        //exit;
        if (!empty($sql1)) {

            $radius = 15;

            $latitude = $sql1[0]->latitude;
            $longitude = $sql1[0]->longitude;

            $radius_query = "SELECT `user_id`,
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
            COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
            FROM `user_locations` ul WHERE
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) )
            * COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 < " . $radius . " AND is_primary = 1 AND ul.user_id != " . "$id" . " ";

            $nearby = DB::select($radius_query);
            
            if (!empty($nearby)) {
                foreach ($nearby as $trainers_obj) {
                    if ($trainers_obj->user_id != "") {
                        $trainers[] = $trainers_obj->user_id;
                    }
                    if ($trainers_obj->distance != "") {
                        $trainers_distance[$trainers_obj->user_id] = $trainers_obj->distance;
                    } else {
                        $trainers_distance[$trainers_obj->user_id] = '';
                    }
                }
                if (!empty($trainers)) {
                    $trainers_user_id = implode(',', $trainers);
                }
            }
        }
        $sql_select = "SELECT DISTINCT uc.user_id,up.profile as profile_type,ul.location as primary_location"
                      . ",ud.profile_picture,ud.first_name AS name"
                      . ",ud.gender ";

        $sql_join = "FROM user_details ud "
                    . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                    . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                    . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) ";

        $sql_where = " WHERE ud.id IN($trainers_user_id) AND ud.id!=$id ";

        if (isset($searchArr['gender']) && !empty($searchArr['gender']))
        {
            $gender = json_decode($searchArr['gender']);
            foreach($gender as $value)
            {
               $gender_val[]=$value->val;
            }
            $final_gender = implode("','", $gender_val);
            
            $sql_where .= " AND ud.gender IN('$final_gender') ";
        }
        
//        if (isset($searchArr['user_type']) && $searchArr['user_type'] != '') {
//            $final_user_type = implode(',', $searchArr['user_type']);
//            $sql_where .= " AND uc.profile_id IN($final_user_type) ";
//        }
        
        if (isset($searchArr['option']) || isset($searchArr['children']) || isset($searchArr['smoking']) || isset($searchArr['education']) || isset($searchArr['language']) || isset($searchArr['looking_for']) || isset($searchArr['height']) || isset($searchArr['rate']) || isset($searchArr['drinking']))
        {
            $sql_join .= " INNER JOIN user_fields uf ON(uf.user_id=ud.id) ";
            
            if (isset($searchArr['rate']) && $searchArr['rate'] != '')
            {
                $sql_where .= " AND uf.rate <= " . $searchArr['rate'];
            }
            if (isset($searchArr['option']) && !empty($searchArr['option']))
            {
                $option = json_decode($searchArr['option']);
                
                foreach($option as $value)
                {
                   $option_val[]=$value->val;
                }
                
                if (in_array("Scheduled Races", $option_val)) {
                    $sql_where .= " AND uf.scheduled_races IS NOT NULL";
                }
                if (in_array("Achievements", $option_val)) {
                    $sql_where .= " AND uf.athletic_achievements IS NOT NULL";
                }
                if (in_array("Gym Memberships", $option_val)) {
                    $sql_where .= " AND uf.gym_memberships IS NOT NULL";
                }
                if (in_array("Outdoor Work-Out Location", $option_val)) {
                    $sql_where .= " AND uf.outdoor_locations IS NOT NULL";
                }
                if (in_array("Photos", $option_val)) {
                    $sql_join .= " INNER JOIN user_photos upt ON(upt.user_id=ud.id) ";
                    $sql_where .= " AND upt.user_id IN($trainers_user_id)";
                }
                if (in_array("Viewed Me", $option_val) || in_array("Viewed", $option_val)) { 
                    $sql_join .= " INNER JOIN viewed_users uv ON(uv.user_id=ud.id) ";
                    if(in_array("Viewed", $option_val) && in_array("Viewed Me", $option_val)){
                    $sql_where .= " AND uv.user_id = $id OR uv.viewed_profile = $id";
                    }else{
                    if(in_array("Viewed Me", $option_val)){
                    $sql_where .= " AND uv.viewed_profile = $id";
                    }
                    if(in_array("Viewed", $option_val)){
                    $sql_where .= " AND uv.user_id = $id";
                    }
                  }
                }
                if (in_array("Favorited Me", $option_val) || in_array("Favorited", $option_val)) { 
                    $sql_join .= " INNER JOIN favorite_users fu ON(fu.user_id=ud.id) ";
                    if(in_array("Favorited", $option_val) && in_array("Favorited Me", $option_val)){
                    $sql_where .= " AND fu.user_id = $id OR fu.favorite_profile = $id";
                    }else {
                    if(in_array("Favorited Me", $option_val)){
                    $sql_where .= " AND fu.favorite_profile = $id";
                    }
                    if(in_array("Favorited", $option_val)){
                    $sql_where .= " AND fu.user_id = $id";
                    }
                   }
                }
            }
            if (isset($searchArr['height']) && $searchArr['height'] != '') {
                $feet = floor($searchArr['height'] / 12);
                $inches = $searchArr['height'] % 12;
                $sql_where .= " AND uf.height BETWEEN '0' AND '" . $feet . "\'" . $inches . '\"' . "'";
            }
            if (isset($searchArr['smoking']) && !empty($searchArr['smoking'])) {
                $final_smoking = implode("','", $searchArr['smoking']);
                $sql_where .= " AND uf.smokes IN('$final_smoking') ";
            }
            if (isset($searchArr['drinking']) && !empty($searchArr['drinking'])) {
                $final_drinking = implode("','", $searchArr['drinking']);
                $sql_where .= " AND uf.drinks IN('$final_drinking') ";
            }
            if (isset($searchArr['education']) && !empty($searchArr['education'])) {
                $final_education = implode("','", $searchArr['education']);
                $sql_where .= " AND uf.education IN('$final_education') ";
            }
            if (isset($searchArr['children']) && $searchArr['children'] != '') {
                $final_children = implode(',', $searchArr['children']);
                $sql_where .= " AND uf.children IN($final_children) ";
            }
            if (isset($searchArr['language']) && !empty($searchArr['language'])) {
                $final_gender = implode("','", $searchArr['language']);
                $sql_where .= " AND uf.language IN('$final_gender') ";
            }
            if (isset($searchArr['allowance']) && !empty($searchArr['allowance'])) {
                if (count($searchArr['allowance']) == 1) {
                    if ($searchArr['allowance'][0] == 'Yes') {
                        $sql_where .= " AND uf.allowance_expectations IS NOT NULL ";
                    } else {
                        $sql_where .= " AND uf.allowance_expectations IS NULL ";
                    }
                } else {
                    $sql_where .= " AND uf.allowance_expectations IS NULL OR uf.allowance_expectations IS NOT NULL ";
                }
            }
            if (isset($searchArr['looking_for']) && !empty($searchArr['looking_for'])) {
                $sql_where .= " AND (";
                foreach ($searchArr['looking_for'] as $val) {
                    $sql_where .= " uf.looking_for LIKE('%$val%') OR";
                }
                $sql_where = rtrim($sql_where, 'OR');
                $sql_where .= ")";
            }
//            if(isset($searchArr['dont_looking_for']) && !empty($searchArr['dont_looking_for'])){
//                 $sql_where .= " AND (";
//                foreach($searchArr['dont_looking_for'] as $val){
//                     $sql_where .= " uf.looking_for NOT LIKE('%$val%') OR";
//                }
//                $sql_where =  rtrim($sql_where,'OR');
//                $sql_where .= ")"; 
//            }
        }

        $sql_query = $sql_select . $sql_join . $sql_where;
        //echo $sql_query;
        //exit;
        
        $select = DB::select($sql_query);
        //print_r($select);
        //exit;
        return $select;
    }
}
