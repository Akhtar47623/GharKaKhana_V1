<?php
namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Model\Roles;
use App\Model\Countries;
use App\Model\States;
use App\Model\Cities;
use App\Model\Helper;
use App\Model\Users;
use Toastr;
use Datatables;
use Socialite;
use Validator;
use Redirect;
use Session;
use Config;
use Auth;
use File;
use DB;

class AdminController extends Controller {
    /*
     * @Method  : showlogin
     * @Param   : N/A
     * @Use     : Show Admin login Form
     * @return  : Login View
     */

    public function showlogin() {
        $pageData = ["title" => Config::get('constants.message.login_success')];
        return view('admin.login.login', $pageData);
    }

    /*
     * @Method  : login
     * @Param   : email,password
     * @Use     : User login
     * @return  : admin View
     */

    public function login(Request $request) {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);
            $isLogin = Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));
            if ($isLogin) {
                $getAuthUser = auth('admin')->user();
                Session::put('admin_id', $getAuthUser->id);
				if($getAuthUser->first_name != ''){
					Session::put('admin_name', $getAuthUser->first_name . ' ' . $getAuthUser->last_name);
				} else {
					Session::put('admin_name', $getAuthUser->display_name);
				}
                Session::put('role', $getAuthUser->role);
                Session::put('admin_profile', asset('public/backend/images/users/' . $getAuthUser->profile));
                return Redirect::route('dashboard')->with('flash_message_success', Config::get('constants.message.login_success'));
            }
            return Redirect::back()->withInput($request->only('email', 'remember'))->with('flash_message_error', Config::get('constants.message.login_fail'));
        } catch (\Illuminate\Database\QueryException $ex) {
            return Redirect::back()->withInput($request->only('email', 'remember'))->with('flash_message_error', $ex->getMessage());
        }
    }

    /*
     * @Method  : logout
     * @Param   : N/A
     * @Use     : User logout
     * @return  : admin View
     */

    public function logout(Request $request) {
        try {
            auth('admin')->logout();
            Session::flush(); // flush all the session
            return Redirect::route('admin')->with('flash_message_success', Config::get('constants.message.logout'));
        } catch (\Illuminate\Database\QueryException $ex) {
            return Redirect::back()->withInput($request->only('email', 'remember'))->with('flash_message_error', $ex->getMessage());
        }
    }
    public function ShowForgotPassword()
    {
        return view('admin.forgot-password.forgot-password');
    }
    public function forgotpassword(Request $request)
    {
        DB::beginTransaction(); // Begin Transaction
        Helper::myLog('Members Forgot Password : start');
        try {
            
            request()->validate([
                'email' => 'required|email',
            ]);
            $email = $request->email;

            $chekEmailExists = Admin::where('email', $email)->first();
            
            if (!empty($chekEmailExists)) {
                $remember_token=Admin::select('remember_token')->where('email', $email)->first();

                $insertData['display_name'] = $chekEmailExists->first_name . ' ' . $chekEmailExists->last_name;

                $insertData['btn_url'] = url('/admin/reset/password/' . $remember_token->remember_token);
               
                Helper::sendMailAdmin($insertData, 'admin.forgot-password.new-password', 'Forgot Password', $email);
                
                Helper::myLog('Mail send : end');
                DB::commit(); // Commit Transaction
                Toastr::success('please check your email for a Reset Password link', 'Save');
                
                return \Response::json(['status' => 1, 'msg' => 'please check your email for a Reset Password link',
                    'redirect'=>url('admin/admin-forgot-password')]);    
            }else{
                 return \Response::json(['status' => 0, 'msg' => 'Enter Registered Valid Email Address']);
            }
        } catch (Exception $e) {
            DB::rollback(); // Rollback Transaction
            Log::error("QueryException While Create, " . $e->getMessage());
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return \Response::json(['status' => 0, 'msg' => Config::get('constants.message.oops')]);

        }
    }
    public function showResetForm($token)
    {
        return view('admin.forgot-password.reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        DB::beginTransaction();
        try {

             request()->validate([
                'password' => 'required|min:7|regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/u',
                 'password_confirmation' => 'required|same:password|min:7'
             ]);
            $token = $request->token;
            $checkToken = DB::table('users')->select(['id'])->where('remember_token', $token)->first();
            if (!empty($checkToken)) {
                $flight = Admin::find($checkToken->id);
                $flight->password = Hash::make($request->password);
                if($flight->save()){
                    DB::commit();
                    Toastr::success('Your password has been changed', 'password'); 
                    return \Response::json(['status' => 1, 'msg' => 'Your password has been changed', 'redirect' => url('/admin')]); 
                } else {
                    Toastr::error(Config::get('constants.message.oops'), 'Error');
                    return \Response::json(['status' => 1, 'msg' => 'Fail', 'redirect' => url('/admin')]);                     
                }
                               
            }else {
                DB::rollback(); // Rollback Transaction
                Log::error('This link has expired' . 'Reset password');
                return \Response::json(['status' => 0, 'msg' => 'This link has expired']);
            }
        } catch (Exception $e) {
            DB::rollback(); // Rollback Transaction
            Log::error("QueryException While Update, " . $e->getMessage());
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return \Response::json(['status' => 0, 'msg' => Config::get('constants.message.oops')]);
        }    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
      $userData = Admin::with('role')->where('id','!=',1)->get();
        $pageData = ['title' => Config::get('constants.title.user'),'userData'=>$userData];
        return view('admin.users.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Roles::where('id','!=',1)->pluck('name', 'id');
        $countries = Countries::pluck('name', 'id');
       	$pageData = [
                    "title" => Config::get('constants.title.user_add'),
                    'roles'=>$roles,
                    'countries'=>$countries
                    ];
        return view('admin.users.create', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        DB::beginTransaction();
        Helper::myLog('User store : start');
        try {
            $email = $request->email;
            $phone = $request->mobile;
            $country_id = $request->country;
            $state_id = $request->state;
            $city_id = $request->city;
            $address = $request->address;
            $zipcode = $request->zipcode;
           
            $checkEmail = Admin::where('email', $email)->count();
            $checkMobile = Admin::where('phone', $phone)->count();
            
            
            if ($checkEmail > 0) {
                Helper::myLog('User store : email is exists');
                return response()->json(['status' => 409, 'message' => 'The email address is already exists!']);
            } else if ($checkMobile > 0) {
                Helper::myLog('User store : phone is exists');
                return response()->json(['status' => 409, 'message' => 'The phone number is already exists!']);
            } else {
                
                if ($file = $request->file('profile')) {
                $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/backend/images/users/', $fileName);
                    $profile = $fileName;
                }
                
                $firstName = $request->first_name;
                $lastName = $request->last_name;
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'display_name' => $firstName . " " . $lastName,
                    'password' => Hash::make($request->password),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'full_address' => $address,
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'city_id' => $city_id,
                    'zip_code' => $zipcode,
                    'role_id' => $request->role_id,
                    'profile' => $profile
                ];
                
                Admin::create($insertData);
                DB::commit();
                Helper::myLog('User store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('User store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been saved!']);
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $userData = Admin::where('id',$id)->first();
        $roles = Roles::where('id','!=',1)->pluck('name', 'id');
        $countries = Countries::pluck('name', 'id');
        $userData->country = $userData->country_id;
        $stateList = States::select('name', 'id')->where('country_id', $userData->country_id)->orderBy('name', 'ASC')->get();
        $cityList = Cities::select('name', 'id')->where('state_id', $userData->state_id)->orderBy('name', 'ASC')->get();
        $pageData = [
                    "title" => Config::get('constants.title.user_edit'), 
                    'userData' => $userData,
                    'countries'=> $countries,
                    'stateList'=> $stateList,
                    'cityList' => $cityList,
                    'roles'=>$roles
                    ];
        return view('admin.users.edit', $pageData);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        DB::beginTransaction();
        Helper::myLog('User update : start');
        try {

            $email = $request->email;
            $phone = $request->mobile;
            $country_id = $request->country;
            $state_id = $request->state;
            $city_id = $request->city;
            $full_address = $request->address;
            $zip_code = $request->zipcode;
            
            $checkEmail = Admin::where('email', $email)->where('id', '!=', $id)->count();
            $checkMobile = Admin::where('phone', $phone)->where('id', '!=', $id)->count();
            
            if ($checkEmail > 0) {
                Helper::myLog('User update : email is exists');
                return response()->json(['status' => 409, 'message' => 'The email address is already exists!']);
            } else if ($checkMobile > 0) {
                Helper::myLog('User update : phone is exists');
                return response()->json(['status' => 409, 'message' => 'The phone number is already exists!']);
            }  else {
                $firstName = $request->first_name;
                $lastName = $request->last_name;
                $updateData = [
                    'display_name' => $firstName . " " . $lastName,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'full_address' => $full_address,
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'city_id' => $city_id,
                    'zip_code' => $zip_code,
                    'role_id' => $request->role_id,
                ];
                
                $password = $request->password;
                if ($password) {
                    $updateData['password'] = Hash::make($password);
                }

                if ($file = $request->file('profile')) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/backend/images/users/', $fileName);
                    $updateData['profile'] = $fileName;
                    if ($request->oldImage != 'default.png') {
                         $destinationPath = base_path() . '/public/backend/images/users/' . $request->oldImage;
                        File::delete($destinationPath); // remove oldfile
                     }
                }

                Admin::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('User update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('User update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been updated!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        DB::beginTransaction();
        Helper::myLog('State Delete : start');
        try {

            Admin::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('State Delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('State delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }

    
    /**
     * Profile.
     * @return View
     */
    public function profile() {
        
        $adminUser = Admin::find(Session::get('admin_id'));
        
        if (!empty($adminUser)) {
            $pageData = ['title' => Config::get('constants.title.profile'), 'adminuser' => $adminUser];
            return view('admin.users.profile', $pageData);
        }
        return Redirect::back();
    }

    /**
     * profileUpdate.
     * @return View
     */
    public function profileUpdate(Request $request) {
        try {
            $id = Session::get('admin_id');

            if ($request->type == 'basicInfo') {
                $validator = Validator::make($request->all(), ['email' => 'required|unique:users,email,' . $id, 'first_name' => 'required','last_name' => 'required']);
                if ($validator->fails()) {
                    return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => implode(",", $validator->messages()->all())], 200);
                } else {
                    $adminInfo = Admin::find($id);
                    $adminInfo->first_name = $request->first_name;
                    $adminInfo->last_name = $request->last_name;
                    $adminInfo->display_name = $request->first_name . ' ' .$request->last_name;
                    $adminInfo->email = $request->email;
                    $adminInfo->phone = $request->phone;
                    $fileName = 'default.png';
                    if ($file = $request->file('profile')) {
                        $extension = $file->getClientOriginalExtension();  //get extension
                        $fileName = rand(11111, 99999) . '.' . $extension;
                        $file->move(base_path() . '/public/backend/images/users/', $fileName);
                        $adminInfo->profile = $fileName;
                        if ($request->oldimage != "default.png") {
                            @unlink(base_path('/public/backend/images/users/' . $request->oldimage));
                        }
                    }
                    
                    if ($adminInfo->save()) {
                        Session::forget('name');
                        Session::forget('profile');
                        Session::put('name', $request->first_name . ' ' . $request->last_name);
                        Session::put('profile', asset('public/backend/images/users/' . $fileName));
                        Toastr::success(Config::get('constants.message.edit'), 'Update');
                        return Redirect::route('profile');
                    } else {
                        Toastr::error(Config::get('constants.message.add'), 'Error');
                        return Redirect::back();
                    }
                }
            }
            if ($request->type == 'passwordupdate') {
                $validator = Validator::make($request->all(), ['password' => 'required|min:6', 'password_confirm' => 'required|min:6|same:password']);
                if ($validator->fails()) {
                    return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => implode(",", $validator->messages()->all())], 200);
                } else {
                    $adminInfo = Admin::find($id);
                    $adminInfo->password = Hash::make($request->password);
                    if ($adminInfo->save()) {
                        return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.edit')], 200);
                    } else {
                        return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')], 200);
                    }
                }
            }
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);
        }
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function map() {
		return view('admin.users.map', []);
    }
    public function getStateList(Request $request)
    {
            if($request->country_id=='142')
            {
                 $state = States::where("id",2437)->pluck("name","id");
            }
            else
            {
                  $state = States::where("country_id",$request->country_id)->pluck("name","id");
            }
            return response()->json($state);
    }
    public function getCityList(Request $request)
    {
        
            $city = Cities::where("state_id",$request->state_id)->pluck("name","id");
            return response()->json($city);
    }
    public function chefList()
    {
        $chefList=Users::where('type','chef')->get();
        $pageData = ['title' => Config::get('constants.title.chef'),'chefList'=>$chefList];
        return view('admin.users.chef-list', $pageData);
       
    }
    public function changeVerifyStatus(Request $request){
        try {
            
            $chefverify = Users::find($request->id);

            $chefverify->status = $request->status;
            $status=$chefverify->save();            
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_status_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }

  
}
