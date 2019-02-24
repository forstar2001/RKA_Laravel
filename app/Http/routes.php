<?php
/*
|------------------------
| Admin Routes
|------------------------
*/

Route::get('/Admin/Login', 'AdminController@Login')->name('Admin');
Route::post('/AdminLoginAccess', 'AdminController@LoginAccess')->name('AdminLoginAccess');
Route::get('/AdminHome','AdminController@AdminHome')->name('AdminHome');
Route::get('/Admin/GroupWorkoutInfo','AdminController@GroupWorkoutInfoAndLocation')->name('GroupWorkoutInfo');
Route::get('/Admin/AddGroupWorkoutInfo','AdminController@AddGroupWorkoutInfoAndLocation')->name('AddGroupWorkoutInfo');
Route::post('/Admin/AddGroupWorkoutInfoAction','AdminController@AddGroupWorkoutInfoAction');
Route::get('/Admin/EditGroupWorkoutInfo/{id}', 'AdminController@EditGroupWorkoutInfo')->name('EditGroupWorkoutInfo');
Route::post('/Admin/EditGroupWorkoutInfoAction','AdminController@EditGroupWorkoutInfoAction');
Route::get('/Admin/DeleteGroupWorkoutInfo/{id}', 'AdminController@DeleteGroupWorkoutInfo')->name('DeleteGroupWorkoutInfo');
Route::get('/Admin/GymMembership','AdminController@GymMembership')->name('GymMembership');
Route::get('/Admin/AddGymMembership','AdminController@AddGymMembership')->name('AddGymMembership');
Route::post('/Admin/AddGymMembershipAction','AdminController@AddGymMembershipAction');
Route::get('/Admin/EditGymMembership/{id}', 'AdminController@EditGymMembership')->name('EditGymMembership');
Route::post('/Admin/EditGymMembershipAction','AdminController@EditGymMembershipAction');
Route::get('/Admin/DeleteGymMembership/{id}', 'AdminController@DeleteGymMembership')->name('DeleteGroupWorkoutInfo');
Route::get('/Admin/ScheduledRacesInfo', 'AdminController@ScheduledRacesInfo')->name('ScheduledRacesInfo');
Route::get('/Admin/AddScheduledRacesInfo','AdminController@AddScheduledRacesInfo')->name('AddScheduledRacesInfo');
Route::post('/Admin/AddScheduledRacesInfoAction','AdminController@AddScheduledRacesInfoAction');
Route::get('/Admin/EditScheduledRacesInfo/{id}', 'AdminController@EditScheduledRacesInfo')->name('EditScheduledRacesInfo');
Route::post('/Admin/EditScheduledRacesInfoAction','AdminController@EditScheduledRacesInfoAction');
Route::get('/Admin/DeleteScheduledRacesInfo/{id}', 'AdminController@DeleteScheduledRacesInfo')->name('DeleteScheduledRacesInfo');
Route::get('/Admin/PayPalInfo', 'AdminController@PayPalInfo')->name('PayPalInfo');
Route::post('/Admin/AddPayPalInfo', 'AdminController@AddPayPalInfo')->name('AddPayPalInfo');
Route::get('/Admin/Logout','AdminController@Logout')->name('Adminlogout');
Route::get('/Admin/EditUser/{id}/{tab_id}', 'AdminController@EditUser')->name('EditUser');
Route::post('/Admin/EditUserBasic', 'AdminController@EditUserBasic');
Route::post('/Admin/EditUserFitness', 'AdminController@EditUserFitness');
Route::post('/Admin/EditUserPersonal', 'AdminController@EditUserPersonal');
Route::get('/Admin/DeleteUser/{id}', 'AdminController@DeleteUser');
Route::post('/Admin/EditUserPhotos', 'AdminController@EditUserPhotos');
Route::get('/Admin/DeleteUserPhoto/{photo_id}/{user_id}', 'AdminController@DeleteUserPhoto');
Route::get('/Admin/SetPrimaryUserLocation/{loc_id}/{user_id}', 'AdminController@SetPrimaryUserLocation');
Route::get('/Admin/DeleteUserLocation/{loc_id}/{user_id}', 'AdminController@DeleteUserLocation');
Route::post('/Admin/EditUserLocation', 'AdminController@EditUserLocation');
Route::post('/Admin/EditUserDescription', 'AdminController@EditUserDescription');
Route::get('/Admin/OutdooorInfo', 'AdminController@show_outdoor_workout_location_info')->name('OutdoorWorkoutInfo');
Route::get('/Admin/AddOutdoorInfo', 'AdminController@add_outdoor_workout_location_info')->name('AddOutdoorWorkoutInfo');
Route::post('/Admin/AddOutdoorInfoAction', 'AdminController@add_outdoor_workout_location_info_action')->name('AddOutdoorWorkoutInfoAction');
Route::get('/Admin/DeleteWorkoutLocation/{id}', 'AdminController@delete_workout_location');
Route::get('Admin/EditWorkoutLocation/{id}', 'AdminController@edit_outdoor_workout_location_info')->name('EditOutdoorWorkoutInfoAction');
Route::get('/Admin/EditOutdoorInfo/{id}', 'AdminController@edit_outdoor_workout_location_info')->name('EditOutdoorInfo');
Route::post('/Admin/EditOutdoorInfoAction','AdminController@edit_outdoor_workout_location_info_action');

/*
|------------------------
| Frontend Routes
|------------------------
*/

Route::get('/', 'HomeController@Index')->name('Home');
Route::get('/User/Login', 'HomeController@UserLogin')->name('UserLogin');
Route::get('/User/ForgotPassword', 'HomeController@ForgotPassword')->name('UserForgotPassword');
Route::post('/User/VerifyEmail', 'HomeController@VerifyEmail')->name('UserVerifyEmail');
Route::get('/User/ConfirmOtp', 'HomeController@ConfirmOtp')->name('UserConfirmOtp');
Route::post('/User/VerifyOtp', 'HomeController@VerifyOtp')->name('UserVerifyOtp');
Route::get('/User/ResetPassword', 'HomeController@ResetPassword')->name('UserResetPassword');
Route::post('/User/UpdatePassword', 'HomeController@UpdatePassword')->name('UserUpdatePassword');
Route::get('/User/Logout','HomeController@UserLogout')->name('UserLogout');
Route::get('/Join', 'HomeController@UserJoin')->name('UserJoin');
Route::post('/User/SignUpStepOne', 'HomeController@UserSignUpStepOne')->name('UserSignUpStepOne');
Route::post('/User/SignUpStepTwo', 'HomeController@UserSignUpStepTwo')->name('UserSignUpStepTwo');
Route::post('/User/SignUpStepThree', 'HomeController@UserSignUpStepThree')->name('UserSignUpStepThree');
Route::post('/User/SignUpStepFour', 'HomeController@UserSignUpStepFour')->name('UserSignUpStepFour');
Route::post('/User/Add', 'HomeController@UserAdd')->name('UserAdd');
Route::post('/User/LoginAccess', 'HomeController@UserLoginAccess')->name('UserLoginAccess');
Route::get('/User/Dashboard', 'HomeController@UserDashboard')->name('UserDashboard');
Route::get('/User/BasicProfile', 'HomeController@UserBasicProfile')->name('UserBasicProfile');
Route::get('/User/Settings', 'HomeController@UserSettings')->name('UserSettings');
Route::post('/User/MatchPassword', 'HomeController@MatchPassword')->name('MatchPassword');
Route::post('/User/UpdateOldPassword', 'HomeController@UpdateOldPassword')->name('UpdateOldPassword');
Route::post('/User/UpdateAccountSettings', 'HomeController@UpdateAccountSettings')->name('UserUpdateAccountSettings');
Route::post('/User/UpdateBasicProfile', 'HomeController@UserUpdateBasicProfile')->name('UserUpdateBasicProfile');
Route::get('/User/FitnessInfo', 'HomeController@UserFitnessInfo')->name('UserFitnessInfo');
Route::post('/User/UpdateFitnessInfo', 'HomeController@UpdateFitnessInfo')->name('UserUpdateFitnessInfo');
Route::get('/User/PersonalInfo', 'HomeController@UserPersonalInfo')->name('UserPersonalInfo');
Route::post('/User/UpdatePersonalInfo', 'HomeController@UpdatePersonalInfo')->name('UserUpdatePersonalInfo');
Route::get('/User/Photos', 'HomeController@UserPhotos')->name('UserPhotos');
Route::get('/User/LocationInfo/{flag?}', 'HomeController@UserLocationInfo')->name('UserLocationInfo');
Route::post('/User/AddLocation', 'HomeController@AddLocation')->name('UserAddLocation');
Route::post('/User/EditLocation', 'HomeController@EditLocation')->name('UserEditLocation');
Route::get('/User/DeleteLocation/{loc_id}', 'HomeController@DeleteLocation');
Route::get('/User/SetPrimaryUserLocation/{loc_id}/{user_id}', 'HomeController@SetPrimaryUserLocation');
Route::get('/User/Description', 'HomeController@UserDescription')->name('UserDescription');
Route::post('/User/UpdateUserDescription', 'HomeController@UpdateUserDescription')->name('UserUpdateUserDescription');
Route::post('/User/UploadPhotos', 'HomeController@UserUploadPhotos')->name('UserUploadPhotos');
Route::get('/User/DeletePhotos/{photo_id}/{user_id}', 'HomeController@UserDeletePhotos')->name('UserDeletePhotos');
Route::post('/User/UploadPrivatePhotos', 'HomeController@UserUploadPrivatePhotos')->name('UploadPrivatePhotos');
Route::post('/User/UploadProfilePhotos', 'HomeController@UserUploadProfilePhotos')->name('UploadProfilePhotos');
Route::post('/User/TrainerSearch', 'HomeController@UserTrainerSearch')->name('UserTrainerSearch');
Route::get('/User/TrainerProfile/{user_id}', 'HomeController@UserTrainerProfile')->name('UserTrainerProfile');
Route::get('/User/Favorites', 'HomeController@UserFavorites')->name('UserFavorites');
Route::get('/User/ViewedMe', 'HomeController@UserViewedMe')->name('UserViewedMe');
Route::get('/User/FavoritedMe', 'HomeController@UserFavoritedMe')->name('UserFavoritedMe');
// Route::get('/User/PayWithCreditCard', 'HomeController@UserPayWithCreditCard')->name('UserPayWithCreditCard');
Route::get('/User/PayWithPayPal', 'HomeController@UserPayWithPaypal')->name('UserPayWithPaypal');
Route::post('/User/AddFavorite', 'HomeController@UserAddFavorite')->name('UserAddFavorite');
Route::post('/User/SearchFilter', 'HomeController@UserSearchFilter')->name('UserSearchFilter');
Route::get('/User/PayWithCreditCard/{user_id}', 'HomeController@UserPayWithCreditCard')->name('UserPayWithCreditCard');
Route::get('/User/VerifyStatus/{user_id}', 'HomeController@UserVerifyStatus')->name('UserVerifyStatus');
Route::post('/User/CreditCardDetailsAdd/{user_id}', 'HomeController@UserCreditCardDetailsAdd')->name('UserCreditCardDetailsAdd');
Route::post('/User/UpdateCurrentLocation', 'HomeController@UserUpdateCurrentLocation')->name('UserUpdateCurrentLocation');


/*
|------------------------
| Api Routes
|------------------------
*/

Route::post('/Api/Authenticate', 'ApiController@Authenticate')->name("ApiAuthenticate");
Route::post('/Api/UserLoginFB', 'ApiController@UserLoginFB')->name("ApiUserLoginFB");
Route::post('/Api/UserJoin', 'ApiController@UserJoin')->name("ApiUserJoin");
Route::get('/Api/AthleteType', 'ApiController@AthleteType')->name("ApiAthleteType");
Route::get('/Api/SignUpStepTwo', 'ApiController@SignUpStepTwo')->name('ApiSignUpStepTwo');
Route::get('/Api/UserProfiles', 'ApiController@UserProfiles')->name("ApiUserProfiles");
Route::get('/Api/GetGenderTypes', 'ApiController@GetGenderTypes')->name("ApiGetGenderTypes");
Route::get('/Api/SignUpStepFour', 'ApiController@SignUpStepFour')->name('ApiSignUpStepFour');
Route::get('/Api/GetRateExpectations', 'ApiController@GetRateExpectations')->name("ApiGetRateExpectations");
Route::get('/Api/GetFitnessLevel', 'ApiController@GetFitnessLevel')->name("ApiGetFitnessLevel");
Route::get('/Api/GetSwimTime', 'ApiController@GetSwimTime')->name("ApiGetSwimTime");
Route::get('/Api/GetBikeSpeedMph', 'ApiController@GetBikeSpeedMph')->name("ApiGetBikeSpeedMph");
Route::get('/Api/GetRunTimeMile', 'ApiController@GetRunTimeMile')->name("ApiGetRunTimeMile");
Route::get('/Api/GetHeight', 'ApiController@GetHeight')->name("ApiGetHeight");
Route::get('/Api/GetBodyType', 'ApiController@GetBodyType')->name("ApiGetBodyType");
Route::get('/Api/GetEthnicity', 'ApiController@GetEthnicity')->name("ApiGetEthnicity");
Route::get('/Api/GetQualification', 'ApiController@GetQualification')->name("ApiGetQualification");
Route::get('/Api/GetRelationshipStatus', 'ApiController@GetRelationshipStatus')->name("ApiGetRelationshipStatus");
Route::get('/Api/GetChildrenNumber', 'ApiController@GetChildrenNumber')->name("ApiGetChildrenNumber");
Route::get('/Api/GetSmokerType', 'ApiController@GetSmokerType')->name("ApiGetSmokerType");
Route::get('/Api/GetDrinkerType', 'ApiController@GetDrinkerType')->name("ApiGetDrinkerType");
Route::get('/Api/GetLanguages', 'ApiController@GetLanguages')->name("ApiGetLanguages");
Route::get('/Api/GetFitnessBudget', 'ApiController@GetFitnessBudget')->name("ApiGetFitnessBudget");
Route::get('/Api/GetAllowanceExpectations', 'ApiController@GetAllowanceExpectations')->name("ApiGetAllowanceExpectations");
Route::get('/Api/GroupWorkoutInfoAndLocations', 'ApiController@GroupWorkoutInfoAndLocations')->name("ApiGroupWorkoutInfoAndLocations");
Route::get('/Api/GymMembershipInfo', 'ApiController@GymMembershipInfo')->name("ApiGymMembershipInfo");
Route::get('/Api/GymOutdoorWorkOutLocations', 'ApiController@GymOutdoorWorkOutLocations')->name("ApiGymOutdoorWorkOutLocations");
Route::get('/Api/ScheduledRaces', 'ApiController@ScheduledRaces')->name("ApiScheduledRaces");
Route::get('/Api/GetLookingForTags', 'ApiController@GetLookingForTags')->name("ApiGetLookingForTags");
Route::post("/Api/EmailCheck", 'ApiController@EmailCheck')->name('EmailCheck');
Route::post("/Api/OtpCheck", 'ApiController@OtpCheck')->name('OtpCheck');
Route::post("/Api/EnterNewPassword", 'ApiController@EnterNewPassword')->name('EnterNewPassword');
Route::get("/Api/GetCountryList", 'ApiController@GetCountryList')->name('ApiGetCountryList');

Route::group(['middleware' => 'jwt-auth', 'prefix' => 'Api'], function () {
    
Route::get('GetUserBasicInfo', 'ApiController@GetUserBasicInfo')->name("ApiGetUserBasicInfo");
Route::post('EditUserBasicInfo', 'ApiController@EditUserBasicInfo')->name("ApiEditUserBasicInfo");
Route::post('UpdateBasicInfoProfilePicture', 'ApiController@UpdateBasicInfoProfilePicture')->name("ApiUpdateBasicInfoProfilePicture");
Route::get('GetUserFitnessInfo', 'ApiController@GetUserFitnessInfo')->name("ApiGetUserFitnessInfo");
Route::post('AddUserFitnessInfo', 'ApiController@AddUserFitnessInfo')->name("ApiAddUserFitnessInfo");
Route::post('EditUserFitnessInfo', 'ApiController@EditUserFitnessInfo')->name("ApiEditUserFitnessInfo");
Route::get('GetUserPersonalInfo', 'ApiController@GetUserPersonalInfo')->name("ApiGetUserPersonalInfo");
Route::post('AddUserPersonalInfo', 'ApiController@AddUserPersonalInfo')->name("ApiAddUserPersonalInfo");
Route::post('EditUserPersonalInfo', 'ApiController@EditUserPersonalInfo')->name("ApiEditUserPersonalInfo");
Route::get('GetUserLocationInfo', 'ApiController@GetUserLocationInfo')->name("ApiGetUserLocationInfo");
Route::post('AddUserLocationInfo', 'ApiController@AddUserLocationInfo')->name("ApiAddUserLocationInfo");
Route::post('EditUserLocationInfo', 'ApiController@EditUserLocationInfo')->name("ApiEditUserLocationInfo");
Route::post('SetPrimaryUserLocation', 'ApiController@SetPrimaryUserLocation')->name("ApiSetPrimaryUserLocation");
Route::post('DeleteUserLocationInfo', 'ApiController@DeleteUserLocationInfo')->name("ApiDeleteUserLocationInfo");
Route::post('UpdateUserDescription', 'ApiController@UpdateUserDescription')->name("ApiUpdateUserDescription");
Route::get('GetUserPhotos', 'ApiController@GetUserPhotos')->name("ApiGetUserPhotos");
Route::post('AddUserPhotos', 'ApiController@AddUserPhotos')->name("ApiAddUserPhotos");
Route::post('DeleteUserPhotos', 'ApiController@DeleteUserPhotos')->name("ApiDeleteUserPhotos");
Route::post('UserDashboard', 'ApiController@UserDashboard')->name("ApiUserDashboard");
Route::post('UserSearchTrainer', 'ApiController@UserSearchTrainer')->name("ApiUserSearchTrainer");
Route::post('UserTrainerProfile', 'ApiController@UserTrainerProfile')->name("ApiUserTrainerProfile");
Route::get('GetUserDescription', 'ApiController@GetUserDescription')->name("ApiGetUserDescription");
Route::post('ChangePassword', 'ApiController@ChangePassword')->name('ApiChangePassword');
Route::get('GetProfileCompleteStatus', 'ApiController@GetProfileCompleteStatus')->name("ApiGetProfileCompleteStatus");
Route::get('GetMyFavorites', 'ApiController@GetMyFavorites')->name('ApiGetMyFavorites');
Route::get('GetFavoritedMe', 'ApiController@GetFavoritedMe')->name('ApiGetFavoritedMe');
Route::post('AddFavorite', 'ApiController@AddFavorite')->name('ApiAddFavorite');
Route::get('GetViewedMe', 'ApiController@GetViewedMe')->name('ApiGetViewedMe');
Route::post('GetHireMeDetails', 'ApiController@GetHireMeDetails')->name('ApiGetHireMeDetails');

Route::post("AddCard", 'ApiController@AddCard')->name('ApiAddCard');
Route::get("ViewCardList", 'ApiController@ViewCardList')->name('ApiViewCardList');
Route::post("DeleteCard", 'ApiController@DeleteCard')->name('ApiDeleteCard');
Route::post("PaymentUsingCard", 'ApiController@PaymentUsingCard')->name('ApiPaymentUsingCard');
Route::post("PaymentUsingPaypal", 'ApiController@PaymentUsingPaypal')->name('ApiPaymentUsingPaypal');
Route::post("AdvanceSearch", 'ApiController@AdvanceSearch')->name('ApiAdvanceSearch');

});
?>


