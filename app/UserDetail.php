<?php

namespace App;

use App\Services\Image;
use DB;
use File;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Input;

class UserDetail extends Model {

    public $timestamps = false;
    protected $table = 'user_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    //protected $hidden = [
    //'password', 'remember_token',
    //];

    public function getUserData() {
        try {
            $select = 'SELECT ud.id,ud.athlete_type,ud.first_name,ud.last_name,up.profile FROM user_details ud INNER JOIN user_credentials uc ON(uc.user_id=ud.id) INNER JOIN user_profiles up ON(up.id=uc.profile_id) LEFT JOIN user_fields uf ON(uf.user_id=ud.id) WHERE uc.profile_id!=1';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getBasicInfo($id) {
        try {
            $select = 'SELECT ud.id,uc.profile_id,uc.username,ud.first_name,ud.last_name,ud.date_of_birth,ud.gender,ud.about_me,ud.profile_heading,ud.looking_tags,ud.video_link,uf.fitness_budget,uf.allowance_expectations,uf.rate_expectations,uf.rate,uf.rate_description,ud.profile_picture,ul.location FROM user_details ud INNER JOIN user_credentials uc ON(uc.user_id=ud.id) INNER JOIN user_profiles up ON(up.id=uc.profile_id)  LEFT JOIN user_fields uf ON(uf.user_id=ud.id) LEFT JOIN user_locations ul ON(ul.user_id =ud.id AND ul.is_primary=1) WHERE ud.id=' . $id . '';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function userOtherInfo($id) {
        try {
            $select = 'SELECT COUNT(id) AS user_field_count FROM user_fields WHERE user_id=' . $id . '';
            $data = DB::select($select);
            if ($data[0]->user_field_count == 0) {
                $user_field_arr = array('user_id' => $id);
                DB::table('user_fields')->insert($user_field_arr);
            }

            $select = 'SELECT COUNT(id) AS user_photo_count FROM user_photos WHERE user_id=' . $id . '';
            $data = DB::select($select);
            if ($data[0]->user_photo_count == 0) {
                $user_photo_arr = array('user_id' => $id);
                DB::table('user_photos')->insert($user_photo_arr);
            }

            $select = 'SELECT COUNT(id) AS user_location_count FROM user_locations WHERE user_id=' . $id . '';
            $data = DB::select($select);
            if ($data[0]->user_location_count == 0) {
                $user_location_arr = array('user_id' => $id, 'is_primary' => 1);
                DB::table('user_locations')->insert($user_location_arr);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAccountSettingsInfo($id) {
        try {
            $select = 'SELECT * FROM user_details ud INNER JOIN user_credentials uc ON(ud.id=uc.user_id) WHERE ud.id=' . $id . '';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function matchPassword($current_password, $user_id) {
        $sql = DB::select("SELECT * FROM user_credentials WHERE user_id=" . $user_id);
        $current_password1 = $sql[0]->password;

        $current_password2 = md5($current_password);
        if ($current_password1 == $current_password2) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateAccountSettingsInfo($request, $user_id) {
        try {

            $query_uesr = 'SELECT * FROM user_credentials WHERE username="' . $request->user_name . '" AND user_id != "' . $user_id . '"';
            $data = DB::select($query_uesr);

            if (count($data) == 0) {
                DB::table('user_credentials')
                        ->where('user_id', $user_id)
                        ->update(array('username' => $request->user_name, 'secret_question' => $request->sec_qus, 'secret_answer' => $request->sec_ans));

                DB::table('user_details')
                        ->where('id', $user_id)
                        ->update(array('secret_qus_ans' => $request->secutiry_question, 'online_status' => $request->online_status, 'last_active_status' => $request->last_active_status, 'view_someone' => $request->view_someone, 'favourite_someone' => $request->favourite_someone, 'join_date_status' => $request->join_date_status, 'recent_login_location' => $request->recent_login_location));

                return 1;
            } else {
                return 2;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getProfiles() {
        try {
            $select = 'SELECT * FROM user_profiles WHERE id != 1';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getTrainerBasicInfo($id) {
        try {

            $viewed_me = DB::select("SELECT * FROM viewed_users WHERE user_id = " . session('user_id') . " AND viewed_profile = $id");
            if (empty($viewed_me)) {
                DB::table('viewed_users')->insert(
                        [
                            "user_id" => session('user_id'),
                            "viewed_profile" => $id,
                        ]
                );
            }
            $select = 'SELECT ud.id as user_id,up.profile as profile_type,uc.profile_id,uc.username,ud.first_name,ud.last_name,ud.date_of_birth,ud.gender,ud.about_me,ud.look_up,ud.looking_tags,ud.video_link,uf.looking_for, uf.training_philosophy, uf.experience, uf.certifications, uf.body_type, uf.height, uf.fitness_level, uf.fitness_goals, uf.scheduled_races, uf.avg_swim_time, uf.avg_bike_speed, uf.avg_run_time, uf.athletic_achievements, uf.gym_memberships, uf.outdoor_locations, uf.personal_trainers, uf.medical_issues, uf.relationship, uf.children, uf.language, uf.ethnicity, uf.workout_info_location, uf.rate_expectations, uf.rate, uf.rate_description, uf.fitness_budget, uf.allowance_expectations, uf.smokes, uf.drinks, uf.education, uf.occupation, uf.income, uf.net_worth, uf.lifestyle, uf.triathlon_club,ud.profile_picture,ud.last_active,ud.member_since,ud.recent_login_location,ul.location FROM user_details ud INNER JOIN user_credentials uc ON(uc.user_id=ud.id) INNER JOIN user_profiles up ON(up.id=uc.profile_id)  LEFT JOIN user_fields uf ON(uf.user_id=ud.id) INNER JOIN user_locations ul ON(ul.user_id =ud.id AND ul.is_primary=1) WHERE ud.id=' . $id . '';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getUserLocation($id) {
        try {
            $select = 'SELECT * FROM user_locations ul WHERE ul.is_primary=1 AND ul.user_id=' . $id . '';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAllUsers($request, $id) {

        try {
            $final = [];
            $sql = DB::select("SELECT * FROM user_locations WHERE user_id =" . $id . " AND is_primary=1 ");

            if (!empty($sql)) {

                $radius = 15;

                $latitude = $sql[0]->latitude;
                $longitude = $sql[0]->longitude;

                $radius_query = "SELECT `user_id`,
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
            COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
            FROM `user_locations` ul WHERE
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) )
            * COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 < " . $radius . " AND is_primary = 1 AND ul.user_id != " . "$id" . " ORDER BY distance ASC";

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
                    // $select = "SELECT uf.*,up.profile as profile_type,ul.location as primary_location,ud.id,ud.profile_picture,uc.profile_id,uc.username, CONCAT(ud.first_name,' ',ud.last_name) AS name, ud.date_of_birth,ud.gender,ud.about_me,ud.looking_tags,ud.video_link,uf.fitness_budget,uf.allowance_expectations,uf.rate_expectations,uf.rate,uf.rate_description,ul.latitude,ul.longitude "
                    // . "FROM user_details ud "
                    // . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                    // . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                    // . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                    // . "LEFT JOIN user_fields uf ON(uf.user_id=ud.id) WHERE ud.id IN($trainers_user_id) AND ud.id!=$id ";
                
                    $select = "SELECT uc.user_id,up.profile as profile_type,ul.location as primary_location,ud.id,ud.profile_picture,uc.profile_id,uc.username,ud.first_name AS name, ud.date_of_birth,ud.gender,ud.about_me,ud.looking_tags,ud.video_link,ul.latitude,ul.longitude,ud.online_status "
                            . "FROM user_details ud "
                            . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                            . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                            . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                            . "WHERE ud.id IN($trainers_user_id) AND ud.id!=$id ";


                    if (isset($request->profile_id) && $request->profile_id != '') {
                        $select .= " AND uc.profile_id = " . $request->profile_id;
                    }
                    $result = DB::select($select);
                    
                    if (!empty($result)) {
                        foreach ($result as $index => $d) {
                            if (isset($trainers_distance[$d->user_id]) && $trainers_distance[$d->user_id] != "") {
                                $result[$index]->trainer_distance = number_format($trainers_distance[$d->user_id], 1);
                            } else {
                                $result[$index]->trainer_distance = 0;
                            }
                        }
                    }
                    if (!empty($result)) {
                        foreach ($result as $key1 => $tobj1) {
                            foreach ($result as $key2 => $tobj2) {
                                if ($tobj1->trainer_distance != $tobj2->trainer_distance) {
                                    $ar[$tobj1->trainer_distance] = $key1;
                                }
                            }
                        }
                        if (!empty($ar)) {
                            ksort($ar);

                            foreach ($ar as $dis => $k) {
                                $final[] = $result[$k];
                            }
                        } else {
                            $final = $result;
                        }
                    }
                    return $final;
                } else {
                    //echo "<div class='alert alert-danger text-center text-danger'> No trainers found </div>";
                }
            }
            // else {
            //     echo "<div class='text-center text-danger'> No User Primary Location found </div>";
            // }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAllUsersByLocation($request) {
        try {
            $final = [];
            $id = $request->user_id;
            $data['loc_txt'] = $request->location;

            $radius = 15;

            if ($data['loc_txt'] != "") {

                $formattedAddr = str_replace(' ', '+', $data['loc_txt']);

                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );
                $result = [];
                $latitude = "";
                $longitude = "";

                $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&address=' . $formattedAddr . '&sensor=false', false, stream_context_create($arrContextOptions));
                $maps_result = json_decode($geocodeFromAddr);


                if (!empty($maps_result)) {
                    if ($maps_result->status != 'OVER_QUERY_LIMIT') {
                        if (isset($maps_result->results[0]->geometry->location->lat))
                            $latitude = $maps_result->results[0]->geometry->location->lat;
                        if (isset($maps_result->results[0]->geometry->location->lng))
                            $longitude = $maps_result->results[0]->geometry->location->lng;
                    }
                }
            }

            $radius_query = "SELECT `user_id`,
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
            COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
            FROM `user_locations` ul  WHERE
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) )
            * COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 < " . $radius . " AND is_primary = 1 AND ul.user_id != " . "$id" . " ORDER BY distance ASC";

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

                // $select = "SELECT uf.*,up.profile as profile_type,ul.location as primary_location,ud.profile_picture,ud.id,uc.profile_id,uc.username, CONCAT(ud.first_name,' ',ud.last_name) AS name, ud.date_of_birth,ud.gender,ud.about_me,ud.looking_tags,ud.video_link,uf.fitness_budget,uf.allowance_expectations,uf.rate_expectations,uf.rate,uf.rate_description "
                // . "FROM user_details ud "
                // . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                // . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                // . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                // . "LEFT JOIN user_fields uf ON(uf.user_id=ud.id) WHERE ud.id IN($trainers_user_id) AND ud.id!=$id ";

                $select = "SELECT uc.user_id,up.profile as profile_type,ul.location as primary_location,ud.profile_picture,ud.id,uc.profile_id,uc.username, CONCAT(ud.first_name,' ',ud.last_name) AS name, ud.date_of_birth,ud.gender,ud.about_me,ud.looking_tags,ud.video_link,ud.online_status "
                        . "FROM user_details ud "
                        . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                        . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                        . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                        . "WHERE ud.id IN($trainers_user_id) AND ud.id!=$id ";


                if (isset($request->profile_id) && $request->profile_id != '') {
                    $select .= " AND uc.profile_id = " . $request->profile_id;
                }

                $result = DB::select($select);
                foreach ($result as $index => $d) {
                    if ($trainers_distance[$d->user_id] != "") {
                        $result[$index]->trainer_distance = number_format($trainers_distance[$d->user_id], 1);
                    } else {
                        $result[$index]->trainer_distance = 0;
                    }
                }

                if (!empty($result)) {
                    foreach ($result as $key1 => $tobj1) {
                        foreach ($result as $key2 => $tobj2) {
                            if ($tobj1->trainer_distance != $tobj2->trainer_distance) {
                                $ar[$tobj1->trainer_distance] = $key1;
                            }
                        }
                    }

                    if (!empty($ar)) {
                        ksort($ar);

                        foreach ($ar as $dis => $k) {
                            $final[] = $result[$k];
                        }
                    } else {
                        $final = $result;
                    }
                }

                return $final;
            } else {
                //    echo "<div class='text-center text-danger'> No trainers found </div>";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateBasicInfo($request) {
        try {
            $gender = 'Male';
            if ($request->gender == 1) {
                $gender = 'Female';
            }

            //$looking_for='';
            //$looking_for_arr = array(1=>'Personal trainers / coaches',2=>'Racing partners',3=>'Training partners',4=>'Fitness buddies',5=>'Repair / recovery specialists',6=>'All of them');
            //$looking_for=$looking_for_arr[$request->looking_for];

            if (isset($request->looking_tags)) {
                $request->looking_tags = array_keys($request->looking_tags);
                $request->looking_tags = implode('^', $request->looking_tags);
            }

            DB::table('user_details')
                    ->where('id', $request->id)
                    ->update(array('first_name' => $request->first_name, 'last_name' => $request->last_name, 'date_of_birth' => $request->date_of_birth, 'gender' => $gender, 'profile_heading' => $request->profile_heading, 'looking_tags' => $request->looking_tags, 'video_link' => $request->video_link));

            DB::table('user_fields')
                    ->where('user_id', $request->id)
                    ->update(array('fitness_budget' => $request->fitness_budget, 'allowance_expectations' => $request->allowance_expectations, 'rate_expectations' => $request->rate_expectations, 'rate' => $request->rate, 'rate_description' => $request->rate_description));

            DB::table('user_credentials')
                    ->where('user_id', $request->id)
                    ->update(array('username' => $request->username));

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editUserBasicInfo($request, $user_id) {
        try {

            if (!empty($request->looking_for)) {


                $looking_for_json = $request->looking_for;
                $looking_for = json_decode($looking_for_json);

                foreach ($looking_for as $value) {
                    $looking_for_val[] = $value->looking_tag;
                }

                $looking_for = implode('^', $looking_for_val);
            }

            $sql = DB::table('user_details')->where('id', $user_id)->update([
                'first_name' => $request->user_name,
                'date_of_birth' => date('Y-m-d', strtotime($request->dob)),
                'gender' => $request->gender,
                'about_me' => $request->about_me,
                'looking_tags' => $looking_for
            ]);


            $sql = DB::table('user_fields')
                            ->where('user_id', $user_id)->first();

            if (count($sql) == 0) {
                DB::table('user_fields')->insert(
                        [
                            "user_id" => $user_id,
                            "fitness_budget" => $request->fitness_budget,
                            "allowance_expectations" => $request->allowance_expectations,
                        ]
                );
            } else {
                DB::table('user_fields')
                        ->where('user_id', $user_id)
                        ->update(array('fitness_budget' => $request->fitness_budget, 'allowance_expectations' => $request->allowance_expectations));
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getFitnessInfo($id) {
        try {
            $select = 'SELECT uf.user_id,uc.profile_id,uf.training_philosophy,uf.experience,uf.certifications,uf.fitness_level,uf.fitness_goals,uf.gym_memberships,uf.outdoor_locations,uf.personal_trainers,uf.athletic_achievements,uf.scheduled_races,uf.workout_info_location,uf.avg_swim_time,uf.avg_bike_speed,uf.avg_run_time,uf.medical_issues,uf.triathlon_club FROM user_fields uf LEFT JOIN user_credentials uc ON(uc.user_id=uf.user_id) WHERE uf.user_id=' . $id . '';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateFitnessInfo($request) {
        try {

            $workout_info_location = "";
            $gym_memberships = "";
            $outdoor_locations = "";
            $scheduled_races = "";

            if ($request->fitness_level != "") {
                $fit_lvl_arr = explode("=", $request->fitness_level);
                $fit_lvl = $fit_lvl_arr[0];

                $prof_sql = 'SELECT profile_id FROM user_credentials WHERE user_id=' . $request->id;
                $prof_data = DB::select($prof_sql);
                $prof_id = $prof_data[0]->profile_id;

                if ($prof_id == 2 && $fit_lvl <= 3) {
                    DB::table('user_credentials')
                            ->where('user_id', $request->id)
                            ->update(array('profile_id' => 5));
                }
            }

            if (!empty($request->workout_info_location)) {
                $workout_info_location = implode('^', $request->workout_info_location);
            }

            if (!empty($request->gym_memberships)) {
                $gym_memberships = implode('^', $request->gym_memberships);
            }

            if (!empty($request->outdoor_locations)) {
                $outdoor_locations = implode('^', $request->outdoor_locations);
            }

            if (!empty($request->scheduled_races)) {
                $scheduled_races = implode('^', $request->scheduled_races);
            }

            DB::table('user_fields')
                    ->where('user_id', $request->id)
                    ->update(array('training_philosophy' => $request->training_philosophy, 'experience' => $request->experience, 'certifications' => $request->certifications, 'workout_info_location' => $workout_info_location, 'fitness_level' => $request->fitness_level, 'fitness_goals' => $request->fitness_goals, 'gym_memberships' => $gym_memberships, 'outdoor_locations' => $outdoor_locations, 'personal_trainers' => $request->personal_trainers, 'athletic_achievements' => $request->athletic_achievements, 'scheduled_races' => $scheduled_races, 'triathlon_club' => $request->triathlon_club, 'avg_swim_time' => $request->avg_swim_time, 'avg_bike_speed' => $request->avg_bike_speed, 'avg_run_time' => $request->avg_run_time, 'medical_issues' => $request->medical_issues));

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertUpdateFitnessInfo($request) {
        try {

            $workout_info_location = "";
            $gym_memberships = "";
            $outdoor_locations = "";
            $scheduled_races = "";

            if ($request->fitness_level != "") {
                $fit_lvl_arr = explode("=", $request->fitness_level);
                $fit_lvl = $fit_lvl_arr[0];

                $uid = (isset($request->user_id) && $request->user_id != '') ? $request->user_id : $request->id;
                $prof_sql = 'SELECT profile_id FROM user_credentials WHERE user_id=' . $uid;
                $prof_data = DB::select($prof_sql);
                $prof_id = $prof_data[0]->profile_id;

                if ($prof_id == 2 && $fit_lvl <= 3) {
                    DB::table('user_credentials')
                            ->where('user_id', $request->user_id)
                            ->update(array('profile_id' => 5));
                }
            }

            if (!empty($request->workout_info_location)) {
                $workout_info_location = implode('^', $request->workout_info_location);
            }

            if (!empty($request->gym_memberships)) {
                $gym_memberships = implode('^', $request->gym_memberships);
            }

            if (!empty($request->outdoor_locations)) {
                $outdoor_locations = implode('^', $request->outdoor_locations);
            }

            if (!empty($request->scheduled_races)) {
                $scheduled_races = implode('^', $request->scheduled_races);
            }

            if (isset($request->user_id) && $request->user_id != '') {
                DB::table('user_fields')
                        ->where('user_id', $request->user_id)
                        ->update(array('training_philosophy' => $request->training_philosophy, 'experience' => $request->experience, 'certifications' => $request->certifications, 'workout_info_location' => $workout_info_location, 'fitness_level' => $request->fitness_level, 'fitness_goals' => $request->fitness_goals, 'gym_memberships' => $gym_memberships, 'outdoor_locations' => $outdoor_locations, 'personal_trainers' => $request->personal_trainers, 'athletic_achievements' => $request->athletic_achievements, 'scheduled_races' => $scheduled_races, 'triathlon_club' => $request->triathlon_club, 'avg_swim_time' => $request->avg_swim_time, 'avg_bike_speed' => $request->avg_bike_speed, 'avg_run_time' => $request->avg_run_time, 'medical_issues' => $request->medical_issues));

                return 1;
            } else {
                $values = array('user_id' => $request->id, 'training_philosophy' => $request->training_philosophy, 'experience' => $request->experience, 'certifications' => $request->certifications, 'workout_info_location' => $workout_info_location, 'fitness_level' => $request->fitness_level, 'fitness_goals' => $request->fitness_goals, 'gym_memberships' => $gym_memberships, 'outdoor_locations' => $outdoor_locations, 'personal_trainers' => $request->personal_trainers, 'athletic_achievements' => $request->athletic_achievements, 'scheduled_races' => $scheduled_races, 'triathlon_club' => $request->triathlon_club, 'avg_swim_time' => $request->avg_swim_time, 'avg_bike_speed' => $request->avg_bike_speed, 'avg_run_time' => $request->avg_run_time, 'medical_issues' => $request->medical_issues);
                DB::table('user_fields')->insert($values);

                return 2;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getPersonalInfo($id) {
        try {
            $select = 'SELECT uf.user_id,uf.height,uf.body_type,uf.ethnicity,uf.occupation,uf.education,uf.relationship,uf.children,uf.smokes,uf.drinks,uf.language FROM user_fields uf WHERE uf.user_id=' . $id . '';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertUpdatePersonalInfo($request) {
        try {

            $user = DB::select("SELECT * FROM user_fields WHERE user_id = $request->id");
            if (!empty($user)) {

                DB::table('user_fields')
                        ->select()
                        ->where('user_id', $request->id)
                        ->update(array('height' => $request->height, 'body_type' => $request->body_type, 'ethnicity' => $request->ethnicity, 'occupation' => $request->occupation, 'education' => $request->education, 'relationship' => $request->relationship, 'children' => $request->children, 'smokes' => $request->smokes, 'drinks' => $request->drinks, 'language' => $request->language));
            } else {

                $values = (array('user_id' => $request->id, 'height' => $request->height, 'body_type' => $request->body_type, 'ethnicity' => $request->ethnicity, 'occupation' => $request->occupation, 'education' => $request->education, 'relationship' => $request->relationship, 'children' => $request->children, 'smokes' => $request->smokes, 'drinks' => $request->drinks, 'language' => $request->language));
                DB::table('user_fields')->insert($values);
            }
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getPhotosInfo($id) {
        try {
            $select = 'SELECT up.id,up.user_id,up.profile_image,up.is_public FROM user_photos up WHERE up.user_id=' . $id;
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getPublicPhotosInfo($id) {
        try {
            $select = 'SELECT up.id,up.user_id,up.profile_image,up.is_public FROM user_photos up WHERE up.is_public = 1 AND up.user_id=' . $id;
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getPrivatePhotosInfo($id) {
        try {
            $select = 'SELECT up.id,up.user_id,up.profile_image,up.is_public FROM user_photos up WHERE up.is_public = 0 AND up.user_id=' . $id;
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updatePhotosInfo($request) {
        if (Input::hasFile('public_photos')) {
            $public_photos = $request->file("public_photos");
            foreach ($public_photos as $public_photo) {
                $public_fileName = rand(1111, 9999) . "_" . time() . "_" . $public_photo->getClientOriginalName();
                $public_photo->move("public/uploads/user_public_photos/", $public_fileName);

                DB::table('user_photos')->insert(
                        [
                            "user_id" => $request->user_id,
                            "profile_image" => $public_fileName,
                            "is_public" => 1,
                        ]
                );
            }
        }

        if (Input::hasFile('private_photos')) {
            $private_photos = $request->file("private_photos");
            foreach ($private_photos as $private_photo) {
                $private_fileName = rand(1111, 9999) . "_" . time() . "_" . $private_photo->getClientOriginalName();
                $private_photo->move("public/uploads/user_private_photos/", $private_fileName);

                DB::table('user_photos')->insert(
                        [
                            "user_id" => $request->user_id,
                            "profile_image" => $private_fileName,
                            "is_public" => 0,
                        ]
                );
            }
        }
        return true;
    }

    public function deltePhotosInfo($photo_id) {
        DB::table('user_photos')->where('id', $photo_id)->delete();
        return true;
    }

    public function deleteUserPhotosInfo($photo_id) {
        $profile = DB::table('user_photos')->where('id', $photo_id)->get()[0];
        $old_image = $profile->profile_image;
        if ($profile->is_public == 0) {
            DB::table('user_photos')->where('id', $photo_id)->delete();
            if ($old_image != "" && File::exists(base_path() . "/public/uploads/user_private_photos/" . $old_image)) {
                File::delete(base_path() . "/public/uploads/user_private_photos/" . $old_image);
            }
        }
        if ($profile->is_public == 1) {
            DB::table('user_photos')->where('id', $photo_id)->delete();
            if ($old_image != "" && File::exists(base_path() . "/public/uploads/user_public_photos/" . $old_image)) {
                File::delete(base_path() . "/public/uploads/user_public_photos/" . $old_image);
            }
        }
        return true;
    }

    public function getLocationInfo($id) {
        try {
            $select = 'SELECT * FROM user_locations WHERE user_id=' . $id;
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addLocation($request) {
        try {
            $longitude = '';
            $latitude = '';

            if ($request->location != "") {
                $formattedAddr = str_replace(' ', '+', $request->location);
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );

                $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&address=' . $formattedAddr . '&sensor=false', false, stream_context_create($arrContextOptions));
                $maps_result = json_decode($geocodeFromAddr);

                if (!empty($maps_result->status)) {
                    if ($maps_result->status != 'OVER_QUERY_LIMIT') {
                        if (isset($maps_result->results[0]->geometry->location->lat)) {
                            $latitude = $maps_result->results[0]->geometry->location->lat;
                        }

                        if (isset($maps_result->results[0]->geometry->location->lng)) {
                            $longitude = $maps_result->results[0]->geometry->location->lng;
                        }
                    }
                }
            }
            $user_id = $request->session()->get('user_id');

            $data = DB::select("select * from user_locations where user_id=" . $user_id . " and is_primary=1");

            if (count($data) == 0) {
                DB::table('user_locations')->insert(
                        [
                            "user_id" => $request->user_id,
                            "location" => $request->location,
                            "latitude" => $latitude,
                            "longitude" => $longitude,
                            "is_primary" => 1,
                        ]
                );
            } else {
                DB::table('user_locations')->insert(
                        [
                            "user_id" => $request->user_id,
                            "location" => $request->location,
                            "latitude" => $latitude,
                            "longitude" => $longitude,
                            "is_primary" => 0,
                        ]
                );
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addLocationInfo($request, $user_id) {
        try {
            $longitude = '';
            $latitude = '';

            if ($request->location != "") {
                $formattedAddr = str_replace(' ', '+', $request->location);
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );

                $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&address=' . $formattedAddr . '&sensor=false', false, stream_context_create($arrContextOptions));
                $maps_result = json_decode($geocodeFromAddr);

                if (!empty($maps_result->status)) {
                    if ($maps_result->status != 'OVER_QUERY_LIMIT') {
                        if (isset($maps_result->results[0]->geometry->location->lat)) {
                            $latitude = $maps_result->results[0]->geometry->location->lat;
                        }

                        if (isset($maps_result->results[0]->geometry->location->lng)) {
                            $longitude = $maps_result->results[0]->geometry->location->lng;
                        }
                    }
                }
            }

            $location = DB::select("SELECT * FROM user_locations WHERE user_id = $user_id");

            if (count($location) > 0) {
                DB::table('user_locations')->insert(
                        [
                            "user_id" => $user_id,
                            "location" => $request->location,
                            "latitude" => $latitude,
                            "longitude" => $longitude,
                            "is_primary" => 0,
                        ]
                );
            } else {
                DB::table('user_locations')->insert(
                        [
                            "user_id" => $user_id,
                            "location" => $request->location,
                            "latitude" => $latitude,
                            "longitude" => $longitude,
                            "is_primary" => 1,
                        ]
                );
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editLocationInfo($request) {
        try {
            $longitude = '';
            $latitude = '';

            if ($request->location != "") {
                $formattedAddr = str_replace(' ', '+', $request->location);
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );

                $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&address=' . $formattedAddr . '&sensor=false', false, stream_context_create($arrContextOptions));
                $maps_result = json_decode($geocodeFromAddr);

                if (!empty($maps_result->status)) {
                    if ($maps_result->status != 'OVER_QUERY_LIMIT') {
                        if (isset($maps_result->results[0]->geometry->location->lat)) {
                            $latitude = $maps_result->results[0]->geometry->location->lat;
                        }

                        if (isset($maps_result->results[0]->geometry->location->lng)) {
                            $longitude = $maps_result->results[0]->geometry->location->lng;
                        }
                    }
                }
            }

            DB::table('user_locations')
                    ->where('id', $request->location_id)
                    ->update(array('location' => $request->location, 'latitude' => $latitude, 'longitude' => $longitude));

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getPrimaryLocation($id) {
        try {
            $select = 'SELECT * FROM user_locations WHERE is_primary = 1 AND user_id=' . $id;
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getSecondaryLocaton($id) {
        try {
            $select = 'SELECT * FROM user_locations WHERE is_primary = 0 AND user_id=' . $id;
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function setPrimaryLoc($loc_id, $user_id) {

        DB::table('user_locations')
                ->where('user_id', $user_id)
                ->update(['is_primary' => 0]);

        DB::table('user_locations')
                ->where('id', $loc_id)
                ->update(['is_primary' => 1]);

        return true;
    }

    public function editLocation($request) {
        try {
            $longitude = '';
            $latitude = '';

            if ($request->location != "") {
                $formattedAddr = str_replace(' ', '+', $request->location);
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );

                $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&address=' . $formattedAddr . '&sensor=false', false, stream_context_create($arrContextOptions));
                $maps_result = json_decode($geocodeFromAddr);

                if (!empty($maps_result->status)) {
                    if ($maps_result->status != 'OVER_QUERY_LIMIT') {
                        if (isset($maps_result->results[0]->geometry->location->lat)) {
                            $latitude = $maps_result->results[0]->geometry->location->lat;
                        }

                        if (isset($maps_result->results[0]->geometry->location->lng)) {
                            $longitude = $maps_result->results[0]->geometry->location->lng;
                        }
                    }
                }
            }

            DB::table('user_locations')
                    ->where('id', $request->location_id)
                    ->update(array('location' => $request->location, 'latitude' => $latitude, 'longitude' => $longitude));

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function delteLocationInfo($loc_id) {
        DB::table('user_locations')->where('id', $loc_id)->delete();
        return true;
    }

    public function updateLocationInfo($request) {

        $longitude = '';
        $latitude = '';

        if ($request->location != "") {
            $formattedAddr = str_replace(' ', '+', $request->location);
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );

            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC1XtsegzOIIBaqGL0QugHFIaL2pvp8f8A&address=' . $formattedAddr . '&sensor=false', false, stream_context_create($arrContextOptions));
            $maps_result = json_decode($geocodeFromAddr);

            if (!empty($maps_result->status)) {
                if ($maps_result->status != 'OVER_QUERY_LIMIT') {
                    if (isset($maps_result->results[0]->geometry->location->lat)) {
                        $latitude = $maps_result->results[0]->geometry->location->lat;
                    }

                    if (isset($maps_result->results[0]->geometry->location->lng)) {
                        $longitude = $maps_result->results[0]->geometry->location->lng;
                    }
                }
            }
        }

        $exist_location = 'SELECT COUNT(id) AS exist_location_count FROM user_locations WHERE user_id=' . $request->user_id . ' AND location IS NULL AND is_primary=1';
        $exist_location = DB::select($exist_location);
        if ($exist_location[0]->exist_location_count != 0) {
            $loc_delete = 'DELETE FROM user_locations WHERE user_id=' . $request->user_id . ' AND location IS NULL AND is_primary=1';
            DB::delete($loc_delete);

            DB::table('user_locations')->insert(
                    [
                        "user_id" => $request->user_id,
                        "location" => $request->location,
                        "latitude" => $latitude,
                        "longitude" => $longitude,
                        "is_primary" => 1,
                    ]
            );
        } else {
            DB::table('user_locations')->insert(
                    [
                        "user_id" => $request->user_id,
                        "location" => $request->location,
                        "latitude" => $latitude,
                        "longitude" => $longitude,
                        "is_primary" => 0,
                    ]
            );
        }
        return true;
    }

    public function getUserDescriptionInfo($id) {
        try {
            $select = 'SELECT ud.about_me,ud.look_up,uf.looking_for,uf.user_id FROM user_fields uf,user_details ud WHERE ud.id=uf.user_id AND ud.id=' . $id;
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertUpdateUserDescription($request, $user_id) {
        try {

            $looking_for = implode('|', $request->looking_for);

            if (isset($request->user_id) && $request->user_id != '') {
                DB::table('user_details')
                        ->where('id', $request->user_id)
                        ->update(array('about_me' => $request->about_me, 'look_up' => $request->look_up));

                DB::table('user_fields')
                        ->where('user_id', $request->user_id)
                        ->update(array('looking_for' => $looking_for));

                return 1;
            } else {
                DB::table('user_details')
                        ->where('id', $user_id)
                        ->update(array('about_me' => $request->about_me, 'look_up' => $request->look_up));

                $valu2 = array('user_id' => $user_id, 'looking_for' => $looking_for);
                DB::table('user_fields')->insert($valu2);

                return 2;
            }
        } catch (Exception $e) {
            $looking_for = implode('|', $request->looking_for);

            if (isset($request->user_id) && $request->user_id != '') {
                DB::table('user_details')
                        ->where('id', $request->user_id)
                        ->update(array('about_me' => $request->about_me, 'look_up' => $request->look_up));

                DB::table('user_fields')
                        ->where('user_id', $request->user_id)
                        ->update(array('looking_for' => $looking_for));

                return 1;
            } else {
                DB::table('user_details')
                        ->where('id', $user_id)
                        ->update(array('about_me' => $request->about_me, 'look_up' => $request->look_up));

                $valu2 = array('user_id' => $user_id, 'looking_for' => $looking_for);
                DB::table('user_fields')->insert($valu2);

                return 2;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateDescriptionInfo($request) {
        DB::table('user_details')
                ->where('id', $request->user_id)
                ->update(array('about_me' => $request->about_me, 'look_up' => $request->look_up));

        $looking_for = implode('|', $request->looking_for);

        DB::table('user_fields')
                ->where('user_id', $request->user_id)
                ->update(array('looking_for' => $looking_for));

        return true;
    }

    public function deleteUser($id) {
        try {

            DB::table('user_fields')->where('user_id', '=', $id)->delete();
            DB::table('user_credentials')->where('user_id', '=', $id)->delete();
            DB::table('user_details')->where('id', '=', $id)->delete();

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function get_group_workout_info_locations() {
        try {
            $select = 'SELECT * FROM group_workout_info_locations';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function get_gym_memberships() {
        try {
            $select = 'SELECT * FROM gym_memberships';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function get_outdoor_workout_locations() {
        try {
            $select = 'SELECT * FROM outdoor_workout_locations';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function get_scheduled_races() {
        try {
            $select = 'SELECT * FROM scheduled_races';
            $data = DB::select($select);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function userUpdateBasicInfo($request) {
        try {

            if (isset($request->looking_tags)) {
                $request->looking_tags = array_keys($request->looking_tags);
                $looking_tags = $request->looking_tags = implode('^', $request->looking_tags);
            }
            $date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
            DB::table('user_details')
                    ->where('id', $request->id)
                    ->update(array('first_name' => $request->first_name, 'date_of_birth' => $date_of_birth, 'gender' => $request->gender, 'profile_heading' => $request->profile_heading, 'looking_tags' => $request->looking_tags, 'video_link' => $request->video_link));

            $sql = DB::table('user_fields')
                            ->where('user_id', $request->id)->first();

            if (count($sql) == 0) {
                DB::table('user_fields')->insert(
                        [
                            "user_id" => $request->id,
                            "fitness_budget" => $request->fitness_budget,
                            "allowance_expectations" => $request->allowance_expectations,
                            'rate_expectations' => $request->rate_expectations,
                            'rate' => $request->rate,
                            'rate_description' => $request->rate_description
                        ]
                );
            } else {
                DB::table('user_fields')
                        ->where('user_id', $request->id)
                        ->update(array('fitness_budget' => $request->fitness_budget, 'allowance_expectations' => $request->allowance_expectations, 'rate_expectations' => $request->rate_expectations, 'rate' => $request->rate, 'rate_description' => $request->rate_description));
            }
//        DB::table('user_credentials')
            //        ->where('user_id', $request->id)
            //        ->update(array('username' => $request->username));

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function uploadProfilePicture($request) {
        try {
            $fileName1 = "";
            $profile = UserDetail::where("id", "=", $request->id)->get()[0];
            $old_image = $profile->profile_picture;

            if (Input::hasFile('avter_pic') && Input::file('avter_pic')->isValid()) {
                $avatar = $request->file("avter_pic");
                $fileName1 = rand(1111, 9999) . "_" . time() . "_" . $avatar->getClientOriginalName();
                if ($avatar->move(base_path() . "/public/uploads/user_profile_pictures/", $fileName1)) {

                    $profile_picture = base_path() . "/public/uploads/user_profile_pictures/" . $fileName1;

                    // Image resize
                    $image_config['source_image'] = $profile_picture;
                    $image_config['new_image'] = $profile_picture;

                    $image_config['create_thumb'] = false;
                    $image_config['maintain_ratio'] = false;
                    $image_config['width'] = $request->get('imgPreviewWidth');
                    $image_config['height'] = $request->get('imgPreviewHeight');

                    $image = new Image($image_config);

                    $image->resize();

                    // Image crop
                    $image_config['source_image'] = $profile_picture;
                    $image_config['new_image'] = $profile_picture;

                    $image_config['create_thumb'] = false;
                    $image_config['maintain_ratio'] = false;
                    $image_config['width'] = $request->get('width');
                    $image_config['height'] = $request->get('height');
                    $image_config['x_axis'] = $request->get('x1');
                    $image_config['y_axis'] = $request->get('y1');

                    $image = new Image($image_config);

                    $image->crop();

                    DB::table('user_details')
                            ->where('id', $request->id)
                            ->update(array('profile_picture' => $fileName1));

                    if ($old_image != "" && File::exists(base_path() . "/public/uploads/user_profile_pictures/" . $old_image)) {
                        File::delete(base_path() . "/public/uploads/user_profile_pictures/" . $old_image);
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addEditUserFitnessInfo($request, $user_id) {
        try {

            $workout_info_location = "";
            $gym_memberships = "";
            $outdoor_locations = "";
            $scheduled_races = "";

            if (!empty($request->workout_info_location)) {

                $workout_info_location_json = $request->workout_info_location;
                $workout_info_location = json_decode($workout_info_location_json);


                foreach ($workout_info_location as $value) {
                    $workout_info_location_val[] = $value->id;
                }

                $workout_info_location = implode('^', $workout_info_location_val);
            }

            if (!empty($request->gym_memberships)) {

                $gym_memberships_json = $request->gym_memberships;
                $gym_memberships = json_decode($gym_memberships_json);


                foreach ($gym_memberships as $value) {
                    $gym_memberships_val[] = $value->id;
                }

                $gym_memberships = implode('^', $gym_memberships_val);
            }

            if (!empty($request->outdoor_locations)) {

                $outdoor_locations_json = $request->outdoor_locations;
                $outdoor_locations = json_decode($outdoor_locations_json);


                foreach ($outdoor_locations as $value) {
                    $outdoor_locations_val[] = $value->id;
                }

                $outdoor_locations = implode('^', $outdoor_locations_val);
            }

            if (!empty($request->scheduled_races)) {
                $scheduled_races_json = $request->scheduled_races;
                $scheduled_races = json_decode($scheduled_races_json);


                foreach ($scheduled_races as $value) {
                    $scheduled_races_val[] = $value->id;
                }

                $scheduled_races = implode('^', $scheduled_races_val);
            }

            $sql = DB::table('user_fields')->where('user_id', $user_id)->first();

            if (count($sql) == 0) {
                $values = array('user_id' => $user_id, 'training_philosophy' => $request->training_philosophy, 'experience' => $request->experience, 'certifications' => $request->certifications, 'workout_info_location' => $workout_info_location, 'fitness_level' => $request->fitness_level, 'fitness_goals' => $request->fitness_goals, 'gym_memberships' => $gym_memberships, 'outdoor_locations' => $outdoor_locations, 'personal_trainers' => $request->personal_trainers, 'athletic_achievements' => $request->athletic_achievements, 'scheduled_races' => $scheduled_races, 'triathlon_club' => $request->triathlon_club, 'avg_swim_time' => $request->avg_swim_time, 'avg_bike_speed' => $request->avg_bike_speed, 'avg_run_time' => $request->avg_run_time, 'medical_issues' => $request->medical_issues);
                DB::table('user_fields')->insert($values);
            } else {
                DB::table('user_fields')
                        ->where('user_id', $user_id)
                        ->update(array('training_philosophy' => $request->training_philosophy, 'experience' => $request->experience, 'certifications' => $request->certifications, 'workout_info_location' => $workout_info_location, 'fitness_level' => $request->fitness_level, 'fitness_goals' => $request->fitness_goals, 'gym_memberships' => $gym_memberships, 'outdoor_locations' => $outdoor_locations, 'personal_trainers' => $request->personal_trainers, 'athletic_achievements' => $request->athletic_achievements, 'scheduled_races' => $scheduled_races, 'triathlon_club' => $request->triathlon_club, 'avg_swim_time' => $request->avg_swim_time, 'avg_bike_speed' => $request->avg_bike_speed, 'avg_run_time' => $request->avg_run_time, 'medical_issues' => $request->medical_issues));
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addEditUserPersonalInfo($request, $user_id) {
        try {

            $sql = DB::table('user_fields')->where('user_id', $user_id)->first();

            if (count($sql) == 0) {
                $values = array('user_id' => $user_id, 'height' => $request->height, 'body_type' => $request->body_type, 'ethnicity' => $request->ethnicity, 'occupation' => $request->occupation, 'education' => $request->education, 'relationship' => $request->relationship, 'children' => $request->children, 'smokes' => $request->smokes, 'drinks' => $request->drinks, 'language' => $request->language);
                DB::table('user_fields')->insert($values);
            } else {
                DB::table('user_fields')
                        ->where('user_id', $user_id)
                        ->update(array('height' => $request->height, 'body_type' => $request->body_type, 'ethnicity' => $request->ethnicity, 'occupation' => $request->occupation, 'education' => $request->education, 'relationship' => $request->relationship, 'children' => $request->children, 'smokes' => $request->smokes, 'drinks' => $request->drinks, 'language' => $request->language));
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function checkUserEmail($mail_id) {
        try {
            $query_uesr = 'SELECT COUNT(id) AS total_mail_no FROM user_credentials WHERE username="' . $mail_id . '"  ';
            $data = DB::select($query_uesr);
            $total_mail_no = $data[0]->total_mail_no;
            return $total_mail_no;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getProfileComplete($user_id) {
        try {
            $profie_complete_percentage = 15;

            $select1 = 'SELECT fitness_level FROM user_fields WHERE user_id = ' . $user_id;
            $data1 = DB::select($select1);

            if (isset($data1[0]->fitness_level) && $data1[0]->fitness_level != '' && $data1[0]->fitness_level != null) {
                $profie_complete_percentage = $profie_complete_percentage + 17;
            }

            $select2 = 'SELECT height FROM user_fields WHERE user_id = ' . $user_id;
            $data2 = DB::select($select2);
            if (isset($data2[0]->height) && $data2[0]->height != '' && $data2[0]->height != null) {
                $profie_complete_percentage = $profie_complete_percentage + 17;
            }

            $select3 = 'SELECT profile_image FROM user_photos WHERE user_id = ' . $user_id;
            $data3 = DB::select($select3);
            if (isset($data3[0]->profile_image) && $data3[0]->profile_image != '' && $data3[0]->profile_image != null) {
                $profie_complete_percentage = $profie_complete_percentage + 17;
            }

            $select4 = 'SELECT location FROM user_locations WHERE user_id = ' . $user_id;
            $data4 = DB::select($select4);
            if (isset($data4[0]->location) && $data4[0]->location != '' && $data4[0]->location != null) {
                $profie_complete_percentage = $profie_complete_percentage + 17;
            }

            $select5 = 'SELECT looking_for FROM user_fields WHERE user_id = ' . $user_id;
            $data5 = DB::select($select5);
            if (isset($data5[0]->looking_for) && $data5[0]->looking_for != '' && $data5[0]->looking_for != null) {
                $profie_complete_percentage = $profie_complete_percentage + 17;
            }

            return $profie_complete_percentage;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function countFav($trainer_id) {
        try {
            $sql = 'SELECT * FROM favorite_users WHERE user_id=' . session('user_id') . ' AND favorite_profile = ' . $trainer_id;
            $data = DB::select($sql);
            if (!empty($data)) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addFavorite($request) {
        try {
            $data['user_id'] = $request->session()->get('user_id');
            $data['favorite_profile'] = $request->trainer_id;
            $sql = DB::table('favorite_users')->insert($data);
            if ($sql) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteFavorite($request) {
        try {
            $user_id = $request->session()->get('user_id');
            DB::table('favorite_users')->where('user_id', $user_id)
                    ->where('favorite_profile', $request->trainer_id)
                    ->delete();
            return 0;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getFavoriteInfo($user_id) {
        try {
            $sql = DB::select("SELECT fu.*,uf.rate,up.profile as profile_type,ul.location as primary_location,ud.profile_picture,uc.username,ud.first_name AS name FROM favorite_users fu"
                            . " INNER JOIN user_details ud ON(ud.id=fu.favorite_profile) "
                            . " INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                            . " INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                            . " INNER JOIN user_fields uf ON(ud.id=uf.user_id) "
                            . " LEFT  JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                            . " WHERE fu.user_id = $user_id");

            if (!empty($sql)) {
                $qry = DB::select("SELECT * FROM user_locations ul WHERE ul.is_primary=1 AND user_id = $user_id");
                foreach ($sql as $fav_obj) {
                    if ($fav_obj->favorite_profile != "") {
                        $favorites[] = $fav_obj->favorite_profile;
                    }
                }
                if (!empty($favorites)) {
                    $favorites_user_id = implode(',', $favorites);
                }
                if (!empty($qry)) {

                    $latitude = $qry[0]->latitude;
                    $longitude = $qry[0]->longitude;

                    $radius_query = "SELECT `user_id`,
                    ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
                    COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
                    FROM `user_locations` ul WHERE user_id IN ($favorites_user_id) AND ul.is_primary=1";

                    $nearby = DB::select($radius_query);

                    if (!empty($nearby)) {
                        foreach ($nearby as $fav_obj) {
                            if ($fav_obj->distance != "") {
                                $favorite_distance[$fav_obj->user_id] = $fav_obj->distance;
                            } else {
                                $favorite_distance[$fav_obj->user_id] = '';
                            }
                        }
                        foreach ($sql as $index => $d) {
                            if ($favorite_distance[$d->favorite_profile] != "") {

                                $sql[$index]->trainer_distance = number_format($favorite_distance[$d->favorite_profile], 1);
                            } else {
                                $sql[$index]->trainer_distance = '';
                            }
                        }
                        return $sql;
                    }
                }
            } else {
                return '';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getFavoriteMeInfo($user_id) {
        try {
            $sql = DB::select("SELECT fu.*,uf.rate,up.profile as profile_type,ul.location as primary_location,ud.profile_picture,uc.username,ud.first_name AS name FROM favorite_users fu"
                            . " INNER JOIN user_details ud ON(ud.id=fu.user_id) "
                            . " INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                            . " INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                            . " INNER JOIN user_fields uf ON(ud.id=uf.user_id) "
                            . " LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                            . " WHERE fu.favorite_profile = $user_id");

            if (!empty($sql)) {
                $qry = DB::select("SELECT * FROM user_locations ul WHERE ul.is_primary=1 AND user_id = $user_id");
                foreach ($sql as $fav_obj) {
                    if ($fav_obj->user_id != "") {
                        $favorites[] = $fav_obj->user_id;
                    }
                }
                if (!empty($favorites)) {
                    $favorites_user_id = implode(',', $favorites);
                }
                if (!empty($qry)) {

                    $latitude = $qry[0]->latitude;
                    $longitude = $qry[0]->longitude;

                    $radius_query = "SELECT `user_id`,
                    ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
                    COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
                    FROM `user_locations` ul WHERE user_id IN ($favorites_user_id) AND ul.is_primary=1";

                    $nearby = DB::select($radius_query);
                    if (!empty($nearby)) {
                        foreach ($nearby as $fav_me_obj) {
                            if ($fav_me_obj->distance != "") {
                                $favorite_me_distance[$fav_me_obj->user_id] = $fav_me_obj->distance;
                            } else {
                                $favorite_me_distance[$fav_me_obj->user_id] = '';
                            }
                        }

                        foreach ($sql as $index => $d) {
                            if ($favorite_me_distance[$d->user_id] != "") {
                                $sql[$index]->favorite_me_distance = number_format($favorite_me_distance[$d->user_id], 1);
                            } else {
                                $sql[$index]->favorite_me_distance = '';
                            }
                        }
                        return $sql;
                    }
                }
            } else {
                return '';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getViewedMeInfo($user_id) {
        try {
            $sql = DB::select("SELECT vu.*,uf.rate,up.profile as profile_type,ul.location as primary_location,ud.profile_picture,uc.username,ud.first_name AS name FROM viewed_users vu"
                            . " INNER JOIN user_details ud ON(ud.id=vu.user_id) "
                            . " INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                            . " INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                            . " INNER JOIN user_fields uf ON(ud.id=uf.user_id) "
                            . " LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
                            . " WHERE vu.viewed_profile = $user_id");

            if (!empty($sql)) {
                $qry = DB::select("SELECT * FROM user_locations ul WHERE ul.is_primary=1 AND user_id = $user_id");
                foreach ($sql as $view_obj) {
                    if ($view_obj->user_id != "") {
                        $view[] = $view_obj->user_id;
                    }
                }
                if (!empty($view)) {
                    $view_user_id = implode(',', $view);
                }
                if (!empty($qry)) {

                    $latitude = $qry[0]->latitude;
                    $longitude = $qry[0]->longitude;

                    $radius_query = "SELECT `user_id`,
                    ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
                    COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
                    FROM `user_locations` ul WHERE user_id IN ($view_user_id) AND ul.is_primary=1";

                    $nearby = DB::select($radius_query);
                    if (!empty($nearby)) {
                        foreach ($nearby as $view_me_obj) {
                            if ($view_me_obj->distance != "") {
                                $view_me_distance[$view_me_obj->user_id] = $view_me_obj->distance;
                            } else {
                                $view_me_distance[$view_me_obj->user_id] = '';
                            }
                        }

                        foreach ($sql as $index => $d) {
                            if ($view_me_distance[$d->user_id] != "") {
                                $sql[$index]->view_me_distance = number_format($view_me_distance[$d->user_id], 1);
                            } else {
                                $sql[$index]->view_me_distance = '';
                            }
                        }
                        return $sql;
                    }
                }
            } else {
                return '';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getUser($user_id) {
        try {
            $sql = DB::select("SELECT * FROM user_credentials WHERE user_id = $user_id");
            return $sql;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateUserStatus($user_id) {
        try {
            $update = DB::table("user_credentials")->where('user_id', $user_id)->update([
                'email_status' => 1
            ]);
            if ($update) {
                return 1;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getHireMeDetails($user_id) {
        try {
            $data = DB::select("select ud.id,ud.profile_picture,ul.location,up.profile,ud.first_name,uf.rate from user_details ud INNER JOIN user_credentials uc ON(uc.user_id=ud.id) INNER JOIN user_profiles up ON (up.id=uc.profile_id) LEFT JOIN user_fields uf ON(uf.user_id=ud.id) INNER JOIN user_locations ul ON(ul.user_id =ud.id AND ul.is_primary=1) where ud.id=" . $user_id);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addCreditDetails($request, $trainer_id,$transactionid,$order_no) {
        $expiary = explode("/", $request->expiary);
        $card_brand = $this->validatecard($request->card_no);

        try {
            
            DB::table("payment_accounts")->insert([
                'user_id' => $request->session()->get('user_id'),
                'card_no' => $request->card_no,
                'name' => $request->name_on_card,
                'expiry_month' => $expiary[0],
                'expiry_year' => $expiary[1],
                'billing_firstname' => $request->billing_firstname,
                'billing_lastname' => $request->billing_lastname,
                'cvv_no' => $request->cvv,
                'billing_address' => $request->address_line1 . " " . $request->address_line2,
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'phone_number' => $request->phone_number,
                'card_brand' => $card_brand
            ]);

            $user_requests_id = DB::table("user_requests")->insertGetId([
                'user_id' => $request->session()->get('user_id'),
                'trainer_id' => $trainer_id,
                'status' => 0
            ]);

            DB::table("user_payments")->insert([
                'user_id' => $request->session()->get('user_id'),
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

    public function getCountries() {
        try {
            $countrylist = DB::select("select * from countries");
            return $countrylist;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function validatecard($number) {
        global $type;

        $cardtype = array(
            "visa" => "/^4[0-9]{12}(?:[0-9]{3})?$/",
            "mastercard" => "/^5[1-5][0-9]{14}$/",
            "amex" => "/^3[47][0-9]{13}$/",
            "discover" => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
        );

        $type = "UNKNOWN";

        if (preg_match($cardtype['visa'], $number)) {
            $type = "VISA";
        } else if (preg_match($cardtype['mastercard'], $number)) {
            $type = "MASTERCARD";
        } else if (preg_match($cardtype['amex'], $number)) {
            $type = "AMEX";
        } else if (preg_match($cardtype['discover'], $number)) {
            $type = "DISCOVER";
        }

        return $type;
    }

    public function getAdminPaymentDetails() {
        try {
            $admin_id = DB::select("select id from user_details where first_name='Admin'");
            $admin_payment_details = DB::select("select * from payment_accounts where user_id=" . $admin_id[0]->id);
            return $admin_payment_details;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getUserDetails($user_id) {
        try {

            $account_details = DB::select("select * from payment_accounts where user_id=" . $user_id);
            return $account_details;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

//    public function getCardNo($card_no,$user_id)
//    {
//         try
//        {
//       
//           $account_details=DB::select("select * from payment_accounts where card_no=".$card_no." and user_id=".$user_id);
//           $count=count($account_details);
//           return $count;
//           
//        }
//           catch (Exception $e) {
//            echo $e->getMessage();
//        }
//    }
    public function getCountryName($country_id) {
        try {

            $data = DB::select("select * from countries where id=" . $country_id);
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getRate($user_id) {
        try {

            $sql = DB::select("SELECT rate from user_fields WHERE user_id=" . $user_id);
            if(!empty($sql)){
                $data = $sql[0]->rate;
            }else{
                $data = '';
            }
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    

    public function updateCurrentLocation($request) {
        try {
            DB::table('user_details')
            ->where('id', $request->session()->get('user_id'))
            ->update(
                array(
                'recent_login_location' => $request->location,
                'recent_login_latlng' => $request->latlng,
                )
             );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
