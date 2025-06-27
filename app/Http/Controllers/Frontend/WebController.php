<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use App\Model\Roles;
use App\Model\Countries;
use App\Model\Menu;
use App\Model\Options;
use App\Model\States;
use App\Model\Cities;
use App\Model\Helper;
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
use App\Model\CountryLocation;
use App\Model\ContactUs;
use App\Model\Taxes;
use Toastr;
use Datatables;
use Socialite;
Use \Carbon\Carbon;
use Validator,Redirect,Session,Config;
use Auth,File,DB,Location;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class WebController extends Controller
{
    public function setCookie(Request $request)
    {
        return response('success')->cookie('accept-cookie', true, config('constants.COOKIE_ACCEPT_LIFETIME'));
    }
    public function index(Request $request) {
        if(Cookie::get('location')){

            if(!empty(Helper::getLocCity())){
                $city = Helper::getLocCity();

                $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];

                $chefData = Users::with('ratings','chefLocation','chefBussiness')
                        ->with(['chefMenu'=>function($query){
                            $query->orderByRaw('RAND()')->take(3);
                        }])
                        ->whereHas('chefLocation', function($chefLocation) use ($city) {
                            $chefLocation->where('city_id','=',31594);
                        })
                        ->whereHas('chefMenu')
                        ->whereHas('chefBussiness')
                        ->select('users.id','users.uuid','users.display_name','users.profile','users.profile_id','users.country_id')
                        ->where($whereClouser)
                        ->paginate(6);

                foreach ($chefData as $menu) {
                    $chefLoc =$menu->chefLocation->address;
                    $custLoc = Helper::getLocation();
                    $miles = Helper::geoLocationDistance($chefLoc,$custLoc);
                    $menu['distance']=$miles;

                }

                $cuisines = Cuisine::select('id','name')->where('status','A')->get();

                $countryId = Helper::getLocCountry();
                $currency = Countries::where('id',$countryId)->first();
                // if(!Session::has('locale') && !Session::has('country_id')){
                //      Session::put('locale', 'en');
                //     Session::put('country_id',$countryId);
                // }
                $categories = Categories::where('country_id',$countryId)->inRandomOrder()->limit(6)
                            ->get();
                $topChef = Users::with('ratings','chefLocation','chefBussiness')
                        ->whereHas('chefLocation', function($chefLocation) use ($city) {
                            $chefLocation->where('city_id','=',$city);
                        })
                        ->whereHas('chefBussiness')
                        ->select('users.id','users.uuid','users.display_name','users.profile','users.profile_id')
                        ->where($whereClouser)
                        ->inRandomOrder()
                        ->first();

                $taxes = Taxes::select('service_fee_per','tax')->where('state_id',Helper::getLocState())->where('city_id',Helper::getLocCity())->first();

                $currency=[];
                if($countryId){
                    $currency = Countries::where('id',$countryId)->first();
                }
                if(!$chefData->isEmpty()){

                    $pageData = ['cuisines'=>$cuisines,'chefData'=>$chefData,
                    'currency'=>$currency,'categories'=>$categories,'topChef'=>$topChef,
                    'countryId'=>$countryId,'taxes'=>$taxes,'currency'=>$currency];
                    if(auth('front')->check() && auth('front')->user()->type == "Customer"){

                        $review=ReviewRating::with('user')->where('cust_id',auth('front')->user()->id)
                        ->where('status','0')
                        ->where('created_at','>=',Carbon::now()->subdays(15))
                        ->first();
                        $pageData['review']=$review;
                    }
                    $countryName=CountryLocation::with('country')->select('country_id')->get();
                    $pageData['countryName']=$countryName;
                    return view('frontend.home.index',$pageData);
                }else{
                    return view('frontend.home.not-available');
                }
            }else{
                return view('frontend.home.not-available');

            }

        }else{
            $countryName=CountryLocation::with('country')->select('country_id')->get();
            $pageData = ['countryName'=>$countryName];
            return view('frontend.home.landing',$pageData);

        }
    }
    public function mexicoMoreInfo(Request $request){
        $countryId = Helper::getLocCountry();
        if($countryId=='142'){
            return view('frontend.registration.mexico-more-info');
        }
    }
    public function mexicoFeePolicy(){
        return view('frontend.policy.mexico-fee-policy');
    }
    public function allCategory(Request $request){
        $countryId = Helper::getLocCountry();
        $categories = Categories::where('country_id',$countryId)->orderBy('name', 'ASC')->get();
        $pageData['categories']=$categories;
        return view('frontend.home.category',$pageData);
    }
    public function saveCustomerRegistration(Request $request){
    	DB::beginTransaction();
        Helper::myLog('Customer Registration Store : start');
        try {
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $mobile = $request->mobile;
            $email = $request->email;
            $country = $request->country;

            $checkEmail =Users::where('email', $email)->count();
            if ($checkEmail > 0) {
                Helper::myLog('Customer Registration store : email is exists');
                return response()->json(['status' => 409, 'message' => __('validation.email-exists')]);
            } else {
            	if ($file = $request->file('profile')) {
                	$extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/frontend/images/users/', $fileName);
                    $profile = $fileName;
                }
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'type' => 'Customer',
                    'password' => Hash::make($request->password),
                    'display_name' => $first_name . " " . $last_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'country_id' => $country,
                    'profile' => $profile,
                ];
                Users::create($insertData);
                DB::commit();
                Helper::myLog('Customer Registration store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => __('validation.save')]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Customer Registration store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
        }
    }

    public function custSignin(){
        //return redirect()->route('home');
    	return view('frontend.login.customer-login');
    }
    public function custRegistration(){
        //return redirect()->route('home');
        $countries = Countries::where('id', 142)->pluck('name', 'id');
       	$pageData = ['countries'=>$countries];
        return view('frontend.registration.customer-reg', $pageData);
    }
    public function custLogin(Request $request){
        try {
            $isLogin = Auth::guard('front')->attempt(['email' => $request->email, 'password' => $request->password]);
            if($isLogin) {
                $getAuthUser = auth('front')->user();
                if($getAuthUser->type=='Customer'){
                    Session::put('name', $getAuthUser->first_name . ' ' . $getAuthUser->last_name);
                    Session::put('userId', $getAuthUser->id);
                    Session::put('type', $getAuthUser->type);
                    Session::put('profile', asset('public/frontend/images/users/' . $getAuthUser->profile));
                        return response()->json(['status' => 200, 'message' => __('validation.lsuccess')]);
                    }else{
                    return response()->json(['status' => 401, 'message' => 'The email address or password you entered is incorrect.']);
                }
            }else{
                return response()->json(['status' => 401, 'message' => 'The email address or password you entered is incorrect.']);
            }
        } catch (\Exception $exception) {
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500,'message' =>'Oops Something went wrong please try again']);
        }
    }
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function Callback($provider){
        try {
            $user = Socialite::driver($provider)->user();
            $create['uuid'] = Helper::getUuid();
            $create['display_name'] = $user->getName();
            $create['email'] = $user->getEmail();
            $create['provider_id'] = $user->getId();
            $create['provider']= $provider;
            $create['profile']= $user->getAvatar();

            $createdUser = Users::where('provider_id',$create['provider_id'])->first();

            if($createdUser){
                Auth::guard('front')->login($createdUser);
                Session::put('userId', $createdUser->id);
                Session::put('name', $createdUser->first_name . ' ' . $createdUser->last_name);
                Session::put('type', $createdUser->type);
                Session::put('profile', $createdUser->profile);
                Toastr::success("You are successfully logged in to website", 'Success');
                $custLocData=CustLocation::where('cust_id',$createdUser->id)->first();
                if($custLocData){
                    $insertData = [
                        'lat' => $custLocData->lat,
                        'log' => $custLocData->log,
                        'country' => $custLocData->country,
                        'state' => $custLocData->state,
                        'city' => $custLocData->city,
                        'address' => $custLocData->address
                    ];
                    $minutes = 525600;
                    Cookie::queue(Cookie::make('location', serialize($insertData), $minutes));
                }
                return Redirect::route('home');
            }else{
                $newUser=Users::create($create);
                return Redirect::route('social-sign-up',$newUser->uuid);
            }
        } catch (Exception $e) {
            return redirect('/');
        }

    }
    public function socialRegistration($uuid){
        return view('frontend.registration.soc-cust-location', compact('uuid'));
    }
    public function setLoginUserCookies(){
        if(auth('front')->user()){
            $userData=auth('front')->user();
            $custLocData=CustLocation::where('cust_id',$userData->id)->first();
            if($custLocData){
                $insertData = [
                    'lat' => $custLocData->lat,
                    'log' => $custLocData->log,
                    'country' => $custLocData->country,
                    'state' => $custLocData->state,
                    'city' => $custLocData->city,
                    'address' => $custLocData->address
                ];
                $minutes = 525600;
                Cookie::queue(Cookie::make('location', serialize($insertData), $minutes));
                if ($redirect = Session::get('redirect')) {
                    Session::forget('redirect');
                    return Redirect::to($redirect);
                }else{
                    return Redirect::route('home');
                }
            }else{
                $uuid = $userData->uuid;
                return view('frontend.registration.cust-location', compact('uuid'));
            }
        }
    }
    public function saveCustomerLocation(Request $request){
        try {
            $createdUser = Users::where('uuid',$request->uuid)->first();
                $insertData = [
                    'cust_id'=> $createdUser->id,
                    'lat' => $request->lat,
                    'log' => $request->log,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'address' => $request->address,

                ];
                if(!empty($request->zipcode)){
                    $insertData['zipcode'] = $request->zipcode;
                }
                if($createdUser){
                    Auth::guard('front')->login($createdUser);
                    CustLocation::create($insertData);
                    $country = Countries::select('id')->where('name',$request->country)->first();
                    $updateData = [
                        'country_id' => $country->id,
                    ];
                    if($request->password){
                         $updateData ['password']= Hash::make($request->password);
                    }
                    Users::where('id', $createdUser->id)->update($updateData);
                    $minutes = 525600;
                    Cookie::queue(Cookie::make('location', serialize($insertData), $minutes));
                    Toastr::success("You are successfully logged in to website", 'Success');
                    return response()->json(['status' => 200, 'message' => 'Thank you for filling out your location']);
                }
                return response()->json(['status' => 401, 'message' => __('validation.loc-not-available')]);

        } catch (\Exception $exception) {
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500,'message' =>__('validation.oops')]);
        }
    }
    public function showForgotPassword()
    {
        return view('frontend.forgot-password.forgot-password');
    }
    public function forgotPassword(Request $request)
    {

        DB::beginTransaction();
        Helper::myLog('Members Forgot Password : start');
        try {
            $email = $request->email;
            $checkEmail =Users::where('email', $email)->count();
            $user = Users::where('email',$email)->first();
            if (!$checkEmail) {
                Helper::myLog('Members Forgot Password : email is not exists');
                return response()->json(['status' => 409, 'message' => __('validation.valid-email')]);
            } else {

                $token=Helper::randomString(16);
                $emailData['display_name'] = $user->first_name . ' ' . $user->last_name;
                $emailData['btn_url'] = url('/password-reset/' . $token);
                Helper::sendMailAdmin($emailData, 'frontend.forgot-password.recovery-email', 'Reset Password', $email);
                $updateData = [
                    'remember_token' => $token
                ];
                Users::where('email', $email)->update($updateData);
                DB::commit();
                Helper::myLog('Members Forgot Password : finish');
                return response()->json(['status' => 200, 'message' => __('validation.rpassword-link')]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Members Forgot Password : exception');
            Helper::myLog($exception);
            return response()->json(['status' => 500, 'message' => __('validation.oops')]);
        }
    }
    public function resetPassword($token){

        return view('frontend.forgot-password.reset-password', compact('token'));
    }

    public function saveResetPassword(Request $request){
        DB::beginTransaction();
        try {
            $token = $request->token;
            $checkToken = DB::table('users')->select(['id'])->where('remember_token', $token)->first();
            if (!empty($checkToken)) {
                $flight = Users::find($checkToken->id);
                $flight->password = Hash::make($request->password);
                $flight->remember_token ='';
                if($flight->save()){
                    DB::commit();
                    return response()->json(['status' => 200, 'message' => __('validation.changed-password')]);
                } else {
                    return response()->json(['status' => 401, 'message' => __('validation.not-changed-password')]);
                }
            }else {
                DB::rollback();
                return response()->json(['status' => 401, 'message' => __('validation.link-expire')]);
            }
        } catch (Exception $e) {
            DB::rollback();
            Helper::myLog("QueryException While Update, " . $e->getMessage());
            return response()->json(['status' => 500, 'message' => __('validation.oops')]);
        }
    }
    public function logout(Request $request) {
        try {
            auth('front')->logout();
            if(Session::has('locale') && Session::has('country_id')){
                $oldLocal=Session::get('locale');
                $oldCountry=Session::get('country_id');
            }
            Session::flush(); // flush all the session
            if(!empty($oldLocal) && !empty($oldCountry)){
                    Session::put('locale', $oldLocal);
                    Session::put('country_id',$oldCountry);
                }
            return Redirect::route('home');
        } catch (\Illuminate\Database\QueryException $ex) {
            return Redirect::back()->withInput($request->only('email', 'remember'));
        }
    }

    public function getStateList(Request $request)
    {
            if($request->country_id=="142"){
                  $state= States::where('id',2437)->pluck("name","id");
            }else{
                 $state = States::where("country_id",$request->country_id)->pluck("name","id");
            }
            return response()->json($state);
    }
    public function getCityList(Request $request)
    {
            $city = Cities::where("state_id",$request->state_id)->pluck("name","id");
            return response()->json($city);
    }

    public function setLocation(Request $request){
        // if (request()->cookie('accept-cookie')){
            $country = $country = Countries::select('id')->where('name',$request->country)->first();
            if(!empty($request->lat) && !empty($request->log) && !empty($request->country) && !empty($request->state) && !empty($request->address) && !empty($request->city)){

                $insertData = [
                    'lat' => $request->lat,
                    'log' => $request->log,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'address' => $request->address
                ];
                $minutes = 525600;
                Cookie::queue(Cookie::make('location', serialize($insertData), $minutes));
                if($country->id=='142'){
                    Session::put('locale', 'es');
                    Session::put('country_id','142');
                }else{
                    Session::put('locale', 'en');
                    Session::put('country_id',$request->countryID);
                }

                return response()->json(['status' => 200, 'message' => __('validation.location')]);
            }else{
                return response()->json(['status' => 401, 'message' => __('validation.loc-not-available')]);
            }

        // }else{
        //     return back();
        // }
    }
    public function viewAllItem($service){
        if(!empty($service)){
            if(Cookie::get('location')){
                $location=unserialize(Cookie::get('location'));
                $country = Countries::select('id')->where('name',$location['country'])->first();
                if($country->id) {
                    $menu = Menu::where('item_category',$service)->where('item_visibility','1')->where('status','1')->orderBy(DB::raw('RAND()'))->get()->toArray();

                    $pageData = ['menu'=>$menu];
                        return view('frontend.home.allitem',$pageData);
                }
            }
        }
    }

    public function storeReview(Request $request){
        DB::beginTransaction();
        Helper::myLog('Review and Rating update : start');
        try {
            $updateData = [
                'chef_rating' => $request->chef,
                'chef_review' => $request->chef_review,
                'delivery_rating' => $request->del,
                'delivery_review' => $request->del_review,
                'status' => "2",
            ];
            ReviewRating::where('uuid',$request->review_uuid)->update($updateData);
            DB::commit();
            Helper::myLog('Review and Rating update : finish');
            return response()->json(['status' => 200, 'message' => __('validation.update')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Review and Rating : exception');
            Helper::myLog($exception);
            return response()->json(['status' => 500, 'message' => __('validation.nupdate')]);
        }
    }

    public function skipReview(Request $request){
        DB::beginTransaction();
        Helper::myLog('Review and Rating Skip : start');
        try {
            $updateData = [
                'status' => "1",
            ];
            ReviewRating::where('uuid',$request->uuid)->update($updateData);
            DB::commit();
            Helper::myLog('Review and Rating Skip : finish');
            return response()->json(['status' => 200, 'message' => __('validation.update')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Review and Rating Skip: exception');
            Helper::myLog($exception);
            return response()->json(['status' => 500, 'message' => __('validation.nupdate')]);
        }
    }

    public function autoCompleteAjax(Request $request)
    {
        $search=  $request->term;

        if(!empty(Helper::getLocCity())){
            $city = Helper::getLocCity();

            //Search Menu
            $menu = Menu::with('chefLocation')
            ->whereHas('chefLocation', function($chefLocation) use ($city) {
                $chefLocation->where('city_id','=',$city);
            })
            ->where(function ($query) use($search) {
                $query->where('item_name','LIKE','%' . $search . '%')
                ->orWhere('item_category','LIKE','%' . $search . '%')
                ->orWhere('item_type','LIKE', '%' . $search . '%');
            })
            ->groupBy('item_category')->limit(5)->get();

            if(!$menu->isEmpty()){
                $f=0;
                foreach($menu as $m){
                    $new_row['heading']= "Category";
                    $new_row['title']= $m->item_category;
                    $new_row['image']= url('public/frontend/images/menu/'.$m->photo);
                    $new_row['url']= url('search/menu/'.$m->item_category.'/'.$search);
                    $row_set[] = $new_row; //build an array
                    $f++;

                }
                if($f>1){
                    $new_row['heading']= "Category";
                    $new_row['title']= 'See all category';
                    $new_row['image']= url('public/frontend/images/all-category.jpg');
                    $new_row['url']= url('search/menu/all/'.$search);
                    $row_set[] = $new_row; //build an array
                }
            }


            //Search Chef
            $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];
            $chef = Users::with('chefLocation','chefMenu')
            ->whereHas('chefLocation', function($chefLocation) use ($city) {
                $chefLocation->where('city_id','=',$city);
            })
            ->whereHas('chefMenu')
            ->select('users.*')
            ->where($whereClouser)
            ->where('display_name','LIKE',"%{$search}%")
            ->orderBy('created_at','DESC')->limit(5)->get();

            if(!$chef->isEmpty()){
                $s=0;
                foreach($chef as $c){
                    $new_row['heading']= "Chef List";
                    $new_row['title']= $c->display_name;
                    $new_row['image']= url('public/frontend/images/users/'.$c->profile);
                    $new_row['url']= url('chef-profile/'.$c->profile_id);
                    $row_set[] = $new_row; //build an array
                    $s++;
                }
                if($s>1){
                    $new_row['heading']= "Chef List";
                    $new_row['title']= 'See all chef for: '.$search;
                    $new_row['image']= url('public/frontend/images/all-chef.jpg');
                    $new_row['url']= url('search/chef/all/'.$search);
                    $row_set[] = $new_row; //build an array
                }
            }
            if($menu->isEmpty()&&$chef->isEmpty()){

                    $new_row['heading']= "Category Or Chef";
                    $new_row['title']= 'No Result Found';
                    $new_row['image']= url('public/frontend/images/no-result.png');
                    $row_set[] = $new_row; //build an array
            }
        }
        echo json_encode($row_set);
    }

     public function search(Request $request){
        $search = $request->str;
        $displayBy = $request->display;
        $cat = $request->cat;
        $cuisines = Cuisine::select('id','name')->where('status','A')->get();
        if($displayBy=='menu'){
            $displayby=0;
            if(!empty(Helper::getLocCity())){
                $city = Helper::getLocCity();

                $menu = Menu::with('chefLocation','ratings','menuSchedule','service')
                        ->whereHas('chefLocation', function($chefLocation) use ($city) {
                            $chefLocation->where('city_id','=',$city);
                        });
                if($cat!='nearby'){
                    if($cat=="all"){
                            $menu = $menu->where(function ($query) use($search,$cat) {
                                $query->where('item_name','LIKE','%' . $search . '%')
                                ->orWhere('item_category','LIKE','%' . $search . '%')
                                ->orWhere('item_type','LIKE', '%' . $search . '%');
                            });
                    }else{
                            $menu = $menu->where(function ($query) use($search,$cat) {
                                $query->where('item_category','LIKE', '%' . $cat . '%')
                                ->orWhere('item_type','LIKE', '%' . $cat . '%');

                            });
                    }
                }
                if($request->has('rating')){
                    $rate = $request->rating;
                    $menu = $menu->whereHas('ratings', function($chefRatings)use($rate) {
                        $chefRatings->havingRaw('ROUND(AVG(chef_rating)) >= '.$rate);
                    });
                }
                if($request->has('service')){
                    $service = $request->service;
                    $menu = $menu->whereHas('service', function($chefService)use($service) {
                        $chefService->where('options',$service)->orWhere('options',2);
                    });
                }
                //Price Filter
                if($request->has('min_price') && $request->has('max_price')){
                    $menu = $menu->whereBetween('rate', [$request->min_price, $request->max_price]);
                }

                //Menu data to add distance
                $menu = $menu->get();
                foreach ($menu as $m) {

                    $chefLoc = $m->chefLocation->address;
                    $custLoc = Helper::getLocation();
                    $miles = Helper::geoLocationDistance($chefLoc,$custLoc);
                    $m['distance']=$miles;
                }

                //Available Date
                foreach ($menu as $m) {
                    $sch=$m->menuSchedule;
                    if(!empty($sch)){
                        if($sch->mon=="1"){
                            $day=1;
                        }else if($sch->tue=="1"){
                            $day=2;
                        }else if($sch->wed=="1"){
                            $day=3;
                        }else if($sch->thu=="1"){
                            $day=4;
                        }else if($sch->fri=="1"){
                            $day=5;
                        }else if($sch->sat=="1"){
                            $day=6;
                        }else if($sch->sun=="1"){
                            $day=0;
                        }
                        $startdate = Carbon::now()->addDay($sch->lead_time);
                        if( $sch->recurring==1)
                        {
                            $date='';
                            for($i=1;$i<=14;$i++){
                                if($startdate->dayOfWeek == $day){
                                    $date=$startdate;
                                    break;
                                }else{
                                    $startdate=$startdate->addDay(1);
                                }
                            }
                        }else{
                            $date='';
                            for($i=1;$i<=7;$i++){
                                if($startdate->dayOfWeek == $day){
                                    $date=$startdate;
                                    break;
                                }else{
                                    $startdate=$startdate->addDay(1);
                                }
                            }
                        }
                        if($date->isToday()){
                           $m['avilable_date']="Today";
                        }else{
                            $m['avilable_date']=$date->toDateString();
                        }
                    }
                }

                //Distance Filter
                if($request->has('min_miles') && $request->has('max_miles')){
                    $menu = $menu->whereBetween('distance',[$request->min_miles, $request->max_miles ]);
                }


                if(!$menu->isEmpty()){
                    foreach($menu as $m){
                        $chef[] = $m->chef_id;
                    }
                }else{$chef=[];}

                $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];
                $chefData = Users::with('ratings','chefLocation','chefBussiness','chefMenu')
                ->whereHas('chefLocation', function($chefLocation) use ($city) {
                    $chefLocation->where('city_id','=',$city);
                })
                ->whereHas('chefMenu')
                ->select('users.id','users.uuid','users.display_name','users.profile','users.profile_id')
                ->where($whereClouser)
                ->whereIn('id',$chef);

                if($request->has('rating')){
                    $rate = $request->rating;
                    $chefData = $chefData->whereHas('ratings', function($chefRatings)use($rate) {
                        $chefRatings->havingRaw('ROUND(AVG(chef_rating)) >= '.$rate);
                    });
                }
                $chefData = $chefData->get();
                if($request->has('popularity')){
                    $popularity = $request->popularity;
                    $chefData = $chefData->sortByDesc(function($users) {
                        return $users->ratings()->avg('chef_rating');
                    });
                }
            }
        }else{
            $displayby=1;
            if(!empty(Helper::getLocCity())){
                $city = Helper::getLocCity();

                if($cat=="all"){
                    $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];
                    $chefData = Users::with('chefLocation','ratings','chefMenu')
                    ->whereHas('chefLocation', function($chefLocation) use ($city) {
                        $chefLocation->where('city_id','=',$city);
                    })
                     ->whereHas('chefMenu')
                    ->select('users.*')
                    ->where($whereClouser)
                    ->where('display_name','LIKE',"%{$search}%")
                    ->orderBy('created_at','DESC');

                    if($request->has('service')){
                    $service = $request->service;
                        $menu = $menu->whereHas('service', function($chefService)use($service) {
                            $chefService->where('options',$service)->orWhere('options',2);
                        });
                    }
                    if($request->has('rating')){
                        $rate = $request->rating;
                        $chefData = $chefData->whereHas('ratings', function($chefRatings)use($rate) {
                            $chefRatings->havingRaw('ROUND(AVG(chef_rating)) >= '.$rate);
                        });
                    }
                    $chefData = $chefData->get();
                    if($request->has('popularity')){
                        $popularity = $request->popularity;
                        $chefData = $chefData->sortByDesc(function($users) {
                            return $users->ratings()->avg('chef_rating');
                        });
                    }

                    if(!$chefData->isEmpty()){
                        foreach($chefData as $m){
                            $chef[] = $m->id;
                        }
                        $menu = Menu::with('chefLocation')
                        ->whereHas('chefLocation', function($chefLocation) use ($city) {
                            $chefLocation->where('city_id','=',$city);
                        })
                        ->whereIn('chef_id',$chef)->get();

                        foreach ($menu as $m) {
                            $chefLoc = $m->chefLocation->address;
                            $custLoc = Helper::getLocation();
                            $miles = Helper::geoLocationDistance($chefLoc,$custLoc);
                            $m['distance']=$miles;
                        }
                        //Available Date
                        foreach ($menu as $m) {
                            $sch=$m->menuSchedule;
                            if(!empty($sch)){
                                if($sch->mon=="1"){
                                    $day=1;
                                }else if($sch->tue=="1"){
                                    $day=2;
                                }else if($sch->wed=="1"){
                                    $day=3;
                                }else if($sch->thu=="1"){
                                    $day=4;
                                }else if($sch->fri=="1"){
                                    $day=5;
                                }else if($sch->sat=="1"){
                                    $day=6;
                                }else if($sch->sun=="1"){
                                    $day=0;
                                }
                                $startdate = Carbon::now()->addDay($sch->lead_time);
                                if( $sch->recurring==1)
                                {
                                    $date='';
                                    for($i=1;$i<=14;$i++){
                                        if($startdate->dayOfWeek == $day){
                                            $date=$startdate;
                                            break;
                                        }else{
                                            $startdate=$startdate->addDay(1);
                                        }
                                    }
                                }else{
                                    $date='';
                                    for($i=1;$i<=7;$i++){
                                        if($startdate->dayOfWeek == $day){
                                            $date=$startdate;
                                            break;
                                        }else{
                                            $startdate=$startdate->addDay(1);
                                        }
                                    }
                                }
                                if($date->isToday()){
                                   $m['avilable_date']="Today";
                                }else{
                                    $m['avilable_date']=$date->toDateString();
                                }
                            }

                        }

                                //Distance Filter
                        if($request->has('min_miles') && $request->has('max_miles')){
                            $menu = $menu->whereBetween('distance',[$request->min_miles, $request->max_miles ]);
                        }
                    }else{$menu=[];}
                }
            }
        }

        //Sort Menu
        if($request->price=='desc'){
            $menu = $menu->sortByDesc('rate');
        }
        if($request->price=='asc'){
            $menu = $menu->sortBy('rate');
        }

        if($request->has('recently')){
            $menu = $menu->sortByDesc('created_at');
        }
        if($request->availability=='asc'){
            $menu = $menu->sortBy('avilable_date');
        }

        // Country,State, Currency
        $countryId = Helper::getLocCountry();
        $currency=[];
        if(!empty($countryId)){
            $currency = Countries::where('id',$countryId)->first();
        }
         $city = Helper::getLocCity();
         $state = Helper::getLocState();
        $taxes = Taxes::select('service_fee_per','tax')->where('state_id',$state)->where('city_id',$city)->first();
        $countryId = Helper::getLocCountry();
        $categories = Categories::where('country_id',$countryId)->inRandomOrder()->limit(12)->get();
        $pageData = [
                'displayby'=>$displayby,
                'menu'=>$menu,
                'chefData'=>$chefData,
                'cuisines'=>$cuisines,
                'search'=>$search,
                'currency'=>$currency,
                'taxes'=>$taxes,
                'categories'=>$categories

            ];
        return view('frontend.search.search',$pageData);
    }
    //Landing page country default location
    public function saveLocation(Request $request)
    {
        // if (request()->cookie('accept-cookie')){

            $locationData=CountryLocation::where('country_id',$request->countryID)->first();
            if(!empty($locationData->lat) && !empty($locationData->log) && !empty($locationData->country) && !empty($locationData->state) && !empty($locationData->address) && !empty($locationData->city)){

                $insertData = [
                    'lat' => $locationData->lat,
                    'log' => $locationData->log,
                    'country' => $locationData->country->name,
                    'state' => $locationData->state,
                    'city' => $locationData->city,
                    'address' => $locationData->address
                ];
                $minutes = 525600;
                Cookie::queue(Cookie::make('location', serialize($insertData), $minutes));

                if($request->countryID=='142'){
                    Session::put('locale', 'es');
                    Session::put('country_id','142');
                }else{

                    Session::put('locale', 'en');
                    Session::put('country_id',$request->countryID);
                }
                return response()->json(['status' => 200, 'message' => __('validation.location-avail')]);
            }else{
                return response()->json(['status' => 401, 'message' => __('validation.loc-not-available')]);
            }
        // }else{
        //      return response()->json(['status' => 401, 'message' => 'Please Allow Cookie']);
        //     return back();
        // }

    }
    public function termsCondition()
    {
        return view('frontend.policy.terms-condition');
    }
    public function privacyPolicy()
    {
        return view('frontend.policy.privacy-policy');
    }
    public function contactUs()
    {
        return view('frontend.policy.contact-us');
    }
    public function contactUsStore(Request $request)
    {
        DB::beginTransaction();
        Helper::myLog('Contact Us store : start');
        try {

            $validArray = [
                   'captcha' => 'required|captcha'
                    ];

            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) {
                $messages = $validator->messages();

                return response()->json(['status' => 409, 'message' =>  __('validation.in-captcha')]);

            }else{
                $email=$request->email;
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'name'=>$request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'subject'=>$request->subject,
                    'message'=>$request->message,
                ];
                $emailData['name'] = $request->name;
                $emailData['email'] = $request->email;
                $emailData['mobile'] = $request->mobile;
                $emailData['subject'] = $request->subject;
                $emailData['message'] = $request->message;
                Helper::sendMailAdmin($emailData, 'frontend.policy.contact-us-mail', 'Contact Us', $email);
                ContactUs::create($insertData);
                DB::commit();
                Helper::myLog('Contact Us store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => __('validation.msg-successfully-sent')]);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Contact Us store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
        }
    }
    public function disclaimer(){
       return view('frontend.policy.disclaimer');
    }
    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
