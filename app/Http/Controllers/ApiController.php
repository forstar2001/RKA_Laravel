<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\ApiFunctions;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;
use Log;
use App\Services\JWT;
use URL;
use File;
use App\ApiModel;
use App\UserDetail;
use App\UserCredential;
use App\PaymentAccounts;
use App\Classes\PaypalPro;

Class ApiController extends Controller {

    public function Authenticate(Request $request) {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        $input = Input::all();

        if (isset($input['email'], $input['password'])) {
            $input['email'] = urldecode($input['email']);
            $input['password'] = urldecode($input['password']);

            if ($input['email'] != "" && $input['password'] != "") {

                $apiObj = new ApiModel();
                $data = $apiObj->AuthAction($input['email'], $input['password']);

                if (count($data) == 1) {
                    $jwt = new JWT();
                    $secret = $jwt->getSecretKey();
                    $token = JWT::encode($data[0], $secret);

                    $response['token'] = $token;
                    $response['data'] = $data[0];
                    $response['success'] = 1;
                    $response['msg'] = "Login Successful.";
                } else {
                    $response['msg'] = "Please provide valid credentials.";
                }
            } else {
                $response['msg'] = "Please fill up all the fields";
            }
        } else {
            $response['msg'] = "Please fill up all the fields";
        }

        return response()->json($response);
    }

    public function UserJoin(Request $request) {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        if ($request->fullname != "" && $request->email != "" && $request->password != "" && $request->athlete_type != "" && $request->profile_type != "" && $request->gender != "" && $request->who_interested != "") {
            
            $email_check = new ApiModel();
            $num = $email_check->getEmailCount($request->email);
            if ($num == 0) {
                $who_interested_json = $request->who_interested;
                $who_interested = json_decode($who_interested_json);
                foreach($who_interested as $value) {
                    $who_interested_val[] = $value->who_interested;
                }

                $who_interested = implode('^', $who_interested_val);
                
                $profile = new UserDetail();
                $profile->athlete_type = $request->athlete_type;
                $profile->first_name = $request->fullname;
                $profile->looking_tags = $who_interested;
                $profile->gender = $request->gender;
                $profile->save();

                $user = new UserCredential();
                $user->username = $request->email;
                $user->password = md5($request->password);
                $user->status = 1;
                $user->user_id = $profile->id;

                $profile_type = $request->profile_type;

                if ($profile_type == 'neither') {
                    $profile_id = 2;
                }
                if ($profile_type == 'personal_trainer') {
                    $profile_id = 3;
                }
                if ($profile_type == 'recovery_specialist') {
                    $profile_id = 4;
                }

                $user->profile_id = $profile_id;
                $user->save();
                
                $data['name']  = $profile->first_name;
                $data['email'] = $user->username;
                $data['user_id'] = $profile->id;

                Mail::send('home.emailcontent', ['data' => $data], function ($message) use($data) {
                    $message->subject("RKA Email Confirmation");
                    $message->from('demo.mlindia@gmail.com','RKA');
                    $message->to($data['email']);
                });
                
                $response['success'] = 1;
                $response['msg'] = "User Registration Successful.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "Email Id Already Exists";
            }
        } else {
            $response['success'] = 0;
            $response['msg'] = "Please fill up all the fields.";
        }
        return response()->json($response);
    }

    public function AthleteType() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        $athlete = [
                ['id' => 1, 'value' => 'ELITE CHAMPION'],
                ['id' => 2, 'value' => 'PERFORMANCE RACER'],
                ['id' => 3, 'value' => 'ASPIRING ATHLETE'],
        ];

        $response['data'] = $athlete;
        $response['success'] = 1;
        $response['msg'] = "3 Athlete Type Found";
        return response()->json($response);
    }

    public function SignUpStepTwo() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        $profiles = [
                ['id' => 'personal_trainer', 'value' => 'Personal trainer / coach'],
                ['id' => 'recovery_specialist', 'value' => 'Repair / recovery specialist'],
                ['id' => 'neither', 'value' => 'Neither']
        ];

        $response['data'] = $profiles;
        $response['success'] = 1;
        $response['msg'] = "3 Profiles Found";
        return response()->json($response);
    }

    public function UserProfiles() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        $userProfilesObj = new ApiModel();
        $profiles = $userProfilesObj->getUserProfiles();

        if (!empty($profiles)) {

            $response['data'] = $profiles;
            $response['success'] = 1;
            $response['msg'] = count($profiles) . " User Profiles Found";
        } else {
            $response['success'] = 0;
            $response['msg'] = "No User Profiles Found";
        }
        return response()->json($response);
    }

    public function GetGenderTypes() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $gender = [
                ['id' => 'Male', 'value' => 'Man'],
                ['id' => 'Female', 'value' => 'Woman']
        ];

        $response['data'] = $gender;
        $response['success'] = 1;
        $response['msg'] = "2 Gender Type Found";
        return response()->json($response);
    }

    public function SignUpStepFour() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        $interested = [
                ['id' => 'Personal trainers / coaches', 'value' => 'Personal trainers / coaches'],
                ['id' => 'Racing Partners', 'value' => 'Racing Partners'],
                ['id' => 'Training Partners', 'value' => 'Training Partners'],
                ['id' => 'Fitness Buddies', 'value' => 'Fitness Buddies'],
                ['id' => 'Repair / recovery specialists', 'value' => 'Repair / recovery specialists'],
                ['id' => 'All of them', 'value' => 'All of them']
        ];

        $response['data'] = $interested;
        $response['success'] = 1;
        $response['msg'] = "6 WHO IS INTERESTED IN Found";
        return response()->json($response);
    }

    public function GetRateExpectations() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $rate_expectation_arr = [
                        ['id' => 'Negotiable Rates (I don\'t have a set rate)', 'value' => 'Negotiable Rates (I don\'t have a set rate)'],
                        ['id' => 'Fixed Rates', 'value' => 'Fixed Rates'],
                        ['id' => 'Hourly Rates', 'value' => 'Hourly Rates'],
                        ['id' => 'Both Fixed and Hourly Rates', 'value' => 'Both Fixed and Hourly Rates']
        ];
        $response['data'] = $rate_expectation_arr;
        $response['success'] = 1;
        $response['msg'] = "4 Rate Expectations Found";
        return response()->json($response);
    }

    public function GetFitnessLevel() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $fitness_level_arr = [
                ['id' => '1 = Completely Sedentary and Out of Shape', 'value' => '1 = Completely Sedentary and Out of Shape'],
                ['id' => '2 = Somewhat Sedentary and Out of Shape', 'value' => '2 = Somewhat Sedentary and Out of Shape'],
                ['id' => '3 = Out of Shape with Rare Activity', 'value' => '3 = Out of Shape with Rare Activity'],
                ['id' => '4 = Less Than Average Fit with Occasional Activity', 'value' => '4 = Less Than Average Fit with Occasional Activity'],
                ['id' => '5 = Average Fit with Weekly Activity', 'value' => '5 = Average Fit with Weekly Activity'],
                ['id' => '6 = Better Than Average Fit with Balanced Nutrition and Consistent Weekly 75% Maximum Heart Rate Activity', 'value' => '6 = Better Than Average Fit with Balanced Nutrition and Consistent Weekly 75% Maximum Heart Rate Activity'],
                ['id' => '7 = In Shape Fit with Balanced Nutrition and Consistent Weekly 80% Maximum Heart Rate Activity', 'value' => '7 = In Shape Fit with Balanced Nutrition and Consistent Weekly 80% Maximum Heart Rate Activity'],
                ['id' => '8 = In Shape Fit with Balanced Nutrition and Consistent Weekly 85% Maximum Heart Rate Activity', 'value' => '8 = In Shape Fit with Balanced Nutrition and Consistent Weekly 85% Maximum Heart Rate Activity'],
                ['id' => '9 = Very Fit with Balanced Nutrition and Consistent Weekly 90% Maximum Heart Rate Activity', 'value' => '9 = Very Fit with Balanced Nutrition and Consistent Weekly 90% Maximum Heart Rate Activity'],
                ['id' => '10 = Extremely Fit with Balanced Nutrition and Consistent Weekly 95% Maximum Heart Rate Activity', 'value' => '10 = Extremely Fit with Balanced Nutrition and Consistent Weekly 95% Maximum Heart Rate Activity']
        ];
        $response['data'] = $fitness_level_arr;
        $response['success'] = 1;
        $response['msg'] = "10 Fitness Level Found";
        return response()->json($response);
    }

    public function GetSwimTime() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        $swim_time_arr = [['id' => 'I don\'t know', 'value' => 'I don\'t know'],
                ['id' => '8 min/mile', 'value' => '8 min/mile']];
        for ($i = 19; $i < 47; $i++) {
            array_push($swim_time_arr, ['id' => "$i", 'value' => "$i"]);
        }
        array_push($swim_time_arr, ['id' => '47+', 'value' => '47+']);
        $response['data'] = $swim_time_arr;
        $response['success'] = 1;
        $response['msg'] = count($swim_time_arr) . " Swim Time Found";
        return response()->json($response);
    }

    public function GetBikeSpeedMph() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        $bike_speed_arr = [['id' => 'I don\'t know', 'value' => 'I don\'t know'], ['id' => '8 mph', 'value' => '8 mph']];
        for ($j = 9; $j < 25; $j++) {
            array_push($bike_speed_arr, ['id' => "$j", 'value' => "$j"]);
        }
        array_push($bike_speed_arr, ['id' => '25+', 'value' => '25+']);
        $response['data'] = $bike_speed_arr;
        $response['success'] = 1;
        $response['msg'] = count($bike_speed_arr) . " Bike Speed Found";
        return response()->json($response);
    }

    public function GetRunTimeMile() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        $run_time_arr = [['id' => 'I don\'t know', 'value' => 'I don\'t know'], ['id' => '4 min/mile', 'value' => '4 min/mile']];
        for ($k = 5; $k < 18; $k++) {
            array_push($run_time_arr, ['id' => "$k", 'value' => "$k"]);
        }
        array_push($run_time_arr, ['id' => '25+', 'value' => '25+']);

        $response['data'] = $run_time_arr;
        $response['success'] = 1;
        $response['msg'] = count($run_time_arr) . " Run Time Found";
        return response()->json($response);
    }

    public function GetHeight() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $height_arr = [['id' => '4\'7"', 'value' => '4\'7"'], ['id' => '4\'8"', 'value' => '4\'8"'], ['id' => '4\'9"', 'value' => '4\'9"'], ['id' => '4\'10"', 'value' => '4\'10"'], ['id' => '4\'11"', 'value' => '4\'11"'], ['id' => '5\'', 'value' => '5\''], ['id' => '5\'1"', 'value' => '5\'1"'], ['id' => '5\'2"', 'value' => '5\'2"'], ['id' => '5\'3"', 'value' => '5\'3"'], ['id' => '5\'4"', 'value' => '5\'4"'], ['id' => '5\'5"', 'value' => '5\'5"'], ['id' => '5\'6"', 'value' => '5\'6"'], ['id' => '5\'7"', 'value' => '5\'7"'], ['id' => '5\'8"', 'value' => '5\'8"'], ['id' => '5\'9"', 'value' => '5\'9"'], ['id' => '5\'10"', 'value' => '5\'10"'], ['id' => '5\'11"', 'value' => '5\'11"'], ['6\'', 'value' => '6\''], ['id' => '6\'1"', 'value' => '6\'1"'], ['id' => '6\'2"', 'value' => '6\'2"'], ['id' => '6\'3"', 'value' => '6\'3"'], ['id' => '6\'4"', 'value' => '6\'4"'], ['id' => '6\'5"', 'value' => '6\'5"'], ['id' => '6\'6"', 'value' => '6\'6"'], ['id' => '6\'7"', 'value' => '6\'7"'], ['id' => '6\'8"', 'value' => '6\'8"'], ['id' => '6\'9"', 'value' => '6\'9"'], ['id' => '6\'10"', 'value' => '6\'10"'], ['id' => '6\'11"', 'value' => '6\'11"'], ['id' => '7\'', 'value' => '7\''], ['id' => 'Other', 'value' => 'Other']];

        $response['data'] = $height_arr;
        $response['success'] = 1;
        $response['msg'] = count($height_arr) . " Height Found";
        return response()->json($response);
    }

    public function GetBodyType() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $body_type_arr = [['id' => 'Slim', 'value' => 'Slim'], ['id' => 'Athletic', 'value' => 'Athletic'], ['id' => 'Average', 'value' => 'Average'], ['id' => 'Curvy', 'value' => 'Curvy'], ['id' => 'A few extra pounds', 'value' => 'A few extra pounds'], ['id' => 'Full / overweight', 'value' => 'Full / overweight'], ['id' => 'Other', 'value' => 'Other']];
        $response['data'] = $body_type_arr;
        $response['success'] = 1;
        $response['msg'] = count($body_type_arr) . " Body Type Found";
        return response()->json($response);
    }

    public function GetEthnicity() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $ethnicity_arr = [['id' => 'Asian', 'value' => 'Asian'], ['id' => 'Black / African descent', 'value' => 'Black / African descent'], ['id' => 'Latin/Hispanic', 'value' => 'Latin/Hispanic'], ['id' => 'East Indian', 'value' => 'East Indian'], ['id' => 'Middle Eastern', 'value' => 'Middle Eastern'], ['id' => 'Mixed', 'value' => 'Mixed'], ['id' => 'Native American', 'value' => 'Native American'], ['id' => 'Pacific Islander', 'value' => 'Pacific Islander'], ['id' => 'White / Caucasian', 'value' => 'White / Caucasian'], ['id' => 'Other', 'value' => 'Other']];
        $response['data'] = $ethnicity_arr;
        $response['success'] = 1;
        $response['msg'] = count($ethnicity_arr) . " Ethnicity Found";
        return response()->json($response);
    }

    public function GetQualification() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $education_arr = [['id' => 'High School', 'value' => 'High School'], ['id' => 'Some College', 'value' => 'Some College'], ['id' => 'Asociates Degree', 'value' => 'Associates Degree'], ['id' => 'Bachelors Degree', 'value' => 'Bachelors Degree'], ['id' => 'Graduate Degree', 'value' => 'Graduate Degree'], ['id' => 'PhD / Post Doctoral', 'value' => 'PhD / Post Doctoral']];
        $response['data'] = $education_arr;
        $response['success'] = 1;
        $response['msg'] = count($education_arr) . " Qualification Found";
        return response()->json($response);
    }

    public function GetRelationshipStatus() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $relationship_arr = [['id' => 'Single', 'value' => 'Single'], ['id' => 'Divorced', 'value' => 'Divorced'], ['id' => 'Separated', 'value' => 'Separated'], ['id' => 'Married But Looking', 'value' => 'Married But Looking'], ['id' => 'Open Relationship', 'value' => 'Open Relationship'], ['id' => 'Widowed', 'value' => 'Widowed']];
        $response['data'] = $relationship_arr;
        $response['success'] = 1;
        $response['msg'] = count($relationship_arr) . " Qualification Found";
        return response()->json($response);
    }

    public function GetChildrenNumber() {
        $response = [
            'success' => '0',
            'msg' => ''
        ];
        $children_arr = [['id' => 'Prefer not to Say', 'value' => 'Prefer not to Say'], ['id' => '0', 'value' => '0'], ['id' => '1', 'value' => '1'], ['id' => '2', 'value' => '2'], ['id' => '3', 'value' => '3'], ['id' => '4', 'value' => '4'], ['id' => '5', 'value' => '5'], ['id' => '6+', 'value' => '6+']];
        $response['data'] = $children_arr;
        $response['success'] = 1;
        $response['msg'] = count($children_arr) . " Children No Found";
        return response()->json($response);
    }

    public function GetSmokerType() {
        $response = [
            'success' => '0',
            'msg' => ''
        ];
        $smoking_arr = [['id' => 'Non Smoker', 'value' => 'Non Smoker'], ['id' => 'Light Smoker', 'value' => 'Light Smoker'], ['id' => 'Heavy Smoker', 'value' => 'Heavy Smoker']];
        $response['data'] = $smoking_arr;
        $response['success'] = 1;
        $response['msg'] = count($smoking_arr) . " Smoker Type Found";
        return response()->json($response);
    }

    public function GetDrinkerType() {
        $response = [
            'success' => '0',
            'msg' => ''
        ];
        $drinking_arr = [['id' => 'Non Drinker', 'value' => 'Non Drinker'], ['id' => 'Social Drinker', 'value' => 'Social Drinker'], ['id' => 'Heavy Drinker', 'value' => 'Heavy Drinker']];
        $response['data'] = $drinking_arr;
        $response['success'] = 1;
        $response['msg'] = count($drinking_arr) . " Drinker Type Found";
        return response()->json($response);
    }

    public function GetLanguages() {
        $response = [
            'success' => '0',
            'msg' => ''
        ];
        $language_arr = [['id' => 'English', 'value' => 'English'], ['id' => 'Espanol', 'value' => 'Espanol'], ['id' => 'Francais', 'value' => 'Francais'], ['id' => 'Deutsch', 'value' => 'Deutsch'], ['id' => 'Chinese symbols', 'value' => 'Chinese symbols'], ['id' => 'Japanese symbols', 'value' => 'Japanese symbols'], ['id' => 'Nederlandse', 'value' => 'Nederlandse'], ['id' => 'Portugues', 'value' => 'Portugues']];
        $response['data'] = $language_arr;
        $response['success'] = 1;
        $response['msg'] = count($language_arr) . " Languages Found";
        return response()->json($response);
    }

    public function GetFitnessBudget() {
        $response = [
            'success' => '0',
            'msg' => ''
        ];
        $fitness_budget_arr = [['id' => 'None', 'value' => 'None'], ['id' => 'Negotiable (I don’t have a set budget)', 'value' => 'Negotiable (I don’t have a set budget)'], ['id' => 'Minimal (Up to $500 monthly)', 'value' => 'Minimal (Up to $500 monthly)'], ['id' => 'Practical (Up to $1000 monthly)', 'value' => 'Practical (Up to $1000 monthly)'], ['id' => 'Moderate (Up to $3000 monthly)', 'value' => 'Moderate (Up to $3000 monthly)'], ['id' => 'Substantial (Up to $5000 monthly)', 'value' => 'Substantial (Up to $5000 monthly)'], ['id' => 'High (More than $5000 monthly)', 'value' => 'High (More than $5000 monthly)']];
        $response['data'] = $fitness_budget_arr;
        $response['success'] = 1;
        $response['msg'] = count($fitness_budget_arr) . " Fitness Budget Information Found";
        return response()->json($response);
    }

    public function GetAllowanceExpectations() {
        $response = [
            'success' => '0',
            'msg' => ''
        ];
        $allowance_expectations_arr = [['id' => 'None', 'value' => 'None'], ['id' => 'Negotiable (I don’t have a set budget)', 'value' => 'Negotiable (I don’t have a set budget)'], ['id' => 'Minimal (Up to $500 monthly)', 'value' => 'Minimal (Up to $500 monthly)'], ['id' => 'Practical (Up to $1000 monthly)', 'value' => 'Practical (Up to $1000 monthly)'], ['id' => 'Moderate (Up to $3000 monthly)', 'value' => 'Moderate (Up to $3000 monthly)'], ['id' => 'Substantial (Up to $5000 monthly)', 'value' => 'Substantial (Up to $5000 monthly)'], ['id' => 'High (More than $5000 monthly)', 'value' => 'High (More than $5000 monthly)']];
        $response['data'] = $allowance_expectations_arr;
        $response['success'] = 1;
        $response['msg'] = count($allowance_expectations_arr) . " Allowance Expectations Information Found";
        return response()->json($response);
    }
    
    public function GetUserBasicInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $profile_id = $user_info->profile_id;
        
        if(isset($user_id))
        {
            $user_obj = new ApiModel();
            $data = $user_obj->getBasicInfo($user_id, $profile_id);
            
            if ($data[0]->profile_picture != "")
            {
                $data[0]->profile_picture = url("/public/uploads/user_profile_pictures/" . $data[0]->profile_picture);
            }
            else
            {
                $data[0]->profile_picture = '';
            }            

            if($data[0]->looking_tags!=""){
                $looking_for = explode('^', $data[0]->looking_tags);
                
                foreach($looking_for as $key => $looking_for_val){
                    $arrLook[$key]['val'] = $looking_for_val;
                }

                $data[0]->looking_for = $arrLook;
            } else {
                $data[0]->looking_for = "";
            }
        
            if (count($data) > 0) {
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function EditUserBasicInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $profile_id = $user_info->profile_id;
        
        if(isset($user_id))
        { 
            $user_obj = new ApiModel();
            $status = $user_obj->editUserBasicInfo($request, $user_id, $profile_id);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "User Basic Info Updated Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Basic Info Update UnSuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    
    function UpdateBasicInfoProfilePicture(Request $request) {

        $user_info = $request->userInfo;
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $profile_picture = $request->profile_picture;

        if ($profile_picture != '' && $request->source != '') {
            $source = urldecode($request->source);

            if ($source == 'android') {

                $image_url = rand(1111, 9999) . "_" . time() . "_" . $profile_picture->getClientOriginalName();
                $fileName = str_replace(' ', '_', $image_url);
                $destinationPath = base_path() . "/public/uploads/user_profile_pictures/";
                $profile_picture->move($destinationPath, $fileName);

                $sql = DB::update("UPDATE `user_details` SET `profile_picture`= '$fileName' WHERE id = $user_info->id");
            } else if ($source == 'iphone') {
                $destinationPath = base_path() . "/public/uploads/user_profile_pictures/";
                $fileName = rand(1111, 9999) . "_" . time() . "_iphone.jpg" ;
                $target_path = $destinationPath . $fileName;
                file_put_contents($target_path, base64_decode($request->profile_picture));
                $sql = DB::update("UPDATE `user_details` SET `profile_picture`= '$fileName' WHERE id = $user_info->id");
            }


            if ($sql) {
                $response['data'] = [];
                $response['success'] = 1;
                $response['msg'] = "Profile Image Updated Successfully";
            } else {
                $response['data'] = [];
                $response['success'] = 0;
                $response['msg'] = "Profile Image not Updated";
            }
        } else {
            $response['success'] = 0;
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    
    public function GroupWorkoutInfoAndLocations()
    {
         $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_obj = new ApiModel();
        $workout_values = $user_obj->getGroupWorkoutInfoAndLocations();
        if(!empty($workout_values))
        {
            $response['data'] = $workout_values;
            $response['success'] = 1;
            $response['msg'] = count($workout_values) . " Workout Information And Locations Found";
        }
        else
        {
            $response['success'] = 0;
            $response['msg'] = "No Workout Information And Locations Information Found";
        }
        return response()->json($response);
    }
    
     public function GymMembershipInfo()
    {
         $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_obj = new ApiModel();
        $gym_membership_values = $user_obj->getGymMembershipInfo();
        if(!empty($gym_membership_values))
        {
            $response['data'] = $gym_membership_values;
            $response['success'] = 1;
            $response['msg'] = count($gym_membership_values) . " Gym Membership Information Found";
        }
        else
        {
            $response['success'] = 0;
            $response['msg'] = "No Workout Information And Locations Information Found";
        }
        return response()->json($response);
    }

    public function GymOutdoorWorkOutLocations()
    {
         $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_obj = new ApiModel();
        $gym_workout_location_values = $user_obj->getGymOutdoorWorkOutLocations();
        if(!empty($gym_workout_location_values))
        {
            $response['data'] = $gym_workout_location_values;
            $response['success'] = 1;
            $response['msg'] = count($gym_workout_location_values) . " Gym Outdoor Workout Locations Found";
        }
        else
        {
            $response['success'] = 0;
            $response['msg'] = "No Gym Outdoor Workout Locations Found";
        }
        return response()->json($response);
    }
    
     public function ScheduledRaces()
    {
         $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_obj = new ApiModel();
        $scheduled_races_values = $user_obj->getScheduledRaces();
        if(!empty($scheduled_races_values))
        {
            $response['data'] = $scheduled_races_values;
            $response['success'] = 1;
            $response['msg'] = count($scheduled_races_values) . " Scheduled Races Values Found";
        }
        else
        {
            $response['success'] = 0;
            $response['msg'] = "No Scheduled Races Values Found";
        }
        return response()->json($response);
    }
    
     public function GetLookingForTags() {
        $response = [
            'success' => 0,
            'msg' => ''
        ];

       $looking_for_tags = [
                    ['id'=>'Runner' , 'value'=> 'Runner'],
                    ['id'=>"10k runner", 'value'=>"10k runner"],
                    ['id'=>"Marathoner", 'value', 'value'=>"Marathoner"],
                    ['id'=>"Bicyclist", 'value'=>"Bicyclist"],
                    ['id'=>"Triathlete", 'value'=>"Triathlete"],
                    ['id'=>"Tough Mudder competitor", 'value'=>"Tough Mudder competitor"],
                    ['id'=>"Orange Theory Fitness fanatic", 'value'=>"Orange Theory Fitness fanatic"],
                    ['id'=>"WYCrossFit member", 'value'=>"CrossFit member"]
                ];
        $response['data'] =$looking_for_tags;
        $response['success'] = 1;
        $response['msg'] = count($looking_for_tags) . " Looking For Tags Found";
        return response()->json($response);
    }
    
    public function GetUserFitnessInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $profile_id = $user_info->profile_id;
        
        $api_obj = new ApiModel();
        
        if(isset($user_id))
        {
            $user_obj = new ApiModel();
            $data = $user_obj->getFitnessInfo($user_id, $profile_id);
            
            //Group Workout
            if($profile_id == 3 || $profile_id == 4)
            {
                if($data[0]->workout_info_location!=""){
                $workout_info_location = explode('^', $data[0]->workout_info_location);

                foreach($workout_info_location as $key => $workout_info_location_val){
                        $arrWoroutInfo[$key]['id'] = $workout_info_location_val;
                        $arrWoroutInfo[$key]['title'] = $api_obj->getTableValueByID('group_workout_info_locations',$workout_info_location_val);
                }

                $data[0]->workout_info_location = $arrWoroutInfo;
                } else {
                $data[0]->workout_info_location = "";
                }
            }
            
            //Gym Membership
            if($data[0]->gym_memberships!=""){
            $gym_membership = explode('^', $data[0]->gym_memberships);

            foreach($gym_membership as $key => $gym_membership_val){
                    $arrGymMembership[$key]['id'] = $gym_membership_val;
                    $arrGymMembership[$key]['title'] = $api_obj->getTableValueByID('gym_memberships',$gym_membership_val);
            }

            $data[0]->gym_memberships = $arrGymMembership;
            } else {
            $data[0]->gym_memberships = "";
            }
            
            //Outdoor Location
            if($data[0]->outdoor_locations!=""){
            $outdoor_locations = explode('^', $data[0]->outdoor_locations);

            foreach($outdoor_locations as $key => $outdoor_locations_val){
                    $arrOutdoorLocations[$key]['id'] = $outdoor_locations_val;
                    $arrOutdoorLocations[$key]['title'] = $api_obj->getTableValueByID('outdoor_workout_locations',$outdoor_locations_val);
            }

            $data[0]->outdoor_locations = $arrOutdoorLocations;
            } else {
            $data[0]->outdoor_locations = "";
            }
            
            //Schedule Races
            if($data[0]->scheduled_races!=""){
            $scheduled_races = explode('^', $data[0]->scheduled_races);

            foreach($scheduled_races as $key => $scheduled_races_val){
                    $arrScheduleRaces[$key]['id'] = $scheduled_races_val;
                    $arrScheduleRaces[$key]['title'] = $api_obj->getTableValueByID('scheduled_races',$scheduled_races_val);
            }

            $data[0]->scheduled_races = $arrScheduleRaces;
            } else {
            $data[0]->scheduled_races = "";
            }
            
            if (count($data) > 0) {
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function AddUserFitnessInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        { 
            $user_obj = new UserDetail();
            $status = $user_obj->addEditUserFitnessInfo($request, $user_id);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "User Fitness Info Added Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Fitness Info Add Unsuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function EditUserFitnessInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;

        $user_id = $user_info->id;
        $profile_id = $user_info->profile_id;
        
        if(isset($user_id))
        { 
            $user_obj = new ApiModel();
            $status = $user_obj->editUserFitnessInfo($request, $user_id, $profile_id);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "User Fitness Info Updated Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Fitness Info Update Unsuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function GetUserPersonalInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        {
            $user_obj = new UserDetail();
            $data = $user_obj->getPersonalInfo($user_id);
            
            if (count($data) > 0) {
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function AddUserPersonalInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        { 
            $user_obj = new UserDetail();
            $status = $user_obj->addEditUserPersonalInfo($request, $user_id);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "User Personal Info Added Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Personal Info Add Unsuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function EditUserPersonalInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        { 
            $user_obj = new UserDetail();
            $status = $user_obj->addEditUserPersonalInfo($request, $user_id);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "User Personal Info Updated Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Personal Info Update Unsuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function GetUserLocationInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        {
            $user_obj = new UserDetail();
            $data = $user_obj->getLocationInfo($user_id);
            
            if(!empty($data))
            {
                foreach($data as $val)
                {
                
                    if($val->is_primary == 1)
                    {
                        $val->is_primary = 'Primary';
                    }
                    else
                    {
                        $val->is_primary = 'Secondary';
                    }
                }
            }
            
            if (count($data) > 0) {
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function AddUserLocationInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        { 
            $user_obj = new UserDetail();
            $status = $user_obj->addLocationInfo($request, $user_id);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "User Location Info Added Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Location Info Add Unsuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function EditUserLocationInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        { 
            $user_obj = new UserDetail();
            $status = $user_obj->editLocationInfo($request);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "User Location Info Updated Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Location Info Update Unsuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function SetPrimaryUserLocation(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $location_id = $request->location_id;
        
        if(isset($user_id))
        { 
            $user_obj = new UserDetail();
            $status = $user_obj->setPrimaryLoc($location_id, $user_id);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "Secondary Location Changed To Primary Location Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "Secondary Location Changed To Primary Location Unsuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function deleteUserLocationInfo(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $location_id = $request->location_id;
        
        if(isset($user_id))
        { 
            $user_obj = new UserDetail();
            $status = $user_obj->delteLocationInfo($location_id);
            
            if ($status == true) {
                $response['success'] = 1;
                $response['msg'] = "User Location Info Deleted Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Location Info Delete Unsuccessful";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function UpdateUserDescription(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        { 
            $userdetail_obj = new ApiModel;
             $status = $userdetail_obj->insertUpdateUserDescription($request, $user_id);

            if ($status == 1) {

              $response['success'] = 1;
                $response['msg'] = "User Description Info Add and Updated Succesfully.";
            }
            else{

                $response['success'] = 0;
                $response['msg'] = "User Description Info Add and Update Unsuccesfull.";

            }
        } else {
            $response['success'] = 0;
            $response['msg'] = "User Id Not Found";
        }
        
        return response()->json($response);
    }
    
    public function GetUserPhotos(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        {
            $user_obj = new UserDetail();
            
            $data['public_photos'] = $user_obj->getPublicPhotosInfo($user_id);
            $data['private_photos'] = $user_obj->getPrivatePhotosInfo($user_id);
            
            if(!empty($data['public_photos']))
            {
                foreach($data['public_photos'] as $val)
                {

                    $val->image = url("/public/uploads/user_public_photos/" . $val->profile_image);
                }
            }
            else
            {
                $data['public_photos'] = "";
            }
            
            if(!empty($data['private_photos']))
            {
                foreach($data['private_photos'] as $val)
                {
                    $val->image = url("/public/uploads/user_private_photos/" . $val->profile_image);
                }
            }
            else
            {
                $data['public_photos'] = "";
            }
            
            if (count($data) > 0) {
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    function AddUserPhotos(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        $user_photo = $request->user_photo;
        $source =  $request->source;
        $type = $request->type;

        if (isset($user_id) && $user_photo != '' && $source != '') {
            
            if($type == 'public')
            {
                if ($source == 'android') {
                    $image_url = rand(1111, 9999) . "_" . time() . "_" . $profile_picture->getClientOriginalName();
                    $fileName = str_replace(' ', '_', $image_url);
                    $destinationPath = "uploads/user_public_photos/";
                    $profile_picture->move($destinationPath, $fileName);
                    
                    $values = array('user_id' => $user_id, 'profile_image' => $fileName, 'is_public' => 1);
                    DB::table('user_photos')->insert($values);
                }
                else if ($source == 'iphone')
                {
                    $destinationPath = "uploads/user_public_photos/";
                    $fileName = rand(1111, 9999) . "_" . time() . "_iphone.jpg" ;
                    $target_path = $destinationPath . $fileName;
                    file_put_contents($target_path, base64_decode($request->profile_picture));
                    
                    $values = array('user_id' => $user_id, 'profile_image' => $fileName, 'is_public' => 1);
                    DB::table('user_photos')->insert($values);
                }
            }
            else if($type == 'private')
            {
                if ($source == 'android') {
                    $image_url = rand(1111, 9999) . "_" . time() . "_" . $profile_picture->getClientOriginalName();
                    $fileName = str_replace(' ', '_', $image_url);
                    $destinationPath = "uploads/user_private_photos/";
                    $profile_picture->move($destinationPath, $fileName);

                    $values = array('user_id' => $user_id, 'profile_image' => $fileName, 'is_public' => 0);
                    DB::table('user_photos')->insert($values);
                }
                else if ($source == 'iphone')
                {
                    $destinationPath = "uploads/user_private_photos/";
                    $fileName = rand(1111, 9999) . "_" . time() . "_iphone.jpg" ;
                    $target_path = $destinationPath . $fileName;
                    file_put_contents($target_path, base64_decode($request->profile_picture));
                    
                    $values = array('user_id' => $user_id, 'profile_image' => $fileName, 'is_public' => 0);
                    DB::table('user_photos')->insert($values);
                }
            }
            
            if ($values) {
                $response['success'] = 1;
                $response['msg'] = "User Photo Added Successfully";
            } else {
                $response['data'] = [];
                $response['success'] = 0;
                $response['msg'] = "User Photo Not Added";
            }
        } else {
            $response['success'] = 0;
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    function DeleteUserPhotos(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $photo_id = $request->photo_id;

        if (isset($user_id) && $photo_id != '') {
            
            $userdetail_obj = new UserDetail;
            $status = $userdetail_obj->deleteUserPhotosInfo($photo_id);
            
            if ($status ==  true) {
                $response['success'] = 1;
                $response['msg'] = "User Photo Deleted Successfully";
            } else {
                $response['success'] = 0;
                $response['msg'] = "User Photo Not Deleted";
            }
        } else {
            $response['success'] = 0;
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
      function UserDashboard(Request $request){
        
         $response = [
            'success' => 0,
            'msg' => ''
        ];
         
        $user_info = $request->userInfo;
        $user_id=$user_info->id;
        $profile_id = $request->profile_id;
        if($user_id != '' && $profile_id){
        $user_obj = new ApiModel();
        $data = $user_obj->getAllUsers($profile_id,$user_id);
        
        foreach($data['result'] as $val)
        {
            $val->rate = $user_obj->getPrice($val->user_id);
            
            if($val->rate == null || $val->rate == "")
            {
                $val->rate = '0.00';
            }
            
        }
        
       if (count($data['result']) > 0) {
                $response['user_lat'] = $data['lat'];
                $response['user_lon'] = $data['lon'];
                $response['data'] = $data['result'];
                $response['success'] = 1;
                $response['msg'] = count($data['result'])." Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
      }else{
                $response['success'] = 0;
                $response['msg'] = "Please fill up all the fields.";
      }
       return response()->json($response);
    }
    
    function UserSearchTrainer(Request $request){
        
         $response = [
            'success' => 0,
            'msg' => ''
        ];
         
        $user_info = $request->userInfo;
        $user_id=$user_info->id;
        if($user_id != ''){
        $api_obj = new ApiModel();
        $data = $api_obj->getAllUsersByLocation($request,$user_id);
        
        foreach($data['result'] as $val)
        {
            $val->rate = $api_obj->getPrice($val->user_id);
            
            if($val->rate == null || $val->rate == "")
            {
                $val->rate = '0.00';
            }
            
        }
        
       if($data['success'] == 1){
       if (count($data) > 0) {
                $response['user_lat'] = $data['lat'];
                $response['user_lon'] = $data['lon'];
                $response['data'] = $data['result'];
                $response['success'] = 1;
                $response['msg'] = count($data['result'])." Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
      }else{
                $response = $data;
      }
        }else{
               $response = $data;
      }
       return response()->json($response);
    }
     
    public function UserTrainerProfile(Request $request)
    {
           $response = [
            'success' => 0,
            'msg' => ''
        ];
        
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        
        if(isset($user_id))
        {
            $user_obj = new UserDetail();
            $api_obj = new ApiModel();
            
//            $data['user_details'] = $user_obj->getBasicInfo($user_id);
//                if(!empty($data['user_details']))
//                   {
//                       foreach($data['user_details'] as $val)
//                       {
//
//                           $val->user_profile_photo=url("/public/uploads/user_profile_pictures/".$val->profile_picture);
//                       }
//                   }
//                   else
//                   {
//                       $val->user_profile_photo="";
//                   }
               
            if($request->trainer_id!="")
            {
                $trainer_id=$request->trainer_id;
                $data['trainer_basic_info'] =$api_obj->getTrainerBasicInfo($user_id, $trainer_id);
                
                if(!empty($data['trainer_basic_info'][0]->profile_picture))
                {     
                    $data['trainer_basic_info'][0]->profile_picture=url("/public/uploads/user_profile_pictures/".$data['trainer_basic_info'][0]->profile_picture);
                }
                else
                {
                    $data['trainer_basic_info'][0]->profile_picture="";
                }
                
                //looking_tags
                if($data['trainer_basic_info'][0]->looking_tags!=""){
                $looking_for = explode('^', $data['trainer_basic_info'][0]->looking_tags);
                foreach($looking_for as $key => $looking_for_val){
                        $arrLook[$key]['val'] = $looking_for_val;
                }
               $data['trainer_basic_info'][0]->looking_tags = $arrLook;
                } else {
                $data['trainer_basic_info'][0]->looking_tags = "";
                }
                
                //looking_for
                if($data['trainer_basic_info'][0]->looking_for!=""){
                $looking_for = explode('|', $data['trainer_basic_info'][0]->looking_for);
                foreach($looking_for as $key => $looking_for_val){
                        $arrLook[$key]['val'] = $looking_for_val;
                }
               $data['trainer_basic_info'][0]->looking_for = $arrLook;
                } else {
                $data['trainer_basic_info'][0]->looking_for = "";
                }
                
                //scheduled_races
                if($data['trainer_basic_info'][0]->scheduled_races!=""){
                $scheduled_races = explode('^', $data['trainer_basic_info'][0]->scheduled_races);
                foreach($scheduled_races as $key => $scheduled_races_val){
                        $arrScheduledRaces[$key]['id'] = $scheduled_races_val;
                        $arrScheduledRaces[$key]['title'] = $api_obj->getTableValueByID('scheduled_races',$scheduled_races_val);
                }
                $data['trainer_basic_info'][0]->scheduled_races = $arrScheduledRaces;
                } else {
                $data['trainer_basic_info'][0]->scheduled_races = "";
                }
                
                //gym_memberships
                if($data['trainer_basic_info'][0]->gym_memberships!=""){
                $gym_memberships = explode('^', $data['trainer_basic_info'][0]->gym_memberships);
                foreach($gym_memberships as $key => $gym_memberships_val){
                        $arrGymMemberships[$key]['id'] = $gym_memberships_val;
                        $arrGymMemberships[$key]['title'] = $api_obj->getTableValueByID('gym_memberships',$gym_memberships_val);
                }
                $data['trainer_basic_info'][0]->gym_memberships = $arrGymMemberships;
                } else {
                $data['trainer_basic_info'][0]->gym_memberships = "";
                }
                
                //outdoor_locations
                if($data['trainer_basic_info'][0]->outdoor_locations!=""){
                $outdoor_locations = explode('^', $data['trainer_basic_info'][0]->outdoor_locations);
                foreach($outdoor_locations as $key => $outdoor_locations_val){
                        $arrOutdoorLocations[$key]['id'] = $outdoor_locations_val;
                        $arrOutdoorLocations[$key]['title'] = $api_obj->getTableValueByID('outdoor_workout_locations',$outdoor_locations_val);
                }
                $data['trainer_basic_info'][0]->outdoor_locations = $arrOutdoorLocations;
                } else {
                $data['trainer_basic_info'][0]->outdoor_locations = "";
                }
                
                //outdoor_locations
                if($data['trainer_basic_info'][0]->workout_info_location!=""){
                $workout_info_location = explode('^', $data['trainer_basic_info'][0]->workout_info_location);
                foreach($workout_info_location as $key => $workout_info_location_val){
                        $arrWorkoutInfoLocation[$key]['id'] = $workout_info_location_val;
                        $arrWorkoutInfoLocation[$key]['title'] = $api_obj->getTableValueByID('group_workout_info_locations',$workout_info_location_val);
                }
                $data['trainer_basic_info'][0]->workout_info_location = $arrWorkoutInfoLocation;
                } else {
                $data['trainer_basic_info'][0]->workout_info_location = "";
                }
                
                //public_photos
                $data['trainer_basic_info'][0]->public_photos = $user_obj->getPublicPhotosInfo($trainer_id);
                if(!empty($data['trainer_basic_info'][0]->public_photos))
                {
                    foreach($data['trainer_basic_info'][0]->public_photos as $val)
                    {

                        $val->profile_image = url("/public/uploads/user_public_photos/".$val->profile_image);
                    }
                }
                else
                {
                    $data['trainer_basic_info'][0]->public_photos = "";
                }

                //private_photos
                $data['trainer_basic_info'][0]->private_photos = $user_obj->getPrivatePhotosInfo($trainer_id);
                if(!empty($data['trainer_basic_info'][0]->private_photos))
                {
                    foreach($data['trainer_basic_info'][0]->private_photos as $val)
                    {
                        $val->profile_image = url("/public/uploads/user_private_photos/" .$val->profile_image);
                    }
                }
                else
                {
                    $data['trainer_basic_info'][0]->private_photos = "";
                }

                 $response['success'] = 1;
                 $response['data']=$data;
                 $response['msg'] = "Personal Trainer Profile Details Found";
            }
            else
            {
                  $response['success'] = 0;
                  $response['msg'] = "Please Fillup all the fields";
            }
        }
        else
        {
                $response['success'] = 0;
                $response['msg'] = "User Id Not Found.";
        }
         return response()->json($response);
        
    }

  public function GetUserDescription(Request $request)
  {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $lookingFor=array();

        if(isset($user_id ))
        {
            $user_details=new ApiModel();
            $data=$user_details->getUserDetails($user_id);
          
            if($data[0]->looking_for!=""){
                $looking_for = explode('|', $data[0]->looking_for);

                foreach($looking_for as $key => $looking_for_val){
                        $lookingFor[$key]['id'] = $looking_for_val;
                        $lookingFor[$key]['value']=$looking_for_val;
                }
                $data[0]->looking_for = $lookingFor;
            }
            else
            {
                $data[0]->looking_for = "";
            }

             $response['success'] = 1;
             $response['data']=$data;
             $response['msg'] = "User Description Found";
        }
        else
        {
             $response['success'] = 0;
                $response['msg'] = "User Id Not Found.";
        }
             return response()->json($response);
  }
  
  public function UserLoginFB(Request $request) {

        $response = [
            'success' => 0,
            'msg' => ''
        ];

        if ($request->email != "" && $request->name != "") {

            $user_details = new UserDetail();
            $user_credential = new UserCredential();

            $num = $user_details->checkUserEmail(urldecode($request->email));

            if ($num == 0) {
                
                $user_details->first_name = urldecode($request->name);
                if ($request->dob != "")
                    $user_details->date_of_birth = date("Y-m-d", strtotime(urldecode($request->dob)));
                $user_details->profile_picture = $request->profile_picture;
                
                if ($user_details->save()) {

                    $user_credential->username = urldecode($request->email);
                    $user_credential->status = 1;
                    $user_credential->profile_id = 2;
                    if ($request->facebook_id != "")
                        $user_credential->social_id = $request->facebook_id;

                    $user_credential->social_source = "Facebook";
                    $user_credential->user_id = $user_details->id;
                }

                if ($user_credential->save()) {
                    $sql = "SELECT uc.*,uc.profile_id,uc.username,uc.status "
                            . "FROM user_details ud LEFT JOIN user_credentials uc ON(uc.user_id=ud.id) "
                            . "WHERE uc.username = '" . $request->email . "'"
                            . "AND uc.social_source = 'Facebook' AND uc.profile_id = 2 AND uc.status = 1";

                    $data = DB::select($sql);

                    if (count($data) == 1) {
                        $jwt = new JWT();
                        $secret = $jwt->getSecretKey();
                        $token = JWT::encode($data[0], $secret);

                        $response['token'] = $token;
                        $response['data'] = $data[0];
                        $response['success'] = 1;
                        $response['msg'] = "Login Successful.";
                    } else {
                        $response['msg'] = "Please provide valid credentials.";
                    }
                } else {
                    $response['msg'] = "User Registration Failed";
                }
            } else {
                $sql = "SELECT uc.*,uc.profile_id,uc.username,uc.status "
                        . "FROM user_details ud LEFT JOIN user_credentials uc ON(uc.user_id=ud.id) "
                        . "WHERE uc.username = '" . $request->email . "'"
                        . "AND uc.social_source = 'Facebook' AND uc.profile_id = 2 AND uc.status = 1";

                $data = DB::select($sql);

                if (count($data) == 1) {
                    $jwt = new JWT();
                    $secret = $jwt->getSecretKey();
                    $token = JWT::encode($data[0], $secret);

                    $response['token'] = $token;
                    $response['data'] = $data[0];
                    $response['success'] = 1;
                    $response['msg'] = "Login Successful.";
                } else {
                    $response['msg'] = "Please provide valid credentials.";
                }
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }
        return response()->json($response);
    }
    
    public function EmailCheck(Request $request){
        
         $response = [
            'success' => 0,
            'msg' => ''
        ];
         
        $otp = rand(111111,999999);
        $email = $request->email;
        
        if($email != ''){
        $sql=DB::select("SELECT * FROM user_credentials WHERE username='$email'");
        
        if(!empty($sql))
        {
            $modify=DB::table("user_credentials")->where('username',$email)->update([
                'otp' => $otp,
                'reset_status' => 1
            ]);
            if($modify)
            {
                    $data['otp'] = $otp;
                    $data['email'] = $email;
                    Mail::send('otp_send', ['data'=>$data], function ($message)  use($data) {           
                    $message->subject("RKA Forgot Password Confirmation");   
                    $message ->from('demo.mlindia@gmail.com','RKA'); 
                    $message ->to($data['email']);
                     });
                     
                     
                    $response['data'] =$data['otp']; 
                    $response['success'] = 1;
                    $response['msg'] = "OTP Sending Successfull";
                     
            }
            else
            {
                  $response['success'] = 0;
                  $response['msg'] = "OTP Not Send";
            }
        }
        else
        {
              $response['success'] = 0;
              $response['msg'] = "Email does not exist";
        }
      }else{
              $response['success'] = 0;
              $response['msg'] = "Please fill up all the fields";
      }
        return response()->json($response);
    }
    
    public function OtpCheck(Request $request)
    {
            $response = [
            'success' => 0,
            'msg' => ''
                   ];
            $email=$request->email;
            $otp=$request->otp;
            if( $email!="" &&  $otp!="" )
            {
                $sql=DB::select("SELECT otp,username FROM user_credentials WHERE username='$email' and reset_status=1");
                if(!empty($sql))
                {
                    if($sql[0]->otp==$otp)
                    {
                         $response['data']=$sql[0]->username;
                         $response['success'] = 1;
                         $response['msg'] = "Correct Otp Inserted";
                    }
                   else
                   {
                         $response['success'] = 0;
                         $response['msg'] = "Enter Correct Otp";
                   }
                }
                else
                {
                    $response['success'] = 0;
                    $response['msg'] = "Enter valid email Address";
                }
            }
            else
            {
                $response['success'] = 0;
                $response['msg'] = "Please Fill Up All The Fields";
            }
             return response()->json($response);
    }
    
    public function EnterNewPassword(Request $request)
    {
            $response = [
            'success' => 0,
            'msg' => ''
                   ];
            
            $email = $request->email;
            if($request->new_password != "" && $email != "")
            {
                $new_password = md5(urldecode($request->new_password));
                $sql=DB::select("SELECT * FROM user_credentials WHERE username='$email' AND reset_status='1'");
                if(!empty($sql))
                {
                    if($sql[0]->password != $new_password)
                    {
                        $modify=DB::table("user_credentials")->where('username',$email)->update([
                            'password' => $new_password,
                            'otp' => 0,
                            'reset_status' => 0
                        ]);
                        if($modify)
                        {
                             $response['success'] = 1;
                             $response['msg'] = "Password Changed Successfully";
                        }
                        else
                        {
                             $response['success'] = 0;
                             $response['msg'] = "Password Not Changed";
                        }
                    }
                    else
                    {
                         $response['success'] = 0;
                         $response['msg'] = "Old Password And New Password Both Are Same";
                    }
                }
                else
                {
                    $response['success'] = 0;
                    $response['msg'] = "User Details Not Found";
                }
          
            }
            else
            {
                $response['success'] = 0;
                $response['msg'] = "Please Fill Up All The Fields";
            }
            return response()->json($response);
    }
    
    public function ChangePassword(Request $request)
    {

        $user_info = $request->userInfo;
        $user_id = $user_info->id;

        $response = [
            'success' => 0,
            'msg' => ''
        ];

        if ($request->old_pw != "" && $request->new_pw != "" && $request->conf_pw != "")
        {

            $old = $user_info->password;
            
            $oldpw = md5($request->old_pw);
            $newpw = md5($request->new_pw);
            $conpw = md5($request->conf_pw);
            
            //echo $old;
            //exit;

            if ($old == $oldpw) {
                if ($newpw == $conpw) {

                    $user = UserCredential::where("user_id", "=", $user_id)->get()[0];
                    $user->password = $newpw;

                    if ($user->save()) {
                        $response['success'] = 1;
                        $response['msg'] = "Password Updated Successfully";
                    } else {
                        $response['success'] = 0;
                        $response['msg'] = "Password Not Updated";
                    }
                } else {
                    $response['success'] = 0;
                    $response['msg'] = "Confirm & New Password Mismatch";
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "Old Password Mismatch";
            }
        } else {
            $response['success'] = 0;
            $response['msg'] = "Please fill up all the fields.";
        }

        return response()->json($response);
    }
    
    public function GetProfileCompleteStatus(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $lookingFor=array();

        if(isset($user_id ))
        {
            $user_details=new UserDetail();
            $data=$user_details->getProfileComplete($user_id);

            $response['success'] = 1;
            $response['data']=$data;
            $response['msg'] = "Status Found";
        }
        else
        {
             $response['success'] = 0;
                $response['msg'] = "Please fill up all the fields.";
        }
             return response()->json($response);
    }
    
    public function GetMyFavorites(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;

        if(isset($user_id ))
        {
            $user_obj=new UserDetail();
            $data = $user_obj->getFavoriteInfo($user_id);
            
            if (!empty($data)) {
                
                foreach($data as $val)
                {
                    if($val->rate == null || $val->rate == "")
                    {
                        $val->rate = '0.00';
                    }
                    
                    if($val->trainer_distance == null || $val->trainer_distance == "")
                    {
                        $val->trainer_distance = '0.0';
                    }
                    
                    if ($val->profile_picture != "")
                    {
                        $val->profile_picture = url("/public/uploads/user_profile_pictures/" . $val->profile_picture);
                    }
                    else
                    {
                        $val->profile_picture = '';
                    }
                }
                
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        }
        else
        {
             $response['success'] = 0;
                $response['msg'] = "Please fill up all the fields.";
        }
             return response()->json($response);
    }
    
    public function GetFavoritedMe(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;

        if(isset($user_id ))
        {
            $user_obj=new UserDetail();
            $data = $user_obj->getFavoriteMeInfo($user_id);
            
            if (!empty($data)) {
                
                foreach($data as $val)
                {
                    if($val->rate == null || $val->rate == "")
                    {
                        $val->rate = '0.00';
                    }
                    
                    if($val->favorite_me_distance == null || $val->favorite_me_distance == "")
                    {
                        $val->favorite_me_distance = '0.0';
                    }
                    
                    if ($val->profile_picture != "")
                    {
                        $val->profile_picture = url("/public/uploads/user_profile_pictures/" . $val->profile_picture);
                    }
                    else
                    {
                        $val->profile_picture = '';
                    }
                }
                
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        }
        else
        {
             $response['success'] = 0;
                $response['msg'] = "Please fill up all the fields.";
        }
             return response()->json($response);
    }
    
    public function AddFavorite(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $trainer_id =  $request->trainer_id;
        
        if(isset($user_id))
        { 
            $api_obj = new ApiModel();
            
            $fav_count = $api_obj->countFav($user_id, $trainer_id);
            if($fav_count == 0){
                $data = $api_obj->addFavorite($user_id, $trainer_id);
            }else{
                $data = $api_obj->deleteFavorite($user_id, $trainer_id);
            }

            if($data == 1) 
            {

                $response['success'] = 1;
                $response['msg'] = "Favorite Added Succesfully.";
            }
            else if($data == 2) {

                $response['success'] = 1;
                $response['msg'] = "Favorite Deleted Succesfully.";
            }
            else
            {

                $response['success'] = 0;
                $response['msg'] = "Favorite Add Unsuccesful.";

            }
        } else {
            $response['success'] = 0;
            $response['msg'] = "User Id Not Found";
        }
        
        return response()->json($response);
    }
    
    public function GetViewedMe(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;

        if(isset($user_id ))
        {
            $user_obj=new UserDetail();
            $data = $user_obj->getViewedMeInfo($user_id);
            
            if (!empty($data)) {
                
                foreach($data as $val)
                {
                    if($val->rate == null || $val->rate == "")
                    {
                        $val->rate = '0.00';
                    }
                    
                    if($val->view_me_distance == null || $val->view_me_distance == "")
                    {
                        $val->view_me_distance = '0.0';
                    }
                    
                    if ($val->profile_picture != "")
                    {
                        $val->profile_picture = url("/public/uploads/user_profile_pictures/" . $val->profile_picture);
                    }
                    else
                    {
                        $val->profile_picture = '';
                    }
                }
                
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        }
        else
        {
             $response['success'] = 0;
                $response['msg'] = "Please fill up all the fields.";
        }
             return response()->json($response);
    }
    
    public function GetHireMeDetails(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;

        if(isset($user_id ))
        {
            $user_obj=new UserDetail();
            $data = $user_obj->getHireMeDetails($request->trainer_id);
            
            if (!empty($data)) {
                if($data[0]->rate == null || $data[0]->rate == "")
                {
                    $data[0]->rate = '0.00';
                }

                if($data[0]->profile_picture != "")
                {
                    $data[0]->profile_picture = url("/public/uploads/user_profile_pictures/" . $data[0]->profile_picture);
                }
                
                $data[0]->other_charges = '2.00';
                
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        }
        else
        {
             $response['success'] = 0;
                $response['msg'] = "Please fill up all the fields.";
        }
             return response()->json($response);
    }
    
    public function AddCard(Request $request)
    {
        $user_info = $request->userInfo;
        $user_id = $user_info->id;
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        if (isset($user_id ) && $request->card_no != "" && $request->month != "" && $request->year != "") {

            $payment_accounts = new PaymentAccounts();
            $user_obj = new UserDetail();

            $payment_accounts->user_id = $user_id;
            $payment_accounts->name = $request->card_holder_name;
            $payment_accounts->card_no = $request->card_no;
            $payment_accounts->expiry_month = $request->month;
            $payment_accounts->expiry_year = $request->year;
            //$payment_accounts->cvv_no = $request->cvv_no;          
            $payment_accounts->card_brand = $user_obj->validatecard($request->card_no);

            if ($payment_accounts->save()) {
                $response['success'] = 1;
                $response['msg'] = "Card Added Successfully.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "Card Not Added";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }
        return response()->json($response);
    }
    
    public function ViewCardList(Request $request)
    {
        $user_info = $request->userInfo;
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        if ($user_info->id != "") {

            $sql = "SELECT * FROM payment_accounts WHERE user_id = " . $user_info->id;
            $data['payment_accounts'] = DB::select($sql);

            if (count($data['payment_accounts']) > 0) {
                $response['data'] = $data;
                $response['success'] = 1;
                $response['msg'] = count($data['payment_accounts']) . " Cards Found";
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Card Found";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }
        return response()->json($response);
    }
    
    public function DeleteCard(Request $request)
    {
        $user_info = $request->userInfo;
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        if ($user_info->id != "" && $request->card_id != "") {

            $del = DB::table('payment_accounts')
                    ->where('id', $request->card_id)
                    ->where('user_id', $user_info->id)
                    ->delete();

            if ($del) {
                $response['success'] = 1;
                $response['msg'] = "Card Deleted Successfully.";
            } else {
                $response['success'] = 0;
                $response['msg'] = "Card Not Deleted";
            }
        } else {
            $response['msg'] = "Please fill up all the fields.";
        }
        return response()->json($response);
    }
    
    public function PaymentUsingCard(Request $request)
    {
        $user_info = $request->userInfo;
        
        $user_id = $user_info->id;
        $trainer_id = $request->trainer_id;
        
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        if ($user_info->id != "")
        {

            $order_no = "RKA" . time() . rand("111111", "999999");
            //$expiary = explode("/", $request->expiary);

            $credit_obj = new UserDetail();
            $api_obj = new ApiModel();
            
            $admin_details = $credit_obj->getAdminPaymentDetails();
            $country_data = $credit_obj->getCountryName($request->country);

            if (!empty($admin_details)) {
                
                $last_name = '';

                if(isset($request->billing_lastname))
                {
                    $last_name = $request->billing_lastname;
                }
                
                $config = array(
                    'apiUsername' => $admin_details[0]->account_api,
                    'apiPassword' => $admin_details[0]->account_password,
                    'apiSignature' => $admin_details[0]->account_signature
                );

                $paypalParam = array(
                    'paymentAction' => 'Sale',
                    'itemName' => $order_no,
                    'itemNumber' => $order_no,
                    'amount' => $request->amount,
                    'currencyCode' => "USD",
                    'creditCardType' => $credit_obj->validatecard($request->card_no),
                    'creditCardNumber' => $request->card_no,
                    'expMonth' => $request->exp_month,
                    'expYear' => $request->exp_year,
                    'cvv' => $request->cvv,
                    'firstName' => $request->billing_firstname,
                    'lastName' => $last_name,
                    'city' => $request->city,
                    'zip' => $request->state,
                    'countryCode' => $country_data[0]->country_name,
                );
                
                $paypal = new PaypalPro($config);
                $response = $paypal->paypalCall($paypalParam);
                
                if (isset($response['ACK']) && $response['ACK'] == 'Success')
                {
                    $api_obj->addCreditDetails($request, $user_id, $trainer_id, $response['TRANSACTIONID'], $order_no);
                    $data['success'] = 1;
                    $data['msg'] = "Payment successful";
                }
                else
                {
                    $data['msg'] = "Payment unsuccessful."; 
                }
            }
            else
            {
                $data['msg'] = "Payment setup is incomplete.";
            }
        }
        else
        {
            $data['msg'] = "Please fill up all the fields.";
        }
        return response()->json($data);
    }
    
    public function PaymentUsingPaypal(Request $request)
    {
        $user_info = $request->userInfo;
        
        $user_id = $user_info->id;
        $trainer_id = $request->trainer_id;
        
        $response = [
            'success' => 0,
            'msg' => ''
        ];

        if ($user_info->id != "")
        {            
            $order_no = "RKA" . time() . rand("111111", "999999");

            if (isset($request->payKey) && isset($request->amount) && $order_no != '' )
            {
                $data = [];
                
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
                    'transaction_id' => $request->payKey,
                    'transaction_type' => 'Paypal'
                ]);

                $response['success'] = 1;
                $response['msg'] = "Payment successful";
            }
            else 
            {
                $response['msg'] = "Please provide all the details";
            }
        }
        else
        {
            $data['msg'] = "Please fill up all the fields.";
        }
        return response()->json($response);
    }
    
    public function GetCountryList(Request $request)
    {
        $sql = "SELECT * FROM countries";
        $data['countries'] = DB::select($sql);

        if (count($data['countries']) > 0) {
            $response['data'] = $data;
            $response['success'] = 1;
            $response['msg'] = "Countries Found";
        } else {
            $response['success'] = 0;
            $response['msg'] = "No Country Found";
        }
        return response()->json($response);
    }
    
    public function AdvanceSearch(Request $request)
    {
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        $user_info = $request->userInfo;
        $user_id = $user_info->id;

        if(isset($user_id ))
        {
            $api_obj = new ApiModel();
            $data['search_data'] = $api_obj->searchFilter($request, $user_id);
            
            if (!empty($data['search_data']))
            {
                $response['data'] = $data['search_data'];
                $response['success'] = 1;
                $response['msg'] = "Data found.";
            }
            else
            {
                $response['success'] = 0;
                $response['msg'] = "No Data found.";
            }
        }
        else
        {
            $response['success'] = 0;
            $response['msg'] = "Please fill up all the fields.";
        }
        
        return response()->json($response);
    }
}

?>