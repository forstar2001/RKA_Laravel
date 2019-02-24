<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Request;
use App\UserCredential;
use App\UserDetail;
use App\Dashboard;
use App\SearchModel;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Session;
use Mail;
use File;
use Excel;
use PDF;
use App\Classes\PaypalPro;

Class HomeController extends Controller {

    public function Index(Request $request) {
        $data = array('title' => 'Home Page', 'theme_type' => 'admin');
        return View('home.index', $data);
    }

    public function UserJoin(Request $request) {
        return View('home.signup');
    }

    public function UserSignUpStepOne(Request $request) {

        $user = new Dashboard();
        $num = $user->check_user_email($request->email);
        if ($num == 0) {
            session([
                "temp_name" => $request->name,
                "temp_email" => $request->email,
                "temp_password" => $request->password
            ]);
            return View('home.signup-step1');
        } else {
            Session::flash('message', 'Email Already Exists');
            return redirect()->route("UserJoin");
        }
    }

    public function UserSignUpStepTwo(Request $request) {
        session([
            "temp_athlete_type" => $request->property_type
        ]);
        return View('home.signup-step2');
    }

    public function UserSignUpStepThree(Request $request) {
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

        session([
            "temp_profile_id" => $profile_id
        ]);

        return View('home.signup-step3');
    }

    public function UserSignUpStepFour(Request $request) {
        session([
            "temp_gender" => $request->gender
        ]);
        return View('home.signup-step4');
    }

    public function UserAdd(Request $request) {
        session([
            "temp_looking_tags" => implode('^', $request->looking_tags)
        ]);
        $profile = new UserDetail();
        $profile->athlete_type = session("temp_athlete_type");
        $profile->looking_tags = session("temp_looking_tags");
        $profile->first_name = session("temp_name");
        $profile->gender = session("temp_gender");
        $profile->save();

        $user = new UserCredential();
        $user->username = session("temp_email");
        $user->password = md5(session("temp_password"));
        $user->status = 1;
        $user->user_id = $profile->id;
        $user->profile_id = session("temp_profile_id");
        $user->save();

        $data['name'] = $profile->first_name;
        $data['email'] = $user->username;
        $data['user_id'] = $profile->id;

        Mail::send('home.emailcontent', ['data' => $data], function ($message) use($data) {
            $message->subject("RKA Email Confirmation");
            $message->from('siddhanta.mlindia@gmail.com', 'RKA');
            $message->to($data['email']);
        });


        session()->flash("smsg", "Registration Successful, Please Check Your Email to Verify the Account.");
        return redirect()->route("UserLogin");
    }

    public function UserVerifyStatus(Request $request) {

        $user_id = base64_decode($request->user_id);
        $user_obj = new UserDetail();
        $sql = $user_obj->getUser($user_id);
        if ($sql[0]->email_status === 0) {
            $update = $user_obj->updateUserStatus($user_id);
            if ($update == 1) {
                Session::flash('smsg', 'Email Successfully Verified');
                return redirect()->route("UserLogin");
            }
        } else if ($sql[0]->email_status == 1) {
            Session::flash('msg', 'Email Already Verified');
            return redirect()->route("UserLogin");
        }
    }

    public function UserLogin() {
        return View('home.login');
    }

    public function ForgotPassword() {
        return view('Home.forgot_password');
    }

    public function VerifyEmail(Request $request) {

        $email = $request->username;

        $val1 = DB::table('user_credentials')->where('username', '=', $email)->get();

        if (count($val1) != 0) {
            $val2 = DB::select("SELECT uc.username, ud.first_name AS name FROM user_credentials uc INNER JOIN user_details ud ON(uc.user_id=ud.id) WHERE uc.user_id = '" . $val1[0]->user_id . "'");

            $data['name'] = $val2[0]->name;
            $data['email'] = $val2[0]->username;
            $otp = mt_rand(100000, 999999);
            $data['otp'] = $otp;

            $sql = DB::update("UPDATE user_credentials SET otp= '" . $data['otp'] . "', reset_status = 1 WHERE user_id ='" . $val1[0]->user_id . "'");

            Mail::send('otp_send', ['data' => $data], function ($message) use($data) {
                $message->subject("RKA Forgot Password Confirmation");
                $message->from('demo.mlindia@gmail.com', 'RKA');
                $message->to($data['email']);
            });

            $request->session()->flash('msg', 'OTP Has Been Sent On Your Registered Email Id');
            return redirect()->route("UserConfirmOtp");
        } else {
            $request->session()->flash('msg', 'Invalid Email Id !!!');
            return redirect()->route("UserForgotPassword");
        }
    }

    public function ConfirmOtp() {
        return view('Home.confirm_otp');
    }

    public function verifyOtp(Request $request) {
        $otp = $request->otp;

        $val = DB::table('user_credentials')
                ->where('otp', '=', $otp)
                ->where('reset_status', '=', 1)
                ->get();

        if (count($val) != 0) {
            Session::set('otp', $otp);
            return redirect()->route("UserResetPassword");
        } else {
            $request->session()->flash('msg', 'Invalid OTP !!!');
            return redirect()->route("UserConfirmOtp");
        }
    }

    public function ResetPassword() {
        return view('Home.reset_password');
    }

    public function UpdatePassword(Request $request) {
        $otp = Session::get('otp');
        $new_password = $request->new_password;
        $confirm_new_password = $request->confirm_new_password;


        if ($new_password == $confirm_new_password) {
            $sql = DB::update("UPDATE user_credentials SET password = '" . md5($new_password) . "', otp = 0, reset_status = 0 WHERE otp ='" . $otp . "'");

            Session::forget('otp');
            session()->flash("msg", "Password Updated Successfully");
            return redirect()->route("UserLogin");
        } else {
            $request->session()->flash('msg', 'Password Mismatch !!!');
            return redirect()->route("UserResetPassword");
        }
    }

    public function UserLoginAccess(Request $request) {

        if ($_REQUEST['fb_access_token'] != null) {
            $fb_user_details = "https://graph.facebook.com/me?fields=id,first_name,last_name,email,picture&access_token=" . $_REQUEST['fb_access_token'];
            $fb_response = file_get_contents($fb_user_details);
            $fb_response = json_decode($fb_response);

            if ($fb_response && $fb_response->id != null) {

                $user_check = new Dashboard();
                $num = $user_check->check_user_email($fb_response->email);
                $user = new UserCredential();
                if ($num == 0) {
                    $profile = new UserDetail();
                    $profile->first_name = $fb_response->first_name . " " . $fb_response->last_name;
                    $profile->profile_picture = $fb_response->picture->data->url;
                    if ($profile->save()) {

                        $user->username = $fb_response->email;
                        $user->profile_id = 2;
                        $user->social_id = $fb_response->id;
                        $user->social_source = "Facebook";
                        $user->status = 1;
                        $user->user_id = $profile->id;
                        if ($user->save()) {
                            $user_count = $user->checkLoginCredentialsFB($user->username);
                        }
                    }
                } else {
                    $user_count = $user->checkLoginCredentialsFB($fb_response->email);
                }
            }
        } else {

            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);



            $user = new UserCredential();
            $user_count = $user->checkLoginCredentials($request);
        }
        if (count($user_count) == 0) {
            session()->flash("msg", "Invalid Email Or Password");
            return redirect()->route("UserLogin");
        } else {
            $sql = $user->getUserEmailStatus($request);
            if ($sql->email_status === 0) {
                session()->flash("msg", "Please Verify Your Email to Login");
                return redirect()->route("UserLogin");
            } else {
                $user_obj = new UserDetail();
                $data['user_details'] = $user_obj->getBasicInfo($user_count->user_id);
                session(["user_id" => $data['user_details'][0]->id, "profile_id" => $data['user_details'][0]->profile_id]);
                return redirect()->route("UserDashboard");
            }
        }
    }

    public function UserDashboard(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserDashboard";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['all_user_details'] = $user_obj->getAllUsers($request, $request->session()->get('user_id'));
        $data['user_location'] = $user_obj->getUserLocation($request->session()->get('user_id'));
        $data['user_profiles'] = $user_obj->getProfiles();
        return View('home.dashboard', $data);
    }

    public function UserTrainerSearch(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserDashboard";

        if (!empty($request->location)) {
            $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
            $data['all_user_details'] = $user_obj->getAllUsersByLocation($request);
            return View('home.search_trainers', $data);
        } else {
            $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
            $data['all_user_details'] = $user_obj->getAllUsers($request, $request->session()->get('user_id'));
            return View('home.search_trainers', $data);
        }
    }

    public function UserTrainerProfile(Request $request, $user_id) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }

        $user_obj = new UserDetail();
        $data['menu'] = "UserDashboard";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['trainer_basic_info'] = $user_obj->getTrainerBasicInfo($user_id);
        $data['public_photos'] = $user_obj->getPublicPhotosInfo($user_id);
        $data['private_photos'] = $user_obj->getPrivatePhotosInfo($user_id);
        return View('home.trainers_profile', $data);
    }

    public function UserBasicProfile(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserProfile";
        $data['tab'] = "BasicProfile";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['profile_complete'] = $user_obj->getProfileComplete($request->session()->get('user_id'));
        if ($data['user_details'][0]->profile_id == 2 || $data['user_details'][0]->profile_id == 5) {
            $data['looking_for_arr'] = array('Personal trainers / coaches' => 'Personal trainers / coaches', 'Racing Partners' => 'Racing Partners', 'Training Partners' => 'Training Partners', 'Fitness Buddies' => 'Fitness Buddies', 'Repair / recovery specialists' => 'Repair / recovery specialists', 'All of them' => 'All of them');
        } else {
            $data['looking_for_arr'] = array('Performance Racers' => 'Performance Racers', 'Aspiring Athletes' => 'Aspiring Athletes', 'Personal trainers / coaches' => 'Personal trainers / coaches', 'Racing Partners' => 'Racing Partners', 'Training Partners' => 'Training Partners', 'Repair / recovery specialists' => 'Repair / recovery specialists', 'Fitness Buddies' => 'Fitness Buddies', 'Elite Champion' => 'Elite Champion', 'All of them' => 'All of them');
            $data['rate_expectation_arr'] = array('Negotiable Rates (I don\'t have a set rate)' => 'Negotiable Rates (I don\'t have a set rate)', 'Fixed Rates' => 'Fixed Rates', 'Hourly Rates' => 'Hourly Rates', 'Both Fixed and Hourly Rates' => 'Both Fixed and Hourly Rates');
        }
        $data['fitness_budget_arr'] = array('None' => 'None', 'Negotiable (I don’t have a set budget)' => 'Negotiable (I don’t have a set budget)', 'Minimal (Up to $500 monthly)' => 'Minimal (Up to $500 monthly)', 'Practical (Up to $1000 monthly)' => 'Practical (Up to $1000 monthly)', 'Moderate (Up to $3000 monthly)' => 'Moderate (Up to $3000 monthly)', 'Substantial (Up to $5000 monthly)' => 'Substantial (Up to $5000 monthly)', 'High (More than $5000 monthly)' => 'High (More than $5000 monthly)');
        $data['allowance_expectations_arr'] = array('None' => 'None', 'Negotiable (I don’t have a set budget)' => 'Negotiable (I don’t have a set budget)', 'Minimal (Up to $500 monthly)' => 'Minimal (Up to $500 monthly)', 'Practical (Up to $1000 monthly)' => 'Practical (Up to $1000 monthly)', 'Moderate (Up to $3000 monthly)' => 'Moderate (Up to $3000 monthly)', 'Substantial (Up to $5000 monthly)' => 'Substantial (Up to $5000 monthly)', 'High (More than $5000 monthly)' => 'High (More than $5000 monthly)');

        return View('home.basic_profile', $data);
    }

    public function UserUpdateBasicProfile(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->userUpdateBasicInfo($request);

        if ($status == true) {
            session()->flash("msg", "Basic Info Updated Succesfully");
            return redirect()->route("UserBasicProfile");
        }
    }

    public function UserUploadProfilePhotos(Request $request) {
        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $avatar = $request->file("avter_pic");
        $user_obj = new UserDetail();
        $status = $user_obj->uploadProfilePicture($request);
        if ($status == true) {
            return 1;
        }
    }

    public function UserLogout(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }

        session()->flush();
        return redirect()->route("Home");
    }

    public function UserFitnessInfo(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserProfile";
        $data['tab'] = "FitnessInfo";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['fitness_info'] = $user_obj->getFitnessInfo($request->session()->get('user_id'));
        $data['group_workout_info_locations'] = $user_obj->get_group_workout_info_locations();
        $data['gym_memberships'] = $user_obj->get_gym_memberships();
        $data['outdoor_workout_locations'] = $user_obj->get_outdoor_workout_locations();
        $data['scheduled_races'] = $user_obj->get_scheduled_races();

        $data['swim_time_arr'] = array('I don\'t know' => 'I don\'t know', '8 min/mile' => '8 min/mile');
        for ($i = 19; $i < 47; $i++) {
            $data['swim_time_arr'][$i] = $i;
        }
        $data['swim_time_arr']['47+'] = '47+';

        $data['bike_speed_arr'] = array('I don\'t know' => 'I don\'t know', '8 mph' => '8 mph');
        for ($j = 9; $j < 25; $j++) {
            $data['bike_speed_arr'][$j] = $j;
        }
        $data['bike_speed_arr']['25+'] = '25+';

        $data['run_time_arr'] = array('I don\'t know' => 'I don\'t know', '4 min/mile' => '4 min/mile');
        for ($k = 5; $k < 18; $k++) {
            $data['run_time_arr'][$k] = $k;
        }
        $data['run_time_arr']['25+'] = '25+';

        $data['fitness_level_arr'] = array('1 = Completely Sedentary and Out of Shape' => '1 = Completely Sedentary and Out of Shape',
            '2 = Somewhat Sedentary and Out of Shape' => '2 = Somewhat Sedentary and Out of Shape',
            '3 = Out of Shape with Rare Activity' => '3 = Out of Shape with Rare Activity',
            '4 = Less Than Average Fit with Occasional Activity' => '4 = Less Than Average Fit with Occasional Activity',
            '5 = Average Fit with Weekly Activity' => '5 = Average Fit with Weekly Activity',
            '6 = Better Than Average Fit with Balanced Nutrition and Consistent Weekly 75% Maximum Heart Rate Activity' => '6 = Better Than Average Fit with Balanced Nutrition and Consistent Weekly 75% Maximum Heart Rate Activity',
            '7 = In Shape Fit with Balanced Nutrition and Consistent Weekly 80% Maximum Heart Rate Activity' => '7 = In Shape Fit with Balanced Nutrition and Consistent Weekly 80% Maximum Heart Rate Activity',
            '8 = In Shape Fit with Balanced Nutrition and Consistent Weekly 85% Maximum Heart Rate Activity' => '8 = In Shape Fit with Balanced Nutrition and Consistent Weekly 85% Maximum Heart Rate Activity',
            '9 = Very Fit with Balanced Nutrition and Consistent Weekly 90% Maximum Heart Rate Activity' => '9 = Very Fit with Balanced Nutrition and Consistent Weekly 90% Maximum Heart Rate Activity',
            '10 = Extremely Fit with Balanced Nutrition and Consistent Weekly 95% Maximum Heart Rate Activity' => '10 = Extremely Fit with Balanced Nutrition and Consistent Weekly 95% Maximum Heart Rate Activity'
        );
        return View('home.fitness_info', $data);
    }

    public function UpdateFitnessInfo(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->insertUpdateFitnessInfo($request);

        if ($status == 1) {
            session()->flash("msg", "Fitness Info Updated Succesfully");
            return redirect()->route("UserFitnessInfo");
        } else {
            session()->flash("msg", "Fitness Info Added Succesfully");
            return redirect()->route("UserFitnessInfo");
        }
    }

    public function UserPersonalInfo(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserProfile";
        $data['tab'] = "PersonalInfo";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['prop_class'] = 'active';
        $data['title'] = 'Edit User';
        $data['height_arr'] = array('4\'7"' => '4\'7"', '4\'8"' => '4\'8"', '4\'9"' => '4\'9"', '4\'10"' => '4\'10"', '4\'11"' => '4\'11"', '5\'' => '5\'', '5\'1"' => '5\'1"', '5\'2"' => '5\'2"', '5\'3"' => '5\'3"', '5\'4"' => '5\'4"', '5\'5"' => '5\'5"', '5\'6"' => '5\'6"', '5\'7"' => '5\'7"', '5\'8"' => '5\'8"', '5\'9"' => '5\'9"', '5\'10"' => '5\'10"', '5\'11"' => '5\'11"', '6\'' => '6\'', '6\'1"' => '6\'1"', '6\'2"' => '6\'2"', '6\'3"' => '6\'3"', '6\'4"' => '6\'4"', '6\'5"' => '6\'5"', '6\'6"' => '6\'6"', '6\'7"' => '6\'7"', '6\'8"' => '6\'8"', '6\'9"' => '6\'9"', '6\'10"' => '6\'10"', '6\'11"' => '6\'11"', '7\'' => '7\'', 'Other' => 'Other');
        $data['body_type_arr'] = array('Slim' => 'Slim', 'Athletic' => 'Athletic', 'Average' => 'Average', 'Curvy' => 'Curvy', 'A few extra pounds' => 'A few extra pounds', 'Full / overweight' => 'Full / overweight', 'Other' => 'Other');
        $data['ethnicity_arr'] = array('Asian' => 'Asian', 'Black / African descent' => 'Black / African descent', 'Latin/Hispanic' => 'Latin/Hispanic', 'East Indian' => 'East Indian', 'Middle Eastern' => 'Middle Eastern', 'Mixed' => 'Mixed', 'Native American' => 'Native American', 'Pacific Islander' => 'Pacific Islander', 'White / Caucasian' => 'White / Caucasian', 'Other' => 'Other');
        $data['education_arr'] = array('High School' => 'High School', 'Some College' => 'Some College', 'Asociates Degree' => 'Associates Degree', 'Bachelors Degree' => 'Bachelors Degree', 'Graduate Degree' => 'Graduate Degree', 'PhD / Post Doctoral' => 'PhD / Post Doctoral');
        $data['relationship_arr'] = array('Single' => 'Single', 'Divorced' => 'Divorced', 'Separated' => 'Separated', 'Married But Looking' => 'Married But Looking', 'Open Relationship', 'Widowed' => 'Widowed');
        $data['children_arr'] = array('Prefer not to Say' => 'Prefer not to Say', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6+' => '6+');
        $data['smoking_arr'] = array('Non Smoker' => 'Non Smoker', 'Light Smoker' => 'Light Smoker', 'Heavy Smoker' => 'Heavy Smoker');
        $data['drinking_arr'] = array('Non Drinker' => 'Non Drinker', 'Social Drinker' => 'Social Drinker', 'Heavy Drinker' => 'Heavy Drinker');
        $data['language_arr'] = array('English' => 'English', 'Espanol' => 'Espanol', 'Francais' => 'Francais', 'Deutsch' => 'Deutsch', 'Chinese symbols' => 'Chinese symbols', 'Japanese symbols' => 'Japanese symbols', 'Nederlandse' => 'Nederlandse', 'Portugues' => 'Portugues');
        $data['data'] = $user_obj->getPersonalInfo($request->session()->get('user_id'));
        return View('home.personal_info', $data);
    }

    public function UpdatePersonalInfo(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }

        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->insertUpdatePersonalInfo($request);
        $user_class = 'active';
        $title = 'User';
        if ($status == true) {
            session()->flash("msg", "Personal Info Updated Succesfully");
            return redirect()->route("UserPersonalInfo");
        }
    }

    public function UserPhotos(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserProfile";
        $data['tab'] = "Photos";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['data'] = $user_obj->getPhotosInfo($request->session()->get('user_id'));
        $data['public_photos'] = $user_obj->getPublicPhotosInfo($request->session()->get('user_id'));
        $data['private_photos'] = $user_obj->getPrivatePhotosInfo($request->session()->get('user_id'));
        return View('home.photos', $data);
    }

    public function UserUploadPhotos(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserProfile";
        $data['tab'] = "Photos";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $status = $user_obj->updatePhotosInfo($request);
        $data['public_photos'] = $user_obj->getPublicPhotosInfo($request->session()->get('user_id'));
        if ($status == true) {
            return view('home/show_photos', $data);
        }
    }

    public function UserUploadPrivatePhotos(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserProfile";
        $data['tab'] = "Photos";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $status = $user_obj->updatePhotosInfo($request);
        $data['private_photos'] = $user_obj->getPrivatePhotosInfo($request->session()->get('user_id'));
        if ($status == true) {
            return view('home/show_private_photos', $data);
        }
    }

    public function UserDeletePhotos(Request $request, $photo_id, $user_id) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->deleteUserPhotosInfo($photo_id);

        $user_class = 'active';
        $title = 'Photos';
        if ($status == true) {
            session()->flash("msg", "Photo Deleted Succesfully");
            return redirect()->route("UserPhotos");
        } else {
            session()->flash("msg", "Photo Not Deleted ");
            return redirect()->route("UserPhotos");
        }
    }

    public function UserLocationInfo(Request $request, $flag = "") {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserProfile";
        $data['tab'] = "LocationInfo";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['location_info'] = $user_obj->getLocationInfo($request->session()->get('user_id'));
        $data['primary_location'] = $user_obj->getPrimaryLocation($request->session()->get('user_id'));
        $data['secondary_location'] = $user_obj->getSecondaryLocaton($request->session()->get('user_id'));

        if ($flag == 1) {
            $data['msg'] = "Location Updated Successfully !!!";
        }

        return View('home.location_info', $data);
    }

    public function AddLocation(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->addLocation($request);

        if ($status == true) {
            session()->flash("msg", "Location Added Successfully");
            return redirect()->route("UserLocationInfo");
        }
    }

    public function EditLocation(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->editLocation($request);
        if ($status == true) {
            return 1;
        } else {
            return 0;
        }
    }

    public function DeleteLocation(Request $request, $loc_id) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->delteLocationInfo($loc_id);

        if ($status == true) {
            session()->flash("msg", "Location Deleted Successfully");
            return redirect()->route("UserLocationInfo");
        }
    }

    public function SetPrimaryUserLocation(Request $request, $loc_id, $user_id) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->setPrimaryLoc($loc_id, $user_id);

        if ($status == true) {
            session()->flash("msg", "Secondary Location Changed To Primary Location Successfully");
            return redirect()->route("UserLocationInfo");
        }
    }

    public function UserDescription(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserProfile";
        $data['tab'] = "Description";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['user_description'] = $user_obj->getUserDescriptionInfo($request->session()->get('user_id'));
        $data['looking_for_tags'] = array(
            'Runner' => 'Runner',
            "10k runner" => "10k runner",
            "Marathoner" => "Marathoner",
            "Bicyclist" => "Bicyclist",
            "Triathlete" => "Triathlete",
            "Tough Mudder competitor" => "Tough Mudder competitor",
            "Orange Theory Fitness fanatic" => "Orange Theory Fitness fanatic",
            "WYCrossFit member" => "CrossFit member"
        );
        return View('home.your_description', $data);
    }

    public function UpdateUserDescription(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_id = $request->session()->get('user_id');
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->insertUpdateUserDescription($request, $user_id);

        if ($status == 1) {
            session()->flash("msg", "User Description Info Updated Succesfully");
            return redirect()->route("UserDescription");
        } else {
            session()->flash("msg", "User Description Info Added Succesfully");
            return redirect()->route("UserDescription");
        }
    }

    public function UserSettings(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserSettings";
        $data['tab'] = "AccountSettings";
        $data['user_details'] = $user_obj->getAccountSettingsInfo($request->session()->get('user_id'));

        return View('home.account_setting', $data);
    }

    public function MatchPassword(Request $request) {
        $current_password = $request->old_password;
        $user_id = $request->session()->get('user_id');

        $user_obj = new UserDetail();

        $response = $user_obj->matchPassword($current_password, $user_id);
        echo $response;
        exit;
    }

    public function UpdateOldPassword(Request $request) {
        $user_id = $request->session()->get('user_id');
        $update = 'UPDATE user_credentials SET password="' . md5($request->new_password) . '" WHERE id=' . $user_id . '';
        $update = DB::select($update);

        session()->flash("msg", "Password Updated Successfully");
        return redirect()->route("UserSettings");
    }

    public function UpdateAccountSettings(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_id = $request->session()->get('user_id');
        $userdetail_obj = new UserDetail;
        $status = $userdetail_obj->updateAccountSettingsInfo($request, $user_id);

        if ($status == 1) {
            session()->flash("msg", "Account Settings Updated Succesfully");
            return redirect()->route("UserSettings");
        } else {
            session()->flash("msg", "Username Already Exist !!!");
            return redirect()->route("UserSettings");
        }
    }

    public function UserFavorites(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserInterests";
        $data['tab'] = "Favorites";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['favorites_info'] = $user_obj->getFavoriteInfo($request->session()->get('user_id'));
        return View('home.interests', $data);
    }

    public function UserViewedMe(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserInterests";
        $data['tab'] = "ViewedMe";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['viewed_me_info'] = $user_obj->getViewedMeInfo($request->session()->get('user_id'));
        $data['profile_complete'] = $user_obj->getProfileComplete($request->session()->get('user_id'));
//         echo "<pre>";         print_r($data);die;
        return View('home.viewed_me', $data);
    }

    public function UserFavoritedMe(Request $request) {

        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserInterests";
        $data['tab'] = "FavoritedMe";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['favoritedme_info'] = $user_obj->getFavoriteMeInfo($request->session()->get('user_id'));
        return View('home.favoritedme', $data);
    }

    public function UserPayWithCreditCard(Request $request, $user_id) {
        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['trainer_id'] = $user_id;
        $data['rka_charge'] = 2;
        $data['menu'] = "UserDashboard";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        $data['user_credit_details'] = $user_obj->getHireMeDetails($user_id);
        return View('home.pay_using_credit_card', $data);
    }

    public function UserPayWithPaypal(Request $request) {
        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserDashboard";
        $data['user_details'] = $user_obj->getBasicInfo($request->session()->get('user_id'));
        return View('home.pay_using_paypal', $data);
    }

    public function UserSearchFilter(Request $request) {
        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }

        $search_obj = new SearchModel();
        $data['search_data'] = $search_obj->advanceSearch($request);
    }

    public function UserAddFavorite(Request $request) {
        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data['menu'] = "UserDashboard";
        $trainer_id = $request->trainer_id;
        $fav_count = $user_obj->countFav($trainer_id);
        if ($fav_count == 0) {
            $data = $user_obj->addFavorite($request);
        } else {
            $data = $user_obj->deleteFavorite($request);
        }
        return $data;
    }

    public function UserCreditCardDetailsAdd(Request $request, $trainer_id) {
        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        
        $order_no = "RKA" . time() . rand("111111", "999999");
        $expiary = explode("/", $request->expiary);
        
        $credit_obj = new UserDetail();                
        $admin_details = $credit_obj->getAdminPaymentDetails();
        $country_data = $credit_obj->getCountryName($request->country);       
        
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
            'expMonth' => $expiary[0],
            'expYear' => $expiary[1],
            'cvv' => $request->cvv,
            'firstName' => $request->billing_firstname,
            'lastName' => $request->billing_lastname,
            'city' => $request->city,
            'zip' => $request->state,
            'countryCode' => $country_data[0]->country_name,
        );
        
        $paypal = new PaypalPro($config);
        $response = $paypal->paypalCall($paypalParam);
        
        if (isset($response['ACK']) && $response['ACK'] == 'Success') {
            $credit_obj->addCreditDetails($request, $trainer_id, $response['TRANSACTIONID'], $order_no);
        }
    }

    public function UserUpdateCurrentLocation(Request $request) {
        if ($request->session()->get('user_id') == "") {
            return redirect()->route("UserLogin");
        }
        $user_obj = new UserDetail();
        $data = $user_obj->updateCurrentLocation($request);
    }

}

?>
