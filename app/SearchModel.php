<?php

namespace App;

use App\Services\Image;
use DB;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class SearchModel extends Model {

    public $timestamps = false;

    public function advanceSearch($request) {

        $searchArr = $request->all();
        $final = [];
        $id = $request->session()->get('user_id');
        $sql = '';
        $sql_join = '';
        $sql_where = '';
        $sql1 = DB::select("SELECT * FROM user_locations WHERE user_id =" . $id . " AND is_primary=1 ");
        print_r($searchArr);
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
        $sql_select = "SELECT uc.user_id,up.profile as profile_type,ul.location as primary_location"
                      . ",ud.profile_picture,ud.first_name AS name"
                      . ",ud.gender ";

        $sql_join = "FROM user_details ud "
                    . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
                    . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
                    . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) ";

        $sql_where = " WHERE ud.id IN($trainers_user_id) AND ud.id!=$id ";


        if (isset($searchArr['gender']) && !empty($searchArr['gender'])) {
            $final_gender = implode("','", $searchArr['gender']);
            $sql_where .= " AND ud.gender IN('$final_gender') ";
        }
        if (isset($searchArr['user_type']) && $searchArr['user_type'] != '') {
            $final_user_type = implode(',', $searchArr['user_type']);
            $sql_where .= " AND uc.profile_id IN($final_user_type) ";
        }

        if (isset($searchArr['option']) || isset($searchArr['children']) || isset($searchArr['smoking']) || isset($searchArr['education']) || isset($searchArr['language']) || isset($searchArr['looking_for']) || isset($searchArr['height']) || isset($searchArr['rate']) || isset($searchArr['drinking'])) {

            $sql_join .= " INNER JOIN user_fields uf ON(uf.user_id=ud.id) ";

            if (isset($searchArr['option']) && !empty($searchArr['option'])) {
                if (in_array("Scheduled Races", $searchArr['option'])) {
                    $sql_where .= " AND uf.scheduled_races IS NOT NULL";
                }
                if (in_array("Achievements", $searchArr['option'])) {
                    $sql_where .= " AND uf.athletic_achievements IS NOT NULL";
                }
                if (in_array("Gym Memberships", $searchArr['option'])) {
                    $sql_where .= " AND uf.gym_memberships IS NOT NULL";
                }
                if (in_array("Outdoor Work-Out Location", $searchArr['option'])) {
                    $sql_where .= " AND uf.outdoor_locations IS NOT NULL";
                }
                if (in_array("Viewed Me", $searchArr['option']) || in_array("Viewed", $searchArr['option'])) { 
                    $sql_join .= " INNER JOIN viewed_users uv ON(uv.user_id=ud.id) ";
                    if(in_array("Viewed", $searchArr['option']) && in_array("Viewed Me", $searchArr['option'])){
                    $sql_where .= " AND uv.user_id = $id OR uv.viewed_profile = $id";
                    }else{
                    if(in_array("Viewed Me", $searchArr['option'])){
                    $sql_where .= " AND uv.viewed_profile = $id";
                    }
                    if(in_array("Viewed", $searchArr['option'])){
                    $sql_where .= " AND uv.user_id = $id";
                    }
                  }
                }
                if (in_array("Favorited Me", $searchArr['option']) || in_array("Favorited", $searchArr['option'])) { 
                    $sql_join .= " INNER JOIN favorite_users fu ON(fu.user_id=ud.id) ";
                    if(in_array("Favorited", $searchArr['option']) && in_array("Favorited Me", $searchArr['option'])){
                    $sql_where .= " AND fu.user_id = $id OR fu.favorite_profile = $id";
                    }else {
                    if(in_array("Favorited Me", $searchArr['option'])){
                    $sql_where .= " AND fu.favorite_profile = $id";
                    }
                    if(in_array("Favorited", $searchArr['option'])){
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
            if (isset($searchArr['rate']) && $searchArr['rate'] != '') {
                $sql_where .= " AND uf.rate <= " . $searchArr['rate'];
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
//        echo $sql_query;die;
        $select = DB::select($sql_query);
        print_r($select);



//        $sql = DB::select("SELECT * FROM user_locations WHERE user_id =". $id." AND is_primary=1 ");
//        
//        if(!empty($sql)){
//        
//            $radius= 15;    
//                
//            $latitude = $sql[0]->latitude;
//            $longitude = $sql[0]->longitude;
//
//            $radius_query = "SELECT `user_id`,
//            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) ) *
//            COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 AS `distance`
//            FROM `user_locations` ul WHERE
//            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` ) )
//            * COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longitude )) ) * 6371 < " . $radius." AND is_primary = 1 AND ul.user_id != "."$id"." ";
//            
//            $nearby = DB::select($radius_query);
//            
//            if(!empty($nearby)){
//                foreach ($nearby as $trainers_obj) { 
//                        if ($trainers_obj->user_id != "") { 
//                        $trainers[] = $trainers_obj->user_id;
//                        }
//                        if ($trainers_obj->distance != "") { 
//                        $trainers_distance[$trainers_obj->user_id] = $trainers_obj->distance;
//                    }else{
//                        $trainers_distance[$trainers_obj->user_id] = '';
//                    }
//                } 
//                if (!empty($trainers)) {
//                    $trainers_user_id = implode(',', $trainers);
//                }
//
//                $select = "SELECT uc.user_id,up.profile as profile_type,ul.location as primary_location,ud.id,ud.profile_picture,uc.profile_id,uc.username, CONCAT(ud.first_name,' ',ud.last_name) AS name, ud.date_of_birth,ud.gender,ud.about_me,ud.looking_tags,ud.video_link,ul.latitude,ul.longitude "
//                . "FROM user_details ud "
//                . "INNER JOIN user_credentials uc ON(uc.user_id=ud.id) "
//                . "INNER JOIN user_profiles up ON(up.id=uc.profile_id) "
//                . "LEFT JOIN user_locations ul ON(ul.user_id=uc.user_id AND ul.is_primary=1) "
//                . "WHERE ud.id IN($trainers_user_id) AND ud.id!=$id ";
//                
//                
//                if(isset($searchArr['photos'])&& $searchArr['photos'] != ''){ 
//                    $select.= " AND uc.profile_id = ".$request->profile_id;
//                }
//                $result = DB::select($select);
//
//                if(!empty($result)){
//                foreach($result as $index => $d){
//                        if (isset($trainers_distance[$d->user_id]) && $trainers_distance[$d->user_id] != "") {
//                                $result[$index]->trainer_distance = number_format($trainers_distance[$d->user_id],1);
//                            } else {
//                                $result[$index]->trainer_distance = 0;
//                            }
//                    }
//                }         
//                
//                if(!empty($result)){
//                    foreach($result as $key1 => $tobj1){
//                        foreach($result as $key2 => $tobj2){
//                            if($tobj1->trainer_distance != $tobj2->trainer_distance){
//                                $ar[$tobj1->trainer_distance] = $key1;
//                            }
//                        }
//                    }
//                    
//                    if(!empty($ar)){
//                        ksort($ar);                
//
//                    foreach ($ar as $dis => $k){
//                        $final[] = $result[$k];
//                    }
//                    } else {
//                        $final = $result;
//                    }
//                }
//                return $final;
//            }
//        }
    }

}
