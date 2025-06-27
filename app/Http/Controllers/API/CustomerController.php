<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use App\Model\CountryLocation;
use App\Model\Users;
use App\Model\Roles;
use App\Model\Countries;
use App\Model\Menu;
use App\Model\Options;
use App\Model\States;
use App\Model\Cities;
use App\Model\Cuisine;
use App\Model\Tax;
use App\Model\Business;
use App\Model\Banking;
use App\Model\ChefGelleryImage;
use App\Model\ChefProfileVideo;
use App\Model\ChefCertificate;
use App\Model\CustLocation;
use App\Model\ReviewRating;
use App\Model\Categories;
use App\Model\Order;
use App\Model\Message;
use App\Model\Ticket;
use App\Model\TicketMessage;
use App\Model\TicketCategory;
use App\Model\ContactUs;
use App\Model\Taxes;
use Config; 
use Auth;
use DB;
use File;
use App\Model\Helper;
class CustomerController extends ApiController {

    private $token;

    public function __construct() {
        // Unique Token
        $this->token = uniqid(base64_encode(str_random(30)));
    }

    public function countryList()
    {
        try {
            $countryList = Countries::where('id', 142)->get();
                
                                 
            return $this->jsonResponse(['status' => 1, 'msg' => 'Country List','data'=>$countryList]);
        } catch (\Illuminate\Database\QueryException $ex) {
             return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
            
        }
    }

    //Customer Sign up
    public function signUp(Request $request) {
        try {
            if($request->method() == 'GET'){
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.'], 400);
            }

            $validArray = [
                'first_name' => 'required|regex:/^[a-zA-Z ]+$/u',
                'last_name' => 'required|regex:/^[a-zA-Z ]+$/u',
                'mobile' => 'required|min:11|numeric',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:7|regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/u',
                'confirm_password' => 'required|same:password|min:7',
                'country_id'=> 'required',
                'profile'=> 'mimes:jpeg,jpg,png,gif,JPEG,JPG,PNG,GIF|required',
                'device_token'=>'required',
                'device_type'=>'required',
                'login_type'=>'required|min:1|numeric'
            ]; 
            
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) {                
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            } 
            else 
            {
                $password = $request->post('password');
                $email = $request->post('email');
                $mobile = $request->post('mobile');
               
                if ($file = $request->file('profile')) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/frontend/images/users/', $fileName);
                    $profile = $fileName;
                }
                $memberArray = [
                    'uuid' => Helper::getUuid(),
                    'type'=>'Customer',
                    'first_name'=> $request->post('first_name',null),
                    'last_name'=> $request->post('last_name',null),
                    'display_name'=> $request->post('first_name',null).' '.$request->post('last_name',null),
                    'mobile'=> $request->post('mobile',null),
                    'email'=> $email,
                    'password'=> ($password != null) ? bcrypt($password) : '',
                    'country_id'=> $request->post('country_id',null),
                    'profile' => $profile,
                    'device_type'=>$request->post('device_type',null),
                    'device_token'=>$request->post('device_token',null)
                ];

                if($request->post('provider') && $request->post('provider_id')){
                    $memberArray['provider']=$request->post('provider',null);
                    $memberArray['provider_id']= $request->post('provider_id','ANDROID');                   
                }
                
                $checkEmail = Users::where('email', $email)->count();
                $checkMobile = Users::where('mobile', $mobile)->count();
                
               
                if($checkEmail > 0){
                    return $this->jsonResponse(['status' => 0, 'msg' => 'This email is already exists.']);
                } 
                else if($checkMobile>0){
                    return $this->jsonResponse(['status' => 0, 'msg' => 'This mobile number is already exists.']);
                }
                else{
                    $createNewMembers = Users::create($memberArray);
                    if($createNewMembers){
                        $memberInfo = Users::where('email',$email)->first();
                        return $this->jsonResponse(['status' => 1, 'msg' => 'You are successfully registered.','data'=>$memberInfo]);
                    }
                } 
                return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.']);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }  
    }
    
    //Customer Login
    public function login(Request $request) {
        try {
            if($request->method() == 'GET'){
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.']);
            }
            $validArray = [
                'email' => 'required|string',
                'password' => 'required|string|min:6',
                'device_type' => 'required',
                'device_token' => 'required']; 
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()),'error_log' => "Request parameter missing."], 400);
            } else {
                $userInfo = Users::where('email', $request->email)->first();
                if ($userInfo && Hash::check($request->password, $userInfo->password)) {
                    $token = $this->token;
                    $updateArray['token'] = $token;
                    $updateArray['device_type'] = $request->device_type;
                    $updateArray['device_token'] = $request->device_token;
                        // update customer infor and create new token
                    Users::where('email', $request->email)->update($updateArray); 
                    $setResponse = $userInfo->toArray();
                    $setResponse['profile']=url('/public/frontend/images/users/'.$setResponse['profile']);
                    $setResponse['token'] = $token;

                    return $this->jsonResponse(['status' => 1, 'msg' => "You are successfully login",'data'=>$setResponse]);
                } 
                else {
                    return $this->jsonResponse(['status' => 0, 'msg' => "Invalid email or password."]);
                }                 
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }  
    }

    //Set Customer Location
    public function customerLocation(Request $request){
        try {
            if($request->method() == 'GET'){
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.']);
            }
            $validArray = [
                'user_uuid' => 'required|string',
                'lat' => 'required|string',
                'log' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'address' => 'required|string',
            ];  
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()),'error_log' => "Request parameter missing."], 400);
            } else {
                $createdUser = Users::where('uuid',$request->user_uuid)->first();
                
                $insertData = [                    
                    'cust_id'=> $createdUser->id,
                    'lat' => $request->lat,
                    'log' => $request->log,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'address' => $request->address,                                                          
                ];
                CustLocation::create($insertData);
                $country = Countries::select('id')->where('name',$request->country)->first();
                $updateData = [
                    'country_id' => $country->id,
                ];
                Users::where('id', $createdUser->id)->update($updateData);
                return $this->jsonResponse(['status' => 1, 'msg' => "Thank you for filling out your location"]);                 
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }
    }

     // Get Profile Data
    public function getProfile(Request $request){
        try {

            if($request->method() == 'POST'){
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.']);
            }
           
            $custProfile = Users::with('location')->where('uuid',$request->user_uuid)->first();
            if(!empty($custProfile)){
                $custProfile['profile']=url('/public/frontend/images/users/'.$custProfile['profile']);
                return $this->jsonResponse(['status' => 1, 'msg' => "Profile Data",'data'=>$custProfile]); 
            }else{
                return $this->jsonResponse(['status' => 0, 'msg' => 'Enter valid uuid']);
            }                
           
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }
      
    }

    // Update Customer Basic Information
    public function updateProfile(Request $request){
        try {
            if($request->method() == 'GET'){
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.']);
            }
            $validArray = [
                'user_uuid' => 'required|string',
                'first_name' => 'required|regex:/^[a-zA-Z ]+$/u',
                'last_name' => 'required|regex:/^[a-zA-Z ]+$/u',
                'mobile' => 'required|min:11|numeric',
                'profile'=> 'mimes:jpeg,jpg,png,gif,JPEG,JPG,PNG,GIF|required',
               
            ];   
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()),'error_log' => "Request parameter missing."], 400);
            } else {

                $updateData = [
                    'first_name'=> $request->post('first_name',null),
                    'last_name'=> $request->post('last_name',null),
                    'display_name'=> $request->post('first_name',null).' '.$request->post('last_name',null),
                    'mobile'=> $request->post('mobile',null)                
                ];

                $oldImage = Users::select('profile')->where('uuid', $request->user_uuid)->first();

                if ($file = $request->file('profile')) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/frontend/images/users/', $fileName);
                    $updateData['profile'] = $fileName;
                    if ($oldImage->profile) {
                        $destinationPath = base_path() . '/public/frontend/images/users/' . $oldImage->profile;
                        File::delete($destinationPath); 
                    }
                }
                $user=Users::where('uuid', $request->user_uuid)->update($updateData);
                if($user){
                        $updateInfo = Users::where('uuid',$request->user_uuid)->first();
                        $updateInfo['profile']=url('/public/frontend/images/users/'.$updateInfo['profile']);
                        return $this->jsonResponse(['status' => 1, 'msg' => "Profile Sucessfully Updated",'data'=>$updateInfo]);
                    }
                
                return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.']);                 
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }
        
    }

    //Update Password
    public function updatePassword(Request $request){
        try {
            if($request->method() == 'GET'){
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.']);
            }
            $validArray = [
                'user_uuid' => 'required|string',
                'new_password' => 'required|min:7|regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/u',
                'confirm_new_password' => 'required|same:new_password|min:7'                            
            ];   
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()),'error_log' => "Request parameter missing."], 400);
            } else {
                $updateData = ['password' => Hash::make($request->new_password)];                     
                $user=Users::where('uuid', $request->user_uuid)->update($updateData); 
                if($user){
                    return $this->jsonResponse(['status' => 1, 'msg' => "Password Sucessfully Updated"]);
                }else{
                    return $this->jsonResponse(['status' => 0, 'msg' => 'Password is not updated. Oops Something went wrong please try again']); 
                }               
            }      
           
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }        
    }

    //Update Location
    public function updateLocation(Request $request){
        try {
            if($request->method() == 'GET'){
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.']);
            }
            $validArray = [
                'cust_id' => 'required|string',
                'lat' => 'required|string',
                'log' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'address' => 'required|string',
            ];  
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()),'error_log' => "Request parameter missing."], 400);
            } else {
                               
                $updateData = [                    
                    'lat' => $request->lat,
                    'log' => $request->log,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'address' => $request->address,                                                          
                ];
                $locUpt=CustLocation::where('cust_id',$request->cust_id)->update($updateData);
                $country = Countries::select('id')->where('name',$request->country)->first();
                if(!empty($country)){
                    $updateData = [
                        'country_id' => $country->id,
                    ];
                    
                }
                $usrUpt=Users::where('id', $request->cust_id)->update($updateData);
                if($locUpt && $usrUpt){
                    return $this->jsonResponse(['status' => 1, 'msg' => "Location successfully updated"]); 
                }else{
                     return $this->jsonResponse(['status' => 0, 'msg' => "Location not updated.. something went wrong please try again"]);
                }
                                
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }
    }

}


