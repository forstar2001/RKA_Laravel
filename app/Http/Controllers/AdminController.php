<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Request;
use App\UserDetail;
use App\AdminModel;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Session;
use Mail;
use File;
use Excel;
use PDF;

Class AdminController extends Controller {

    public function Login(Request $request) {
        if ($request->session()->has('admin_userid')) {

            return redirect()->route('AdminHome');
            Redirect::to('/AdminHome');
        } else {
            $data = array('title' => 'Login Page','theme_type' => 'admin');
            return View('admin.login', $data);
        }
    }

    public function Logout(Request $request) {
        $request->session()->forget('key');
        $request->session()->flush();
        return redirect()->route('Admin');
    }

    public function LoginAccess(Request $request) {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
            $select = 'SELECT * FROM user_credentials WHERE profile_id=1';
            $all_data = DB::select($select);
        $match = 0;
        foreach ($all_data as $each_data) {
            if ($each_data->username == $request['username'] && $each_data->password == md5($request['password'])) {
                $match = 1;
                session(['admin_userid' => $each_data->id]);
                break;
            }
        }
        if ($match == 0)
            return redirect()->back();
        else
            return redirect()->route('AdminHome');
    }

    public function AdminHome(Request $request) {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Home Page','theme_type' => 'admin','menu' => 'user_list');
            $userdetail_obj = new UserDetail;
            $data['user_data'] = $userdetail_obj->getUserData(); 
            $data['athlete_type_arr'] = array(1=>'ELITE CHAMPION',2=>'PERFORMANCE RACER',3=>'ASPIRING ATHLETE');   
            $data['trainer_type_arr'] = array(1=>'Personal trainers / coaches',2=>'Racing partners',3=>'Training partners',4=>'Fitness buddies',5=>'Repair / recovery specialists',6=>'All of them');       
            return View('admin.users', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function EditUser(Request $request, $id, $tab_id=1) {
        if ($request->session()->has('admin_userid')) {

            $userdetail_obj = new UserDetail;

            if($tab_id==1)
            {
            $prop_class = 'active';
            $title = 'Edit User';
            $looking_for_arr = array('Personal trainers / coaches'=>'Personal trainers / coaches','Racing Partners'=>'Racing Partners','Training Partners'=>'Training Partners','Fitness Buddies'=>'Fitness Buddies','Repair / recovery specialists'=>'Repair / recovery specialists','All of them'=>'All of them');                
            $fitness_budget_arr = array('None'=>'None','Negotiable (I don’t have a set budget)'=>'Negotiable (I don’t have a set budget)','Minimal (Up to $500 monthly)'=>'Minimal (Up to $500 monthly)','Practical (Up to $1000 monthly)'=>'Practical (Up to $1000 monthly)','Moderate (Up to $3000 monthly)'=>'Moderate (Up to $3000 monthly)','Substantial (Up to $5000 monthly)'=>'Substantial (Up to $5000 monthly)','High (More than $5000 monthly)'=>'High (More than $5000 monthly)');
            $allowance_expectations_arr= array('None'=>'None','Negotiable (I don’t have a set budget)'=>'Negotiable (I don’t have a set budget)','Minimal (Up to $500 monthly)'=>'Minimal (Up to $500 monthly)','Practical (Up to $1000 monthly)'=>'Practical (Up to $1000 monthly)','Moderate (Up to $3000 monthly)'=>'Moderate (Up to $3000 monthly)','Substantial (Up to $5000 monthly)'=>'Substantial (Up to $5000 monthly)','High (More than $5000 monthly)'=>'High (More than $5000 monthly)');
            $data = $userdetail_obj->getBasicInfo($id); 
            $user_other_info = $userdetail_obj->userOtherInfo($id);
            if($data[0]->profile_id==3 || $data[0]->profile_id==4)
            $looking_for_arr = array('Performance Racers'=>'Performance Racers','Leisure Athletes'=>'Leisure Athletes','Aspiring Athletes'=>'Aspiring Athletes','Personal Trainers/Coaches'=>'Personal Trainers/Coaches','Racing Partners'=>'Racing Partners','Training Partners'=>'Training Partners','Repair/ Recovery Specialists'=>'Repair/ Recovery Specialists','Fitness Buddies'=>'Fitness Buddies','All'=>'All'); 
            $rate_expectation_arr = array('Negotiable Rates (I don\'t have a set rate)'=>'Negotiable Rates (I don\'t have a set rate)','Fixed Rates'=>'Fixed Rates','Hourly Rates'=>'Hourly Rates','Both Fixed and Hourly Rates'=>'Both Fixed and Hourly Rates');
            return View('admin.edit_user_basic', ['menu' => 'user_list','title' => $title, 'looking_for_arr' => $looking_for_arr, 'fitness_budget_arr' => $fitness_budget_arr, 'allowance_expectations_arr' => $allowance_expectations_arr, 'rate_expectation_arr' => $rate_expectation_arr, 'data' => $data, 'tab_id' => $tab_id, 'id' => $id]);
            } 
            elseif($tab_id==2)
            {
            $prop_class = 'active';
            $title = 'Edit User';              
            $fitness_level_arr=array('1 = Completely Sedentary and Out of Shape'=>'1 = Completely Sedentary and Out of Shape',
                                     '2 = Somewhat Sedentary and Out of Shape'=>'2 = Somewhat Sedentary and Out of Shape',
                                     '3 = Out of Shape with Rare Activity'=>'3 = Out of Shape with Rare Activity',
                                     '4 = Less Than Average Fit with Occasional Activity'=>'4 = Less Than Average Fit with Occasional Activity',
                                     '5 = Average Fit with Weekly Activity'=>'5 = Average Fit with Weekly Activity',
                                     '6 = Better Than Average Fit with Balanced Nutrition and Consistent Weekly 75% Maximum Heart Rate Activity'=>'6 = Better Than Average Fit with Balanced Nutrition and Consistent Weekly 75% Maximum Heart Rate Activity',
                                     '7 = In Shape Fit with Balanced Nutrition and Consistent Weekly 80% Maximum Heart Rate Activity'=>'7 = In Shape Fit with Balanced Nutrition and Consistent Weekly 80% Maximum Heart Rate Activity',
                                     '8 = In Shape Fit with Balanced Nutrition and Consistent Weekly 85% Maximum Heart Rate Activity'=>'8 = In Shape Fit with Balanced Nutrition and Consistent Weekly 85% Maximum Heart Rate Activity',
                                     '9 = Very Fit with Balanced Nutrition and Consistent Weekly 90% Maximum Heart Rate Activity'=>'9 = Very Fit with Balanced Nutrition and Consistent Weekly 90% Maximum Heart Rate Activity',
                                     '10 = Extremely Fit with Balanced Nutrition and Consistent Weekly 95% Maximum Heart Rate Activity'=>'10 = Extremely Fit with Balanced Nutrition and Consistent Weekly 95% Maximum Heart Rate Activity'
                                    );
            $swim_time_arr = array('I don\'t know'=>'I don\'t know','8 min/mile'=>'8 min/mile');
            for($i=19;$i<47;$i++)
            {
            $swim_time_arr[$i]=$i;    
            }
            $swim_time_arr['47+']='47+';

            $bike_speed_arr = array('I don\'t know'=>'I don\'t know','8 mph'=>'8 mph');
            for($j=9;$j<25;$j++)
            {
            $bike_speed_arr[$j]=$j;    
            }
            $bike_speed_arr['25+']='25+';

            $run_time_arr = array('I don\'t know'=>'I don\'t know','4 min/mile'=>'4 min/mile');
            for($k=5;$k<18;$k++)
            {
            $run_time_arr[$k]=$k;    
            }
            $run_time_arr['25+']='25+';

            $dropdown_values['group_workout_info_locations'] = $userdetail_obj->get_group_workout_info_locations(); 
            $dropdown_values['gym_memberships'] = $userdetail_obj->get_gym_memberships();
            $dropdown_values['outdoor_workout_locations'] = $userdetail_obj->get_outdoor_workout_locations(); 
            $dropdown_values['scheduled_races'] = $userdetail_obj->get_scheduled_races();
            
            $data = $userdetail_obj->getFitnessInfo($id);    
            return View('admin.edit_user_fitness', ['menu' => 'user_list','title' => $title, 'dropdown_values' => $dropdown_values, 'fitness_level_arr' =>$fitness_level_arr, 'swim_time_arr' => $swim_time_arr, 'bike_speed_arr' => $bike_speed_arr, 'run_time_arr' => $run_time_arr, 'data' => $data, 'tab_id' => $tab_id, 'id' => $id]);
            } 
            elseif($tab_id==3)
            {
            $prop_class = 'active';
            $title = 'Edit User';
            $height_arr = array('4\'7"'=>'4\'7"','4\'8"'=>'4\'8"','4\'9"'=>'4\'9"','4\'10"'=>'4\'10"','4\'11"'=>'4\'11"','5\''=>'5\'','5\'1"'=>'5\'1"','5\'2"'=>'5\'2"','5\'3"'=>'5\'3"','5\'4"'=>'5\'4"','5\'5"'=>'5\'5"','5\'6"'=>'5\'6"','5\'7"'=>'5\'7"','5\'8"'=>'5\'8"','5\'9"'=>'5\'9"','5\'10"'=>'5\'10"','5\'11"'=>'5\'11"','6\''=>'6\'','6\'1"'=>'6\'1"','6\'2"'=>'6\'2"','6\'3"'=>'6\'3"','6\'4"'=>'6\'4"','6\'5"'=>'6\'5"','6\'6"'=>'6\'6"','6\'7"'=>'6\'7"','6\'8"'=>'6\'8"','6\'9"'=>'6\'9"','6\'10"'=>'6\'10"','6\'11"'=>'6\'11"','7\''=>'7\'','Other'=>'Other');                
            $body_type_arr = array('Slim'=>'Slim','Athletic'=>'Athletic','Average'=>'Average','Curvy'=>'Curvy','A few extra pounds'=>'A few extra pounds','Full / overweight'=>'Full / overweight','Other'=>'Other');
            $ethnicity_arr = array('Asian'=>'Asian','Black / African descent'=>'Black / African descent','Latin/Hispanic'=>'Latin/Hispanic','East Indian'=>'East Indian','Middle Eastern'=>'Middle Eastern','Mixed'=>'Mixed','Native American'=>'Native American','Pacific Islander'=>'Pacific Islander','White / Caucasian'=>'White / Caucasian','Other'=>'Other');
            $education_arr = array('High School'=>'High School','Some College'=>'Some College','Asociates Degree'=>'Associates Degree','Bachelors Degree'=>'Bachelors Degree','Graduate Degree'=>'Graduate Degree','PhD / Post Doctoral'=>'PhD / Post Doctoral');
            $relationship_arr = array('Single'=>'Single','Divorced'=>'Divorced','Separated'=>'Separated','Married But Looking'=>'Married But Looking','Open Relationship','Widowed'=>'Widowed');
            $children_arr = array('Prefer not to Say'=>'Prefer not to Say','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6+'=>'6+');
            $smoking_arr = array('Non Smoker'=>'Non Smoker','Light Smoker'=>'Light Smoker','Heavy Smoker'=>'Heavy Smoker');
            $drinking_arr = array('Non Drinker'=>'Non Drinker','Social Drinker'=>'Social Drinker','Heavy Drinker'=>'Heavy Drinker');
            $language_arr = array('English'=>'English','Espanol'=>'Espanol','Francais'=>'Francais','Deutsch'=>'Deutsch','Chinese symbols'=>'Chinese symbols','Japanese symbols'=>'Japanese symbols','Nederlandse'=>'Nederlandse','Portugues'=>'Portugues');
            $data = $userdetail_obj->getPersonalInfo($id); 
            return View('admin.edit_user_personal', ['menu' => 'user_list','title' => $title, 'height_arr' => $height_arr, 'body_type_arr' => $body_type_arr, 'ethnicity_arr' => $ethnicity_arr, 'education_arr' => $education_arr, 'relationship_arr' => $relationship_arr, 'children_arr' => $children_arr, 'smoking_arr' => $smoking_arr, 'drinking_arr' => $drinking_arr, 'language_arr' => $language_arr, 'data' => $data, 'tab_id' => $tab_id, 'id' => $id]);
            } 
            elseif($tab_id==4)
            {
                $prop_class = 'active';
                $title = 'Edit User';
                $data = $userdetail_obj->getPhotosInfo($id); 
                $photos['public_photos'] = $userdetail_obj->getPublicPhotosInfo($id); 
                $photos['private_photos'] = $userdetail_obj->getPrivatePhotosInfo($id); 
                return View('admin.edit_user_photos', ['menu' => 'user_list','title' => $title,'data' => $data,'photos' => $photos, 'tab_id' => $tab_id, 'id' => $id]);
            }
            elseif($tab_id==5)
            {
                $prop_class = 'active';
                $title = 'Edit User';
                $data = $userdetail_obj->getLocationInfo($id); 
                $location['primary_location']= $userdetail_obj->getPrimaryLocation($id); 
                $location['secondary_location']= $userdetail_obj->getSecondaryLocaton($id); 
                return View('admin.edit_user_location', ['menu' => 'user_list','title' => $title,'data' => $data,'location' => $location, 'tab_id' => $tab_id, 'id' => $id]);
            }
            elseif($tab_id==6)
            {
                $prop_class = 'active';
                $title = 'Edit User';
                $data = $userdetail_obj->getUserDescriptionInfo($id); 
                $looking_for_tags = array(
                    'Runner' => 'Runner',
                    "10k runner"=>"10k runner",
                    "Marathoner"=>"Marathoner",
                    "Bicyclist"=>"Bicyclist",
                    "Triathlete"=>"Triathlete",
                    "Tough Mudder competitor"=>"Tough Mudder competitor",
                    "Orange Theory Fitness fanatic"=>"Orange Theory Fitness fanatic",
                    "WYCrossFit member"=>"CrossFit member"
                );
                return View('admin.edit_user_description', ['menu' => 'user_list','title' => $title,'data' => $data,'looking_for_tags'=>$looking_for_tags, 'tab_id' => $tab_id, 'id' => $id]);
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function EditUserBasic(Request $request) {
        if ($request->session()->has('admin_userid')) {

            $redirect_url = $request->redirect_url;

            if($redirect_url==""){
                $redirect_url = "/AdminHome";
            }

            $validator = Validator::make(Input::all(), array(
                        'first_name' => "required|max:255",
                        'date_of_birth' => 'required',
                        'gender' => "required",
                        'username' => 'required'
                            )
            );

            if ($validator->fails()) {
                $from = 'edit_user';
                $user_class = 'active';
                $title = 'Edit User';
                return Redirect::route("EditUser", array('id' => $request->id))
                                ->with('user_class', $user_class)->with('title', $title)
                                ->withErrors($validator)
                                ->withInput();
            } else {
                $userdetail_obj = new UserDetail;

                $status=$userdetail_obj->updateBasicInfo($request);

                $user_class = 'active';
                $title = 'User';
                if ($status==true) {
                    return Redirect::to($request->redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The User is successfully updated!</div>')->with('user_class', $user_class)->with('title', $title);
                }
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function EditUserFitness(Request $request) {      
        if ($request->session()->has('admin_userid')) {
            $redirect_url = $request->redirect_url;

            if($redirect_url==""){
                $redirect_url = "/AdminHome";
            }

            $validator = Validator::make(Input::all(), array(
                        'fitness_goals' => 'required'
                            )
            );

            if ($validator->fails()) {
                $from = 'edit_user';
                $user_class = 'active';
                $title = 'Edit User';
                return Redirect::route("EditUser", array('id' => $request->id))
                                ->with('user_class', $user_class)->with('title', $title)
                                ->withErrors($validator)
                                ->withInput();
            } else {
                $userdetail_obj = new UserDetail;

                $status=$userdetail_obj->updateFitnessInfo($request);

                $user_class = 'active';
                $title = 'User';
                if ($status==true) {
                    return Redirect::to($request->redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The User is successfully updated!</div>')->with('user_class', $user_class)->with('title', $title);
                }
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }    

    public function EditUserPersonal(Request $request) {
        if ($request->session()->has('admin_userid')) {
            $redirect_url = $request->redirect_url;

            if($redirect_url==""){
                $redirect_url = "/AdminHome";
            }

            $validator = Validator::make(Input::all(), array(
                        'occupation' => "required|max:255"
                            )
            );

            if ($validator->fails()) {
                $from = 'edit_user';
                $user_class = 'active';
                $title = 'Edit User';
                return Redirect::route("EditUser", array('id' => $request->id))
                                ->with('user_class', $user_class)->with('title', $title)
                                ->withErrors($validator)
                                ->withInput();
            } else {
                $userdetail_obj = new UserDetail;

                $status=$userdetail_obj->updatePersonalInfo($request);

                $user_class = 'active';
                $title = 'User';
                if ($status==true) {
                    return Redirect::to($request->redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The User is successfully updated!</div>')->with('user_class', $user_class)->with('title', $title);
                }
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function EditUserPhotos(Request $request) {       
        if ($request->session()->has('admin_userid')) {
            $redirect_url = $request->redirect_url;

            if($redirect_url==""){
                $redirect_url = "/AdminHome";
            }

            $userdetail_obj = new UserDetail;
            $status=$userdetail_obj->updatePhotosInfo($request);

            $user_class = 'active';
            $title = 'Photos';
            if ($status==true) {
                return Redirect::to($request->redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The User is successfully updated!</div>')->with('user_class', $user_class)->with('title', $title);
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function DeleteUserPhoto(Request $request,$photo_id,$user_id) {
        if ($request->session()->has('admin_userid')) {

            $redirect_url = 'Admin/EditUser/' . $user_id.'/4';
            
            $userdetail_obj = new UserDetail;
            $status=$userdetail_obj->deltePhotosInfo($photo_id);

            $user_class = 'active';
            $title = 'Photos';
            if ($status==true) {
                return Redirect::to($redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The image is successfully deleted!</div>')->with('user_class', $user_class)->with('title', $title);
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function SetPrimaryUserLocation(Request $request,$loc_id,$user_id) {
        if ($request->session()->has('admin_userid')) {

            $redirect_url = 'Admin/EditUser/' . $user_id.'/5';

            $userdetail_obj = new UserDetail;
            $status=$userdetail_obj->setPrimaryLoc($loc_id,$user_id);

            $user_class = 'active';
            $title = 'Location';
            if ($status==true) {
                return Redirect::to($redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The location is successfully updated!</div>')->with('user_class', $user_class)->with('title', $title);
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function DeleteUserLocation(Request $request,$loc_id,$user_id) {
        if ($request->session()->has('admin_userid')) {

            $redirect_url = 'Admin/EditUser/' . $user_id.'/5';

            $userdetail_obj = new UserDetail;
            $status=$userdetail_obj->delteLocationInfo($loc_id);

            $user_class = 'active';
            $title = 'Location';
            if ($status==true) {
                return Redirect::to($redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The location is successfully deleted!</div>')->with('user_class', $user_class)->with('title', $title);
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function EditUserLocation(Request $request) {
        if ($request->session()->has('admin_userid')) {
            $redirect_url = $request->redirect_url;

            if($redirect_url==""){
                $redirect_url = "/AdminHome";
            }

            $userdetail_obj = new UserDetail;
            $status=$userdetail_obj->updateLocationInfo($request);

            $user_class = 'active';
            $title = 'Location';
            if ($status==true) {
                return Redirect::to($request->redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The location is successfully updated!</div>')->with('user_class', $user_class)->with('title', $title);
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function EditUserDescription(Request $request) {
        if ($request->session()->has('admin_userid')) {
            $redirect_url = $request->redirect_url;

            if($redirect_url==""){
                $redirect_url = "/AdminHome";
            }

            $userdetail_obj = new UserDetail;
            $status=$userdetail_obj->updateDescriptionInfo($request);

            $user_class = 'active';
            $title = 'User Description';
            if ($status==true) {
                return Redirect::to($request->redirect_url)->with('global', '<div class="alert alert-success alert-dismissable">
                                            <i class="fa fa-check"></i>
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b>Alert!</b> The User is successfully updated!</div>')->with('user_class', $user_class)->with('title', $title);
            }
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function DeleteUser($id)
    {
        $userdetail_obj = new UserDetail;
        $status=$userdetail_obj->deleteUser($id);

    }
    
    public function GroupWorkoutInfoAndLocation(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Home Page','theme_type' => 'admin','menu' => 'group_workout' );
            $admin_obj = new AdminModel();
            $data['group_workout_info'] = $admin_obj->getGroupWorkoutInfo();     
            return View('admin.group_workout_info', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function AddGroupWorkoutInfoAndLocation(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Add Group Workout Information','theme_type' => 'admin','menu' => 'group_workout');    
            return View('admin.add_group_workout_info', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function AddGroupWorkoutInfoAction(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Add Group Workout Information','theme_type' => 'admin','menu' => 'group_workout');    
            $admin_obj = new AdminModel();
            $admin_obj->addGroupWorkoutInfo($request);
            return redirect()->route("GroupWorkoutInfo")->with('global', '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <b>Alert!</b> The group workout info and location is added successfully!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function EditGroupWorkoutInfo(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Edit Group Workout Information','theme_type' => 'admin','menu' => 'group_workout');
            $id= $request->id;
            $admin_obj = new AdminModel();
            $data['GroupWorkoutValue'] = $admin_obj->selectGroupWorkoutInfo($id);
            
            return View('admin.edit_group_workout_info', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function EditGroupWorkoutInfoAction(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Group Workout Information','theme_type' => 'admin','menu' => 'group_workout');    
            $admin_obj = new AdminModel();
            $admin_obj->editGroupWorkoutInfo($request);
            return redirect()->route("GroupWorkoutInfo")->with('global', '<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The group workout info and location is successfully updated!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function DeleteGroupWorkoutInfo(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Group Workout Information','theme_type' => 'admin','menu' => 'group_workout');
            $id= $request->id;
            $admin_obj = new AdminModel();
            $admin_obj->deleteGroupWorkoutInfo($id);
            return redirect()->route("GroupWorkoutInfo")->with('global', '<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The group workout info and location is successfully deleted!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function GymMembership(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Home Page','theme_type' => 'admin','menu' => 'gym_membership');
            $admin_obj = new AdminModel();
            $data['gym_membership'] = $admin_obj->getGymMembership();     
            return View('admin.gym_membership', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function AddGymMembership(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Add Gym Membership','theme_type' => 'admin','menu' => 'gym_membership');    
            return View('admin.add_gym_membership', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function AddGymMembershipAction(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Gym Membership','theme_type' => 'admin','menu' => 'gym_membership');    
            $admin_obj = new AdminModel();
            $admin_obj->addGymMembership($request);
            return redirect()->route("GymMembership")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The gym membership is successfully added!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function EditGymMembership(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Edit Gym Membership','theme_type' => 'admin','menu' => 'gym_membership');
            $id= $request->id;
            $admin_obj = new AdminModel();
            $data['GymMembershipValue'] = $admin_obj->selectGymMembership($id);
            
            return View('admin.edit_gym_membership', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function EditGymMembershipAction(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Gym Membership','theme_type' => 'admin','menu' => 'gym_membership');    
            $admin_obj = new AdminModel();
            $admin_obj->editGymMembership($request);
            return redirect()->route("GymMembership")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The gym membership is successfully updated!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function DeleteGymMembership(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Gym Membership','theme_type' => 'admin','menu' => 'gym_membership');
            $id= $request->id;
            $admin_obj = new AdminModel();
            $admin_obj->deleteGymMembership($id);
            return redirect()->route("GymMembership")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The gym membership is successfully deleted!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function ScheduledRacesInfo(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Home Page','theme_type' => 'admin','menu' => 'scheduled_race');
            $admin_obj = new AdminModel();
            $data['scheduled_races_info'] = $admin_obj->getScheduledRacesInfo();     
            return View('admin.scheduled_races_info', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function AddScheduledRacesInfo(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Add Scheduled Race','theme_type' => 'admin','menu' => 'scheduled_race');    
            return View('admin.add_scheduled_races_info', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function AddScheduledRacesInfoAction(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Scheduled Races Information','theme_type' => 'admin','menu' => 'scheduled_race');    
            $admin_obj = new AdminModel();
            $admin_obj->addScheduledRacesInfo($request);
            return redirect()->route("ScheduledRacesInfo")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The scheduled races info is successfully added!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function EditScheduledRacesInfo(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Edit Scheduled Race','theme_type' => 'admin','menu' => 'scheduled_race');
            $id= $request->id;
            $admin_obj = new AdminModel();
            $data['ScheduledRacesInfoValue'] = $admin_obj->selectScheduledRacesInfo($id);
            
            return View('admin.edit_scheduled_races_info', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function EditScheduledRacesInfoAction(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Scheduled Races Info','theme_type' => 'admin','menu' => 'scheduled_race');    
            $admin_obj = new AdminModel();
            $admin_obj->editScheduledRacesInfo($request);
            return redirect()->route("ScheduledRacesInfo")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The scheduled races info is successfully updated!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function DeleteScheduledRacesInfo(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Scheduled Races Info','theme_type' => 'admin','menu' => 'scheduled_race');
            $id= $request->id;
            $admin_obj = new AdminModel();
            $admin_obj->deleteScheduledRacesInfo($id);
            return redirect()->route("ScheduledRacesInfo")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The scheduled races info is successfully deleted!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }

      public function show_outdoor_workout_location_info(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Home Page','theme_type' => 'admin','menu' => 'outdoor_workout');
            $show_outdoor_info_obj=new AdminModel();
            $show_outdoor_info_obj->getOutdoorInfo();
            $data['show_outdoor_info'] = $show_outdoor_info_obj->getOutdoorInfo(); 
            return View('admin.show_outdoor_workout_location', $data);
        }
        else
        {
          Redirect::to('/AdminHome');  
        }
    }

    public function add_outdoor_workout_location_info(Request $request)
    {
         if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Add Outdoor Workout Information','theme_type' => 'admin','menu' => 'outdoor_workout');    
               return View('admin.add_outdoor_workout_location',$data);
        } else {
            Redirect::to('/AdminHome');
        }
   
    }
    
    public function add_outdoor_workout_location_info_action(Request $request)
    {
          if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Add Outdoor Workout Information','theme_type' => 'admin','menu' => 'outdoor_workout');    
            $admin_obj = new AdminModel();
            $admin_obj->addOutdoorWorkoutLocationInfo($request);
            return redirect()->route("OutdoorWorkoutInfo")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The outdoor workout location info is successfully added!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function delete_workout_location(Request $request,$id)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Delete Workout Location','theme_type' => 'admin','menu' => 'outdoor_workout');
            $workoutlocation_obj = new AdminModel();
            $status=$workoutlocation_obj->deleteWorkoutLocation($id);
            return redirect()->route("OutdoorWorkoutInfo")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The outdoor workout location info is successfully deleted!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
    public function edit_outdoor_workout_location_info(Request $request,$id)
    {
         if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Edit Outdoor Workout Information','theme_type' => 'admin','menu' => 'outdoor_workout');
            $admin_obj = new AdminModel();
            $data['OutdoorWorkout'] = $admin_obj->selectOutdoorWorkoutInfo($id);
            
            return View('admin.edit_outdoor_workout_info', $data);
        } else {
            Redirect::to('/AdminHome');
        }
    }

    public function edit_outdoor_workout_location_info_action(Request $request)
    {
        if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Outdoor Workout Information','theme_type' => 'admin','menu' => 'outdoor_workout');    
            $admin_obj = new AdminModel();
            $admin_obj->editOutdoorWorkoutInfo($request);
            return redirect()->route("OutdoorWorkoutInfo")->with('global','<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b>Alert!</b> The outdoor workout location info is successfully updated!</div>');
        } else {
            Redirect::to('/AdminHome');
        }
    }
    
     public function PayPalInfo(Request $request){
         if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Home Page','theme_type' => 'admin','menu' => 'manage_paypal');
            $show_paypal_account_info_obj = new AdminModel();
            $data['show_paypal_account'] = $show_paypal_account_info_obj->getPaypalInfo(); 
             return View('admin.manage_paypal', $data);
         }else{
             Redirect::to('/AdminHome');
         } 
     }
    
     public function AddPayPalInfo(Request $request){
         if ($request->session()->has('admin_userid')) {
            $data = array('title' => 'Add PayPal Information','theme_type' => 'admin','menu' => 'manage_paypal');    
            $admin_obj = new AdminModel();
            $admin_obj->addPayPalInfo($request);
            return redirect()->route("PayPalInfo");
         }else{
             Redirect::to('/AdminHome');
         } 
     }
}
?>
