<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Crypt;
use App\Model\Roles;
use App\Model\Countries;
use App\Model\Menu;
use App\Model\Options;
use App\Model\States;
use App\Model\Cities;
use App\Model\Helper;
use App\Model\Cuisine;
use App\Model\Location;
use App\Model\Group;
use App\Model\Tax;
use App\Model\Business;
use App\Model\Banking;
use App\Model\PickupDelivery;
use App\Model\ChefGelleryImage;
use App\Model\ChefProfileVideo;
use App\Model\ChefProfileBlog;
use App\Model\ChefCertificate;
use App\Model\CustLocation;
use App\Model\DeliveryDetails;
use App\Model\ChefRegistrationInfo;
use App\Model\Taxes;
use App\Model\ReviewRating;
use App\Model\ChefDiscount;
use App\Model\ChefUsedCoupons;
use App\Model\Discount;
use App\Model\VendorDiscount;
use App\Model\UsedCoupons;
use App\Model\Message;
use App\Model\PickupDetails;
use Brian2694\Toastr\Facades\Toastr;
use Datatables;
use Socialite;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use Redirect;
use Config,File,DB,Cart;
use Illuminate\Support\Facades\Session;
use URL;
use PDF,Storage;

class ChefController extends Controller
{
    public function chefRegistration(){
    	$countries = Countries::whereIn('id', [166])->pluck('name', 'id');
        $states = States::where('country_id',$countries)->pluck('name','id');

       	$pageData = ['countries'=>$countries, 'states'=>$states,];
        return view('frontend.registration.chef-reg', $pageData);
    }

    public function chefRegStateInfo(Request $request){
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $user_type = $request->user_type;

        if(!empty($country_id && $state_id && $user_type)){
            $chefRegInfo = ChefRegistrationInfo::select('description')
                ->where('country_id',$country_id)
                ->where('state_id',$state_id)
                ->where('user_type',$user_type)->first();
            return response()->json($chefRegInfo);
        }
    }
    public function chefSignin(){
    	return view('frontend.login.chef-login');
    }

    public function saveChefRegistration(Request $request){

        DB::beginTransaction();
        Helper::myLog('Chef Registration Store : start');
        try {

            if($request->country==142)
            {
                $city=$request->municipality;

            }
            else
            {
                  $city=$request->city;
            }
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $mobile = $request->mobile;
            $email = $request->email;
            $country = $request->country;
            $state=$request->state;
            $address=$request->address;
            $zipcode = $request->zipcode;


            $checkEmail =Users::where('email', $email)->count();
            if ($checkEmail > 0) {
                Helper::myLog('Chef Registration store : email is exists');
                return response()->json(['status' => 409, 'message' => __('validation.email-exists')]);
            } else {
                $validate_code=Helper::randomString(8);

                $emailData['display_name'] =  ucwords(strtolower($first_name)) . ' ' .  ucwords(strtolower($last_name));
                $emailData['btn_url'] = url('/validate/' . $validate_code);
                $emailData['validate_code'] = $validate_code;
                Helper::sendMailAdmin($emailData, 'frontend.registration.mail', 'Validate Account', $email);

                 if ($file = $request->file('profile')) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/frontend/images/users/', $fileName);
                    $profile = $fileName;
                }else{
                    $profile = $request->profile_avtr;
                }
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'type' => 'Chef',
                    'password' => Hash::make($request->password),
                    'display_name' =>  ucwords(strtolower($first_name)) . " " .  ucwords(strtolower($last_name)),
                    'profile_id' => preg_replace("/[\s_]/", "-", strtolower($first_name)) . "-" . preg_replace("/[\s_]/", "-", strtolower($last_name)) . "-".Helper::randomDigits(4),
                    'first_name' =>  ucwords(strtolower($first_name)),
                    'last_name'=> ucwords(strtolower($last_name)),
                    'email' => $email,
                    'mobile' => $mobile,
                    'country_id' => $country,
                    'status' => 'I',
                    'validate_code' => $validate_code,
                    'profile' => $profile,
                    'experties' => $request->experties,
                    'cni' => $request->nic

                ];
                $chefReg= Users::create($insertData);

                $chefLcationInsert=[
                    'chef_id'=>$chefReg->id,
                    'address'=>$address,
                    'state_id' =>$state,
                    'city_id'=>$city,
                    'zip_code'=>$zipcode,
                    'acknowledgement' => $request->acknowledgement=='on' ? 1:0,
                    'privacy_policy' => $request->privacy_policy=='on'? 1:0,
                ];
                if($request->country==1442)
                {
                    $cityName = Cities::select('name')->where('id',$city)->first();
                    $data = [
                            'display_name' => $first_name . " " . $last_name,
                            'address'=>$request->address,
                            'city'=>$cityName->name,
                        ];
                    $pdf = PDF::loadView('frontend.policy.mexico-contract', $data);
                    $fileName =  $request->first_name.'-'. $request->last_name . '-'.Helper::randomDigits(4). '.pdf' ;
                    $path = public_path('frontend/contract/');
                    $pdf->save($path.'/'.$fileName);
                    $chefLcationInsert['contract']=$fileName;
                }

                Location::create($chefLcationInsert);

                // pickup delivery info
                $chefPickupDiliveryData = [
                    'chef_id'=>$chefReg->id,
                    'uuid' => Helper::getUuid(),
                    'options'=> $request->options,
                    'delivery_by' => $request->delivery_by,
                ];

                $itemData=PickupDelivery::create($chefPickupDiliveryData);
                $options = $itemData->options;
                if($options==1){


                    $insertPickupData = [
                        'pickup_delivery_id'=>$itemData->id,
                        'address'=>$request->address,
                        'state_id' => $request->state,
                        'city_id' => $request->city,
                        'zipcode' => $request->zipcode,
                        'mobile' => $request->mobile
                    ];
                    PickupDetails::create($insertPickupData);
                }else if($options==2){
                    // $itemData=PickupDelivery::create($insertData);

                    $insertPickupData = [
                        'pickup_delivery_id'=>$itemData->id,
                        'address'=>$request->address,
                        'state_id' => $request->state,
                        'city_id' => $request->city,
                        'zipcode' => $request->zipcode,
                        'mobile' => $request->mobile
                    ];

                    PickupDetails::create($insertPickupData);
                    foreach ($request->addmore as $key => $value) {

                        $insertPickupData = [
                            'pickup_delivery_id'=>$itemData->id,
                            'from_miles'=>$value['min_miles'],
                            'to_miles' => $value['max_miles'],
                            'rate' => $value['min_miles_rate'],

                        ];
                        DeliveryDetails::create($insertPickupData);
                    }
                }else if($options==3){
                    // $itemData=PickupDelivery::create($insertData);
                    foreach ($request->addmore as $key => $value) {
                        $insertPickupData = [
                            'pickup_delivery_id'=>$itemData->id,
                            'from_miles'=>$value['min_miles'],
                            'to_miles' => $value['max_miles'],
                            'rate' => $value['min_miles_rate'],

                        ];
                        // dd("inside");
                        DeliveryDetails::create($insertPickupData);
                    }
                    // dd("ok");
                }

                // certification info
                $chefCertificateData = [
                    'chef_id'=>$chefReg->id,
                    'uuid' => Helper::getUuid(),
                    'certi_name'=> $request->certi_name,
                    'certi_authority' => $request->certi_authority,
                    'certi_from' => $request->certi_from,
                    'certi_to' => $request->certi_to,
                    'certi_url' => $request->certi_url,
                    'status' =>'1',

                ];
                if ($file = $request->file('image')) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/frontend/images/certificate/', $fileName);
                    $image = $fileName;
                    $chefCertificateData['image']=$image;
                }
                $itemData=ChefCertificate::create($chefCertificateData);


                DB::commit();
                Helper::myLog('Chef Registration store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => __('validation.save')]);
            }
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollBack();
            Helper::myLog('Chef Registration store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
        }
    }

    public function chefProfile($chef_id){
        $chefData = Users::select('id','uuid','display_name','profile','country_id','profile_id')->with('country')
        ->where('users.profile_id',$chef_id)->first();
        $chefBusiness = Business::select('description','cuisine')->where('chef_id',$chefData->id)->first();
        $chefCuisine = Cuisine::select('name')->whereIn('id',explode(",", $chefBusiness->cuisine))->get();
        $chefLocation = Location::select('city_id','state_id')->with('state','city')->where('chef_id',$chefData->id)->first();

        $chefVideoCount = ChefProfileVideo::where('chef_id',$chefData->id)->where('status','A')->count();

        $chefBlogCount = ChefProfileBlog::where('chef_id',$chefData->id)->where('status','A')->count();

        $certiData = ChefCertificate::where('chef_id',$chefData->id)->where('status','A')->get();
        $chefPicDel = PickupDelivery::where('chef_id',$chefData->id)->first();
        $chefReview = ReviewRating::with('user')->where('chef_id',$chefData->id)->where('status',"2")
                        ->orderBy('chef_rating', 'DESC')->get();

        $chefRecentReview = ReviewRating::with('user')->where('chef_id',$chefData->id)->where('status',"2")
                        ->orderBy('updated_at', 'DESC')->limit(10)->get();

        $chefAvgRating = ReviewRating::where('chef_id',$chefData->id)->where('status',"2")->groupBy('chef_id')->avg('chef_rating');
        $chefNoOfRating = ReviewRating::where('chef_id',$chefData->id)->where('status',"2")->count();

        $chefItemCategory=Menu::select('id','item_category')->where('chef_id',$chefData->id)->groupBy('item_category')->get();
        $chefMainCategory=Menu::select('item_category')->where('chef_id',$chefData->id)->distinct('item_category')->get();
        $taxes = Taxes::select('service_fee_per','tax')->where('state_id',$chefLocation->state_id)->where('city_id',$chefLocation->city_id)->first();
        $mainCategory=array();
        foreach ($chefMainCategory as $value) {
            $subCategory=Menu::select('item_type')->where('chef_id',$chefData->id)
                                        ->where('item_category',$value->item_category)
                                        ->where('item_visibility','1')
                                        ->distinct('item_type')->pluck('item_type')->toArray();
            $mCat = ['subcategory'=>$subCategory,'items'=>[]];
            foreach ($subCategory as $value1) {
                $items = Menu::with('menuOptions','menuSchedule','menuNutrition')->where('chef_id',$chefData->id)
                            ->where('item_category',$value->item_category)
                            ->where('item_type',$value1)
                            ->where('item_visibility','1')
                            ->get();

                array_push($mCat['items'],$items);
            }
            array_push($mainCategory,$mCat);
        }

        $groups = Group::where('chef_id',$chefData->id)->get();
        $gelleryData = ChefGelleryImage::where('chef_id',$chefData->id)->get();
        $countryId=Users::select('country_id')->where('id',$chefData->id)->first();
        $currency=[];
        if($countryId){
            $currency = Countries::where('id',$countryId->country_id)->first();
        }
        $pageData = [
                'chefData'=>$chefData,
                'chefBusiness'=>$chefBusiness,
                'chefCuisine'=>$chefCuisine,
                'chefLocation'=>$chefLocation,
                'chefMainCategory'=>$chefMainCategory,
                'mainCategory'=>$mainCategory,
                'gelleryData'=>$gelleryData,

                'certiData'=>$certiData,
                'groups'=>$groups,
                'currency'=>$currency,
                'chefReview'=>$chefReview,
                'chefAvgRating'=>$chefAvgRating,
                'chefNoOfRating'=>$chefNoOfRating,
                'chefRecentReview'=>$chefRecentReview,
                'chefPicDel'=>$chefPicDel,
                'chefVideoCount'=>$chefVideoCount,
                'chefBlogCount'=>$chefBlogCount,
                'taxes'=>$taxes
            ];

        return view('frontend.chef.chef-profile',$pageData);
    }

    public function chefProfileVideo($id){
        $chef=Users::select('id')->where('profile_id',$id)->first();
        $videoData = ChefProfileVideo::where('chef_id',$chef->id)->where('status','A')->get();
        $pageData = ['videoData'=>$videoData];
        return view('frontend.chef.chef-profile-video',$pageData);
    }
    public function chefProfileBlog($id){
        $chef=Users::select('id')->where('profile_id',$id)->first();
        $blogData = ChefProfileBlog::where('chef_id',$chef->id)->where('status','A')->get();

        $pageData = ['blogData'=>$blogData];
        return view('frontend.chef.chef-profile-blog',$pageData);
    }

    public function validateChefLogin(Request $request){
        $code=$request->code;

        if($code==1){

            return view('frontend.login.chef-validate');
        }else{
            $data =Users::where('validate_code', $code)->first();

            $pageData = ['data'=>$data];
            return view('frontend.login.chef-validate',$pageData);
        }
    }
    public function chefValidate(Request $request){

        DB::beginTransaction();
        Helper::myLog('Chef Registration Validate : start');
        try {
            $user = Users::where('email',$request->email)->first();
            $validate_code=$request->validate_code;
            $checkStatus =Users::where('email',$request->email)->where('status','A')->count();
            $checkPassword = Auth::guard('chef')->attempt(['email' => $request->email, 'password' => $request->password]);

            if ($checkStatus > 0) {
                Helper::myLog('Chef Registration Validate : Already Activated');
                return response()->json(['status' => 409, 'message' => __('validation.activate')]);
            }elseif($user->validate_code != $validate_code){
                Helper::myLog('Chef Registration Validate : Invalid Code');
                return response()->json(['status' => 409, 'message' => __('validation.incode')]);
            }elseif (!$checkPassword) {
                Helper::myLog('Chef Registration Validate : Incorrect Password');
                return response()->json(['status' => 409, 'message' => __('validation.inpassword')]);
            } else {
                $validate_code=Helper::randomString(8);
                $updateData = [
                    'validate_code' => $validate_code,
                    'status' => 'A',
                    'activate_date'=>Carbon::now(),
                ];
                Users::where('email', $request->email)->update($updateData);
                DB::commit();
                Session::put('uuid', $user->uuid);
                Helper::myLog('Chef Registration validate : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => __('validation.save'),'uuid'=>$user->uuid]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Registration store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
        }
    }
    public function chefResendValidate(Request $request){
        DB::beginTransaction();
        Helper::myLog('Chef Resend validate code Store : start');
        try {
            $email = $request->txt;
            $checkActivate =Users::where('email',$email)->where('status','A')->count();
            $checkEmail =Users::where('email', $email)->count();
            $user=Users::where('email',$email)->first();
            if ($checkEmail == 0) {
                Helper::myLog('Chef Resend validate code store : email is not exists');
                return response()->json(['status' => 409, 'message' => __('validation.valid-email')]);
            } else if($checkActivate > 0){
                Helper::myLog('Chef Registration Validate : Already Activated');
                return response()->json(['status' => 409, 'message' => __('validation.activate')]);
            } else{

                $validate_code=Helper::randomString(8);
                $emailData['display_name'] = $user->first_name . ' ' . $user->last_name;
                $emailData['btn_url'] = url('/validate/' . $validate_code);
                $emailData['validate_code'] = $validate_code;
                Helper::sendMailAdmin($emailData, 'frontend.registration.mail', 'Validate Account', $email);
                $updateData = [
                    'validate_code' => $validate_code
                ];
                Users::where('email', $email)->update($updateData);
                DB::commit();
                Helper::myLog('Chef Resend validate code store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => __('validation.code-send')]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Resend validate code store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.code-not-send')]);
        }
    }
    public function chefLogin(Request $request){
        try {

            $isLogin = Auth::guard('chef')->attempt(['email' => $request->email, 'password' => $request->password,'status'=>'A','type'=>'Chef']);
            if ($isLogin) {
                $getAuthUser = auth('chef')->user();
                Session::put('name', $getAuthUser->first_name . ' ' . $getAuthUser->last_name);
                Session::put('chefId', $getAuthUser->id);
                Session::put('type', $getAuthUser->type);
                Session::put('profile', asset('public/frontend/images/users/' . $getAuthUser->profile));
                return response()->json(['status' => 200, 'message' => 'Login Successfully']);
            }else{
                return response()->json(['status' => 401, 'message' => __('validation.wrong-credential')]);
            }

        } catch (\Exception $exception) {
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
        return response()->json(['status' => 500,'message' =>__('validation.oops')]);
        }
    }

    public function thankYou(){
        return view('frontend.registration.thank-you');
    }
    public function optionCart(Request $request){

        $optionId=[];

        if(!empty($request->rcheckboxes)){
            $optionId=array_merge($optionId, $request->rcheckboxes);
        }
        if(!empty($request->rradio)){
            $optionId=array_merge($optionId, $request->rradio);
        }
        if(!empty($request->nrcheckboxes)){
            $optionId=array_merge($optionId, $request->nrcheckboxes);
        }
        if(!empty($request->nrradio)){
            $optionId=array_merge($optionId, $request->nrradio);
        }
        $available_date=$request->available_date;

        $available_time=$request->available_time;
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        $instruction=$request->instruction;
        $menu_id=$request->menu_id;
        $qty=$request->qty;

        $menuData = Menu::select()->with('user')->where('id',$menu_id)->where('status','1')->first();

        $selectedItems = ['menu_options.id','menu_options.option','menu_options.rate', 'menu_option_group.group_name'];
        $menuOptionData = Options::select($selectedItems)
                            ->leftjoin('menu_option_group', 'menu_options.group_id', 'menu_option_group.id')
                            ->whereIn('menu_options.id',$optionId)->get();
        if($menuData->user->country_id==142){

            $chLocation = Location::select('city_id','state_id')->with('state','city')->where('chef_id',$menuData->chef_id)->first();
            $taxes = Taxes::select('service_fee_per','tax')->where('state_id',$chLocation->state_id)->where('city_id',$chLocation->city_id)->first();
            $menuData->rate = $menuData->rate+($menuData->rate * $taxes->service_fee_per / 100);
            $menuData->rate = $menuData->rate+($menuData->rate * $taxes->tax / 100);
            foreach ($menuOptionData as $key => $value) {
                $value->rate = $value->rate+($value->rate * $taxes->service_fee_per / 100);
                $value->rate = $value->rate+($value->rate * $taxes->tax / 100);
            }
        }

        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                $available_date=>[
                    Helper::getUuid() => [
                        "menu_id" => $menu_id,
                        "item_name" => $menuData->item_name,
                        "quantity" => $qty,
                        "minimum_order" => $menuData->minimum_order,
                        "price" => $menuData->rate,
                        "instruction" => $instruction,
                        "photo" => $menuData->photo,
                        "option"=> $menuOptionData->toArray(),
                        "chef_nm"=>$menuData->user->display_name,
                        "chef_id"=>$menuData->user->id,
                        "available_date"=>$available_date,
                        "available_time"=>$available_time,
                        "start_time"=>$start_time,
                        "end_time"=>$end_time
                    ]
                ]

            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }else{
            $flag=0;
            foreach ($cart as $date) {
                foreach ($date as $value) {
                   if($value['chef_id']==$menuData->user->id)
                    {
                        $flag=1;
                    }
                }
            }
            if($flag==1){
                foreach ($cart as $key => $value) {
                    if($key==$available_date){
                        $cart[$key][Helper::getUuid()] = [
                            "menu_id" => $menu_id,
                            "item_name" => $menuData->item_name,
                            "quantity" => $qty,
                            "minimum_order" => $menuData->minimum_order,
                            "price" => $menuData->rate,
                            "instruction" => $instruction,
                            "photo" => $menuData->photo,
                            "option"=> $menuOptionData->toArray(),
                            "chef_nm"=>$menuData->user->display_name,
                            "chef_id"=>$menuData->user->id,
                            "available_date"=>$available_date,
                            "available_time"=>$available_time,
                            "start_time"=>$start_time,
                            "end_time"=>$end_time
                        ];
                        break;
                    }else{
                        $cart[$available_date][Helper::getUuid()] = [
                            "menu_id" => $menu_id,
                            "item_name" => $menuData->item_name,
                            "quantity" => $qty,
                            "minimum_order" => $menuData->minimum_order,
                            "price" => $menuData->rate,
                            "instruction" => $instruction,
                            "photo" => $menuData->photo,
                            "option"=> $menuOptionData->toArray(),
                            "chef_nm"=>$menuData->user->display_name,
                            "chef_id"=>$menuData->user->id,
                            "available_date"=>$available_date,
                            "available_time"=>$available_time,
                            "start_time"=>$start_time,
                            "end_time"=>$end_time
                        ];
                        break;
                    }
                }
            }else{
                unset($cart);

                $cart[$available_date][Helper::getUuid()] = [
                    "menu_id" => $menu_id,
                    "item_name" => $menuData->item_name,
                    "quantity" => $qty,
                    "minimum_order" => $menuData->minimum_order,
                    "price" => $menuData->rate,
                    "instruction" => $instruction,
                    "photo" => $menuData->photo,
                    "option"=> $menuOptionData->toArray(),
                    "chef_nm"=>$menuData->user->display_name,
                    "chef_id"=>$menuData->user->id,
                    "available_date"=>$available_date,
                    "available_time"=>$available_time,
                    "start_time"=>$start_time,
                    "end_time"=>$end_time
                ];

            }
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
    }

    public function removeCart(Request $request)
    {

        if($request->id) {
            $cart = session()->get('cart');
            foreach ($cart as $key => $value) {
                foreach ($value as $k => $v) {
                    if($k==$request->id){
                        unset($cart[$key][$k]);
                        session()->put('cart', $cart);
                        if(count($cart[$key])==0){
                           Session::forget('cart.' . $key);
                        }

                    }
                }
            }
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        }

    }
    public function clearCart(Request $request){
        if($request->date != 'all'){
            $d=str_replace('-', '/', $request->date);
            Session::forget('cart.' . $d);
            Session::forget('order');
        }else{
            Session::forget('cart');
            Session::forget('order');
        }
        return redirect()->back();
    }
    public function changeCartQty(Request $request){

        if($request->id and $request->qty)
        {
            $cart = session()->get('cart');
            foreach ($cart as $key => $value) {
                foreach ($value as $k => $v) {
                    if($k == $request->id){
                        $cart[$key][$request->id]["quantity"] = $request->qty;
                        session()->put('cart', $cart);
                        break;
                    }
                }
            }
            return \Response::json(['status' => Config::get('constants.status.success')], 200);
        }
    }

    public function continueCart($date){

        if(auth('front')->check() && auth('front')->user()->type == "Customer"){
            $cart = session()->get('cart');

            $d=str_replace('-', '/', $date);
            if($cart){
                foreach ($cart as $c=>$subC) {
                    if($c==$d){
                        $subCart=$subC;
                        $subCartOrder=$subC;
                        foreach ($subC as $k => $value) {
                            $chef_id=$value['chef_id'];
                        }
                    }
                }
            }

            if(empty($subCart)){
                return redirect::route('home');
            }
            $chefLoc=Location::where('chef_id',$chef_id)->first();
            $taxes = Taxes::where('state_id',$chefLoc->state_id)->where('city_id',$chefLoc->city_id)->first();

            $currentLocation = CustLocation::where('cust_id',auth('front')->user()->id)->first();
            $pickupDeliveryDetails = PickupDelivery::with('pickupDetails','deliveryDetails')->where('chef_id',$chef_id)->first();
            $country=Users::select('country_id')->where('id',auth('front')->user()->id)->first();
            $states = States::where('country_id',$country->country_id)->pluck('name','id');
            if(!empty($pickupDeliveryDetails->pickupDetails)){
                $cities = Cities::where('state_id', $pickupDeliveryDetails->pickupDetails->state_id)->pluck('name','id');
            }else{
                $cities = [];
            }
            $countryId=Users::select('country_id')->where('id',$chef_id)->first();
            if($countryId){
                $currency = Countries::where('id',$countryId->country_id)->first();
            }else{
                $currency = Countries::where('id',231)->first();
            }

            /* Order Detail Session */
            $subTotal=0;
            if(!empty($subCartOrder)){
                foreach($subCartOrder as $s){
                    $chefID = $s['chef_id'];
                    $optionTotal=0;
                    if($s['option']!=NULL){
                        foreach($s['option'] as $option){
                            $optionTotal += $option['rate'];
                        }
                        $subTotal += $s['quantity']*($s['price']+$optionTotal) ;
                    }else{
                        $subTotal += $s['quantity']*($s['price']);
                    }
                }
            }
            $serviceFee = $taxes->service_fee_base+($subTotal*$taxes->service_fee_per/100);
            $tax = (($subTotal+$serviceFee)*$taxes->tax)/100;
            $st=[];
            if(!empty($subCart)){
                foreach($subCart as $s){
                    array_push($st, strtotime($s['start_time']));
                }
                $pickDelTime=max($st);
            }

            $subCartOrder['orderData']=[
                'chef_id' => $chefID,
                'cust_id' => auth('front')->user()->id,
                'delivery_date' => Carbon::parse($d)->format('Y-m-d'),
                'pick_del_option' => 1,
                'pick_del_time' => date('H:i', $pickDelTime),
                'delivery_by' => $pickupDeliveryDetails->delivery_by,
                'chef_commission_per' =>$taxes->chef_commission,
                'delivery_commission_per' =>$taxes->delivery_commission,
                'sub_total' => $subTotal,
                'chef_discount' => 0.00,
                'house_discount' => 0.00,
                'makem_discount' => 0.00,
                'service_fee' => $serviceFee,
                'delivery_fee' => 0.00,
                'tax_fee' => $tax,
                'tax_per'=>$taxes->tax,
                'tip_fee' => 0.00,
                'currency_code'=>$currency->code
            ];

            $order = session()->get('order');
            if($order) {
                session()->put('order', $subCartOrder);
            }

            $pageData = [
                'subCart'=>$subCart,
                'pickupDeliveryDetails'=>$pickupDeliveryDetails,
                'states'=>$states,
                'cities' => $cities,
                'currentLocation'=>$currentLocation,
                'taxes'=>$taxes,
                'chefLoc' => $chefLoc,
                'currency'=>$currency
            ];

            return view('frontend.cart.cart-details',$pageData);
        }else{
            Session::put('redirect', URL::full());
            return view('frontend.login.customer-login');
        }
    }
    public function saveDeliveryAddress(Request $request){

        DB::beginTransaction();
        Helper::myLog('Delivery Address update : start');
        try {

            $cust_id=Crypt::decrypt($request->cust_id);
            $del_lat=$request->del_lat;
            $del_log=$request->del_log;
            $del_country=$request->del_cntry;
            $del_address=$request->del_address;
            $del_city=$request->del_city;
            $del_state=$request->del_state;
            $pic_time=$request->pic_time;


            if(!empty($del_lat)&& !empty($del_log)){
                $updateData = [
                    'lat' => $request->del_lat,
                    'log' => $request->del_log,
                    'country' => $request->del_cntry,
                    'address' => $request->del_address,
                    'city' => $request->del_city,
                    'state' => $request->del_state,
                ];

            } else{
                $updateData = [
                    'address' => $request->del_address,
                    'city' => $request->del_city,
                    'state' => $request->del_state,
                ];

            }
            CustLocation::where('cust_id', $cust_id)->update($updateData);
            $del_add = str_replace( ' ','+',str_replace( ',','',$del_address));
            $pic_add = str_replace(' ','+',str_replace( ',','',$request->chef_add));
            $pic_del_id = $request->pic_del_id;

            if($del_add && $pic_add){

                $curl = curl_init();
                $str="https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$del_add."&destinations=".$pic_add."&key=AIzaSyDlkfpkyKX2wb_cRMmqVWthoadHuegCdoc";
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $str,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "postman-token: 40ad1c4f-b5c9-bd91-f81b-f2276fd45c09"
                  ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err) {
                    Helper::myLog('Address Not Found');
                    return response()->json(['status' => 409, 'message' => __('validation.naddress')]);
                } else {
                    $respo=json_decode($response);
                    if($respo->rows[0]->elements[0]->status=='ZERO_RESULTS'){
                        return response()->json(['status' => 409, 'message' => __('validation.chef-not-deliver')]);
                    }
                    $miles=$respo->rows[0]->elements[0]->distance->text;
                    $miles=substr($miles, 0, strpos($miles, " "));
                    $deliverydetails=DeliveryDetails::where('pickup_delivery_id',$pic_del_id)->get();

                    $delCharge=0;
                    $chargeFlag=0;
                    foreach ($deliverydetails as $key => $value) {
                        if(($miles > $value->from_miles) && ($miles < $value->to_miles)){
                            $chef=Users::select('country_id')->where('id',Crypt::decrypt($request->chef_id))->first();
                            $chefLocation=Location::select('state_id','city_id')->where('chef_id',Crypt::decrypt($request->chef_id))->first();

                            if($chef->country_id==142){
                                  $taxes = Taxes::select('tax','delivery_commission')->where('state_id',$chefLocation->state_id)->where('city_id',$chefLocation->city_id)->first();

                                $delTax=$value->rate * $taxes->delivery_commission / 100 + $value->rate;
                                $delCharge=$delTax * $taxes->tax / 100 + $delTax;

                            }else{
                                $delCharge=$value->rate;
                            }

                            $order = session()->get('order');
                            if(!empty($order)){
                                $order['orderData']['delivery_fee']=number_format($delCharge, 2);
                                $order['orderData']['pick_del_option']=2;
                                $order['orderData']['pick_del_time']=$pic_time;
                                session()->put('order', $order);
                            }
                            DB::commit();
                            Helper::myLog('Delivery Address update : finish');
                            return response()->json(['status' => 200, 'message' => __('validation.update'),'del_charge'=>$delCharge,'miles'=>$miles]);
                            $chargeFlag=1;
                        }
                    }
                    if($chargeFlag==0){
                        return response()->json(['status' => 409, 'message' => __('validation.chef-not-deliver')]);
                    }
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Delivery Address update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.oops')]);
        }
    }
    public function addTips(Request $request){
        if($request->tips)
        {
            $order = session()->get('order');
            $tips=$request->tips;
            $sTotal=$order['orderData']['sub_total'];
            $order['orderData']['tip_fee']=number_format($sTotal*$tips/100,2);
            session()->put('order', $order);
            return \Response::json(['status' => Config::get('constants.status.success')], 200);
        }
    }
    public function removeDelCharge(Request $request){
        $order = session()->get('order');
        $order['orderData']['tip_fee']=0.00;
        $order['orderData']['delivery_fee']=0.00;
        session()->put('order', $order);
        return \Response::json(['status' => Config::get('constants.status.success')], 200);
    }
    public function addDiscount(Request $request){
        DB::beginTransaction();
        Helper::myLog('Coupon store : start');
        try {

            $today = Carbon::now();
            $order=session()->get('order');
            $chef_id=$order['orderData']['chef_id'];
            $chefLoc = Users::getCountryState($chef_id);
            $promo_code =$request->promo_code;
            $chefDisExists=ChefDiscount::where('promo_code',$promo_code)
                        ->whereColumn('total_coupons','>','total_used_coupons')
                        ->whereDate('starts_at', '<=', $today->format('Y-m-d'))
                        ->whereDate('expired_at', '>=', $today->format('Y-m-d'))
                        ->where('minimum_order_value', '<=',$order['orderData']['sub_total'])
                        ->where('status','1')
                        ->where('chef_id',$chef_id)
                        ->first();

            $companyDisExists=Discount::where('promo_code',$promo_code)
                        ->whereColumn('total_coupons','>','total_used_coupons')
                        ->whereDate('starts_at', '<=', $today->format('Y-m-d'))
                        ->whereDate('expired_at', '>=', $today->format('Y-m-d'))
                        ->where('minimum_order_value', '<=',$order['orderData']['sub_total'])
                        ->where('country_id',$chefLoc['country_id'])
                        ->whereIn('state_id',[$chefLoc['state_id'],0])
                        ->where('status','1')
                        ->first();

            $vendorDisExists=VendorDiscount::where('promo_code',$promo_code)
                        ->whereColumn('total_coupons','>','total_used_coupons')
                        ->whereDate('starts_at', '<=', $today->format('Y-m-d'))
                        ->whereDate('expired_at', '>=', $today->format('Y-m-d'))
                        ->where('minimum_order_value', '<=',$order['orderData']['sub_total'])
                        ->where('status','1')
                        ->where('country_id',$chefLoc['country_id'])
                        ->whereIn('state_id',[$chefLoc['state_id'],0])
                        ->first();


            $userId = auth('front')->user()->id;
            if(!empty($chefDisExists)){

                $couponId=$chefDisExists['id'];
                $count=UsedCoupons::where('coupon_id',$couponId)->where('user_id',$userId)->count();

                if($count>0){
                    return response()->json(['status' => 409, 'message' => __('validation.used-coupon')]);
                }else{

                    $discount=$chefDisExists['discount'];
                    $order=session()->get('order');
                    $subTotal=$order['orderData']['sub_total'];
                    $discountAmt = ($subTotal*$discount)/100;
                    $order['orderData']['chef_discount']=$discountAmt;
                    $order['orderData']['makem_discount']=0.0;
                    $order['orderData']['house_discount']=0.0;
                    $order['orderData']['coupon_id']=$couponId;
                    $order['orderData']['discount_by']=3;

                    session()->put('order', $order);
                    DB::commit();
                    Helper::myLog('Coupon store : finish');
                    return response()->json(['status' => 200, 'message' => __('validation.add-coupon'),'discount'=>$discountAmt]);
                }
            }else if(!empty($companyDisExists)){
                $couponId=$companyDisExists['id'];
                $count=UsedCoupons::where('coupon_id',$couponId)->where('user_id',$userId)->count();
                if($count>0){
                    return response()->json(['status' => 409, 'message' => __('validation.used-coupon')]);
                }else{
                    $discount=$companyDisExists['company_discount'];
                    $order=session()->get('order');
                    $subTotal=$order['orderData']['sub_total'];
                    $discountAmt = ($subTotal*$discount)/100;
                    $order['orderData']['makem_discount']=$discountAmt;
                    $order['orderData']['chef_discount']=0.0;
                    $order['orderData']['house_discount']=0.0;
                    $order['orderData']['coupon_id']=$couponId;
                    $order['orderData']['discount_by']=1;
                    session()->put('order', $order);
                    DB::commit();
                    Helper::myLog('Coupon store : finish');
                    return response()->json(['status' => 200, 'message' => __('validation.add-coupon'),'discount'=>$discountAmt]);

                }
            }else if(!empty($vendorDisExists)){
                $couponId=$vendorDisExists['id'];
                $count=UsedCoupons::where('coupon_id',$couponId)->where('user_id',$userId)->count();

                if($count>0){
                    return response()->json(['status' => 409, 'message' => __('validation.used-coupon')]);
                }else{
                    $discount=$vendorDisExists['vendor_discount'];
                    $order=session()->get('order');
                    $subTotal=$order['orderData']['sub_total'];
                    $discountAmt = ($subTotal*$discount)/100;
                    $order['orderData']['house_discount']=$discountAmt;
                    $order['orderData']['chef_discount']=0.0;
                    $order['orderData']['makem_discount']=0.0;
                    $order['orderData']['coupon_id']=$couponId;
                    $order['orderData']['discount_by']=2;
                    DB::commit();
                    Helper::myLog('Coupon store : finish');
                    return response()->json(['status' => 200, 'message' => __('validation.add-coupon'),'discount'=>$discountAmt]);
                }
            }else{
                return response()->json(['status' => 409, 'message' => __('validation.in-promocode')]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Coupon store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
        }

    }
    public function logout(Request $request) {
        try {
            auth('chef')->logout();
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
}
