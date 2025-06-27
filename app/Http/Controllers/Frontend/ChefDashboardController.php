<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\AdminController;
use App\Model\Roles;
use App\Model\Countries;
use App\Model\Menu;
use App\Model\Options;
use App\Model\States;
use App\Model\Cities;
use App\Model\Helper;
use App\Model\Cuisine;
use App\Model\Location;
use App\Model\Tax;
use App\Model\Group;
use App\Model\Business;
use App\Model\Banking;
use App\Model\ChefGelleryImage;
use App\Model\ChefProfileVideo;
use App\Model\ChefCertificate;
use App\Model\PickupDelivery;
use App\Model\Order;
use App\Model\ReviewRating;
use App\Model\ChefDiscount;
use App\Model\Message;
use App\Model\TicketMessage;
use App\Model\Ticket;
use Toastr;
use Datatables;
use Socialite;
Use \Carbon\Carbon;
use Validator;
use Redirect;
use Session;
use Config;
use Auth;
use File;
use DB;

class ChefDashboardController extends Controller
{
   
    public function chefDashboard(){
        //return redirect()->route('menu.index');
        $chefMainCategory=Menu::select('item_category')->where('chef_id',auth('chef')->user()->id)
        ->distinct('item_category')->get();
        $categoryItemData=array();
        foreach ($chefMainCategory as $value) {
            $itemData = Menu::where('chef_id',auth('chef')->user()->id)
                                ->where('item_category',$value->item_category)->get();
             array_push($categoryItemData,$itemData);
        }
        //new dashboard 
        $totalMenu=Menu::select('item_category')->where('chef_id',auth('chef')->user()->id)->where('status','1')->distinct('item_category')->count();   
        $unCompletedOrder = Order::where('chef_id',auth('chef')->user()->id)->whereIn('status',[2,4,5,6])->count(); 

        $todayIncome=Order::select('chef_commission_fee')->whereDate('created_at', Carbon::today())->where('chef_id',auth('chef')->user()->id)->sum('chef_commission_fee');
        
        $customers= Order::select('cust_id')->where('chef_id',auth('chef')->user()->id)->distinct('cust_id')->get();  
        
        $pendingOrder = Order::where('chef_id',auth('chef')->user()->id)->where('status',2)->get();  

        $orderListPen=Order::with('orderItems','user')
        ->where('chef_id',auth('chef')->user()->id)
        ->where('status',2)
        ->paginate(5);
       
        
        $chekPickDel=PickupDelivery::where('chef_id',auth('chef')->user()->id)->count();
        $checkBunssinessDetail=Business::Where('chef_id',auth('chef')->user()->id)->count();
        $checkBankingDetail=Banking::Where('chef_id',auth('chef')->user()->id)->count();
        $checkTaxDetail=Tax::Where('chef_id',auth('chef')->user()->id)->count();
        $chekMenu=Menu::where('chef_id',auth('chef')->user()->id)->count();
         
        
        $countryId=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $currency=[];
        if($countryId){
            $currency = Countries::where('id',$countryId->country_id)->first();
        } 
        $pageData = [
            'chefMainCategory'=>$chefMainCategory,
            'categoryItemData'=>$categoryItemData,
            'unCompletedOrder'=>$unCompletedOrder,
            'totalMenu'=>$totalMenu,
            'customers'=>$customers,
            'todayIncome'=>$todayIncome,
            'orderListPen'=>$orderListPen,
            'currency'=>$currency,
            'chekPickDel'=>$chekPickDel,
            'checkBunssinessDetail'=>$checkBunssinessDetail,
            'checkBankingDetail'=>$checkBankingDetail,
            'checkTaxDetail'=>$checkTaxDetail,
            'chekMenu'=>$chekMenu
        ];        
        $userAcc = Users::select('account_id')->where('id',auth('chef')->user()->id)->first();
        //Creating New Connected Acct
        if($userAcc->account_id==NULL){
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $account = \Stripe\Account::create([
                'country' => 'MX',
                'type' => 'express',
                'capabilities' => [
                    'card_payments' => [
                      'requested' => true,
                    ],
                    'transfers' => [
                      'requested' => true,
                    ],
                ],
            ]);
            $updateData = [
                'account_id' => $account->id
            ];
            Users::where('id', auth('chef')->user()->id)->update($updateData);
            $account_links = \Stripe\AccountLink::create([
                'account' => $account->id,
                'refresh_url' => 'https://prepbychef.com/chef-dashboard',
                'return_url' => 'https://prepbychef.com/chef-dashboard',
                'type' => 'account_onboarding',
            ]);
            $checkStripeDetail=0;
            $pageData['checkStripeDetail']=$checkStripeDetail;
            $pageData['accountLink']=$account_links->url;
        }else{
             \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $response = $stripe->accounts->retrieve($userAcc->account_id,[]);
            if($response->charges_enabled == true && $response->details_submitted == true){
               
                $stripeDashoardLink=\Stripe\Account::createLoginLink($userAcc->account_id);
                if($stripeDashoardLink){
                    $pageData['loginLink']=$stripeDashoardLink->url;
                }
                $checkStripeDetail=1;
                $pageData['checkStripeDetail']=$checkStripeDetail;
                $pageData['accountLink']='';
            }else{
                 \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $account_links = \Stripe\AccountLink::create([
                    'account' => $userAcc->account_id,
                    'refresh_url' => 'https://prepbychef.com/chef-dashboard',
                    'return_url' => 'https://prepbychef.com/chef-dashboard',
                    'type' => 'account_onboarding',
                ]);
                $checkStripeDetail=0;
                $pageData['checkStripeDetail']=$checkStripeDetail;
                $pageData['accountLink']=$account_links->url;
                $pageData['loginLink']='';
                
            }
        }  
        
        $check=0;
        if($chekPickDel>0&&$checkBunssinessDetail>0&& $checkTaxDetail>0&&$checkStripeDetail>0){
            $check=1;
        }  
        $pageData['check']=$check;              
        return view('frontend.chef-dashboard.dashboard',$pageData);
    }
    public function stripeAccount() {

        $userAcc = Users::select('account_id')->where('id',auth('chef')->user()->id)->first();

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripeDashoardLink=\Stripe\Account::createLoginLink($userAcc->account_id);
        if($stripeDashoardLink){
            
            return response()->json($stripeDashoardLink->url);
        }
        
    }
    public function gelleryFileStore(Request $request)
    {
        DB::beginTransaction();
        Helper::myLog('Chef Gellery Image Store : start');
        try {
                $image = $request->file('file');
                $imageName = $image->getClientOriginalName();
                $image->move(base_path() . '/public/frontend/images/gellery/', $imageName);       
                $imageUpload = new ChefGelleryImage();
                $imageUpload->filename = $imageName;
                $imageUpload->chef_id = auth('chef')->user()->id;
                $imageUpload->save();
                DB::commit();
                Helper::myLog('Chef Gellery Image store : finish');
                Toastr::success(Config::get('constants.message.file_upload'), 'Upload');
                return response()->json(['success'=>$imageName]);           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Gellery Image store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.nupload')]);
        }
        
    }
   
    
    public function gelleryfileDestroy($id){
        DB::beginTransaction();
        Helper::myLog('Chef Gellery Image delete : start');
        try {
            $gelleryData=ChefGelleryImage::where('id',$id)->first();
            if($gelleryData->filename){
                $destinationPath = base_path() . '/public/frontend/images/gellery/' . $gelleryData->filename;
                File::delete($destinationPath); // remove oldfile
            }
            ChefGelleryImage::where('id',$id)->delete();
            DB::commit();
            Helper::myLog('Chef Gellery Image delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Item option delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $exception->getMessage()], 200);

        }
    }
    
     public function chefDashboardProfile(){
        $basicInfo = Users::select('id','uuid','first_name','last_name','email','mobile','profile','country_id')
                    ->where('id',auth('chef')->user()->id)->first();
        $location = Location::where('chef_id',auth('chef')->user()->id)->first();
        $tax = Tax::where('chef_id',auth('chef')->user()->id)->first();        
        $business = Business::where('chef_id',auth('chef')->user()->id)->first();       
        $cuisines = Cuisine::where('status','A')->pluck('name', 'id');
        if($business){$selCuisines =  explode (",", $business->cuisine);}else{$selCuisines='';}        
        $banking = Banking::where('chef_id',auth('chef')->user()->id)->first();
        $countries = Countries::pluck('name', 'id');
        if($basicInfo->country_id==142){
             $stateList = States::where('id',2437)->pluck('name', 'id');
        }else{
            $stateList = States::where('country_id', $basicInfo->country_id)->pluck('name', 'id');
        }

        $cityList = Cities::where('state_id', $location->state_id)->pluck('name', 'id');
        $pageData = [
                    'basicInfo'=>$basicInfo,
                    'location'=>$location,
                    'tax'=>$tax,
                    'business'=>$business,
                    'banking'=>$banking,
                    'countries'=>$countries,
                    'states'=>$stateList,
                    'cities'=>$cityList,
                    'cuisines'=>$cuisines,
                    'selCuisines'=>$selCuisines
                    ];
        return view('frontend.chef-dashboard.profile.profile',$pageData);
        }
    public function updateChefBasicInfo(Request $request){
        DB::beginTransaction();
        Helper::myLog('Chef basic info update : start');
        try {

            $email = $request->email;            
            $mobile = $request->mobile;
            $id = $request->id; 
            $checkEmail = Users::where('email', $email)->where('id', '!=', $id)->count();
                    
            if ($checkEmail > 0) {
                Helper::myLog('Chef basic info update : email is exists');
                return response()->json(['status' => 409, 'message' => __('validation.email-exists')]);
            }  else {
                $firstName = $request->first_name;
                $lastName = $request->last_name;
                $updateData = [
                    'display_name' => $firstName . " " . $lastName,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'mobile' => $mobile                                     
                ];
                $password = $request->password;
                if ($password) {
                    $updateData['password'] = Hash::make($password);
                }
                
                if ($file = $request->file('profile')) {
                    
                        $extension = $file->getClientOriginalExtension();
                        $fileName = rand(11111, 99999) . '.' . $extension;
                        $file->move(base_path() . '/public/frontend/images/users/', $fileName);
                        $updateData['profile'] = $fileName;
                       
                   
                }else{

                    $updateData['profile'] = $request->profile_avtr;
                    
                }
               
                if ($request->oldImage == 'image-1.png' || $request->oldImage == 'image-2.png' || $request->oldImage == 'image-3.png'|| $request->oldImage == 'image-4.png'|| $request->oldImage == 'image-5.png'||$request->oldImage == 'image-6.png'||$request->oldImage == 'image-7.png' || $request->oldImage == 'image-8.png' || $request->oldImage == 'image-9.png') {
                }else{
                    $destinationPath = base_path() . '/public/frontend/images/users/' . $request->oldImage;
                    File::delete($destinationPath); // remove oldfile
                }
                Users::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('Chef basic info update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => __('validation.update')]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef basic info update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.nupdate')]);
        }
    }

    public function changePassword(Request $request){
        DB::beginTransaction();
        Helper::myLog('Chef password update : start');
        try {

            $email = $request->email;
            $old_password = $request->old_password;
            $password = $request->password;            
            $user = Users::select('password')->where('email', $email)->first();                                  
            if (!Hash::check($old_password, $user->password)) { 
                Helper::myLog('Chef password update : Old password is not match');
                return response()->json(['status' => 409, 'message' => __('validation.oldpass-notmatch')]);
            } else {                
                if ($password) {
                    $updateData['password'] = Hash::make($password);
                }
                Users::where('email', $email)->update($updateData);
                DB::commit();
                Helper::myLog('Chef password update : finish');
                return response()->json(['status' => 200, 'message' => __('validation.password-update')]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef password update : exception');
            Helper::myLog($exception);
            return response()->json(['status' => 500, 'message' => __('validation.password-not-update')]);
        }
    }
    public function updateChefLocation(Request $request){
        DB::beginTransaction();
        Helper::myLog('Chef location update : start');
        try {
                $updateData = [
                    'address' => $request->address,
                    'state_id' => $request->state,
                    'city_id' => $request->city,
                    'zip_code' => $request->zip_code                                                        
                ];                               
                Location::where('chef_id', $request->id)->update($updateData);
                DB::commit();
                Helper::myLog('Chef location update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => __('validation.update')]);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef location update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.nupdate')]);
        }
    }

    public function updateChefBusiness(Request $request){
        DB::beginTransaction();
        Helper::myLog('Chef business update : start');
        try {
                $cuisines = implode(',',$request->cuisines);                
                
                $count = Business::where('chef_id', $request->id)->count();
                if($count>0){
                    $updateData = [
                        'business_name' => $request->business_nm,
                        'cuisine' => $cuisines,
                        'description' => $request->description,
                        'messaging' =>$request->messaging=='on' ? '1':'0',                                     
                    ]; 
                    Business::where('chef_id', $request->id)->update($updateData);
                }else{
                    $insertData = [
                        'chef_id'=>$request->id,
                        'business_name' => $request->business_nm,
                        'cuisine' => $cuisines,
                        'description' => $request->description,
                        'messaging' =>$request->messaging=='on' ? '1':'0',                                     
                    ];
                    Business::create($insertData);
                }
                DB::commit();
                Helper::myLog('Chef business update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' =>  __('validation.update')]);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef business update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' =>  __('validation.nupdate')]);
        }
    }

    public function updateChefTax(Request $request){
        DB::beginTransaction();
        Helper::myLog('Chef tax update : start');
        try {
          
                $taxDetails=Tax::where('chef_id', $request->id)->count(); 
                $fileName='';
                if($taxDetails>0){  
                    if($request->country_id==142)
                    {

                        if ($file = $request->file('uploadid')) {
                        $extension = $file->getClientOriginalExtension();
                        $fileName = rand(11111, 99999) . '.' . $extension;
                        $file->move(base_path() . '/public/frontend/images/users/', $fileName);
                            if ($request->oldImage != 'default.png') {
                                $destinationPath = base_path() . '/public/frontend/images/users/' . $request->oldImage;
                                File::delete($destinationPath); // remove oldfile
                            }
                        }

                        $updateData = [
                        
                        'rfc'=> $request->rfc,  
                        'upload_id_proof'=>$fileName                            
                    ]; 
                    }else{

                        $updateData = [
                        'federal_tax_id' => $request->fed_tax,
                        'social' => $request->social,   
                                                 
                    ]; 
                    }
                   
                    Tax::where('chef_id', $request->id)->update($updateData);
                }else{
                        if($request->country_id==142){
                            $insertData = [ 
                                'chef_id'=> $request->id,                  
                                'rfc'=> $request->rfc,  
                                'upload_id_proof'=>$fileName                                                       
                                ]; 
                            }
                            else{
                                $insertData = [ 
                                'chef_id'=> $request->id,                  
                                'federal_tax_id' => $request->fed_tax,
                                'social' => $request->social,
                                ]; 
                            }
                    Tax::create($insertData);
                }
                DB::commit();
                Helper::myLog('Chef tax update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' =>  __('validation.update')]);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef tax update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' =>  __('validation.nupdate')]);
        }
    }
    
    public function reviewRatingView(){
        $review = ReviewRating::leftjoin('users','review_rating.cust_id','users.id')
        ->where('chef_id',auth('chef')->user()->id)->where('review_rating.status',"2")
        ->orderBy('review_rating.updated_at', 'desc')
        ->select('review_rating.*','display_name as cust_id','users.profile')
        ->paginate(1); 

        $pageData = ['review' => $review];
        return view('frontend.chef-dashboard.review.review-rating',$pageData);    
    }
    public function completedOrder(){        
        $order = Order::where('chef_id',auth('chef')->user()->id)->where('status',"7")
                    ->orderBy('updated_at', 'desc')->get();
        $countryId=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $currency=[];
        if($countryId){
            $currency = Countries::where('id',$countryId->country_id)->first();
        }
        $pageData = ['order' => $order,'currency' => $currency];
        return view('frontend.chef-dashboard.order.order-completed',$pageData);
    }    
    public function custList()
    {
        $custList=Order::with('user')
        ->select(DB::raw('sum(chef_commission_fee) as sum'), 'cust_id', 'chef_commission_fee',
            DB::raw('max(completed_at_timezone) as last_order_date'))       
        ->where('chef_id',auth('chef')->user()->id)->where('status',7)->groupBy('cust_id')
        ->orderBy('completed_at_timezone','desc')->get();
        //dd($custList);


        $countryId=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $currency=[];
        if($countryId){
            $currency = Countries::where('id',$countryId->country_id)->first();
        }    
        $customers= Order::select('cust_id')->where('chef_id',auth('chef')->user()->id)->distinct('cust_id')->get();       
        $pageData=['custList' => $custList ,'currency'=>$currency ];
        return view('frontend.chef-dashboard.customer-list',$pageData);
    }
    public function gallery()
    {
        $gelleryData = ChefGelleryImage::where('chef_id',auth('chef')->user()->id)->get();
        $pageData = ['gelleryData'=>$gelleryData];
        return view('frontend.chef-dashboard.gallery.index',$pageData);
    }
    public function getCustList(){
        $chatUser=Message::with(['user' => function ($query) {
                    $query->select('id', 'display_name','profile');
                }])
                ->selectRaw("*,count(case when seen = '0' then 1 end) as newMsg")
                ->where('to_id',auth('chef')->user()->id)
                ->groupBy('from_id')
                ->get();

        $output = '';      
        if(!empty($chatUser)){

            foreach($chatUser as $row)
            {
                if($row->newMsg>0){
                    
                    $tot = "<span class='badge light text-white bg-warning'>".$row->newMsg."</span>";
                }else{
                    
                    $tot='';
                }
                $output .='<li class="dz-chat-user msg" data-id="'.Crypt::encrypt($row->from_id).'">
                        <div class="d-flex bd-highlight">
                        <div class="img_cont">
                        <img src="'.asset('public/frontend/images/users/'.$row->user->profile).'" class="rounded-circle user_img" alt=""/>
                        </div>
                        <div class="user_info">
                        <span id="name">'.$row->user->display_name.'</span>'.$tot.'

                        <p>Customer</p>
                        </div>
                        </div>
                        </li>';              

            }

        }

        $ticketUser = Ticket::leftjoin('users','ticket.user_id','users.id')
                    ->leftjoin('ticket_message','ticket.id','ticket_message.ticket_id')
                    ->where('ticket_message.to_id',auth('chef')->user()->id)
                    ->where('ticket.status','1') 
                    ->select('ticket.user_id','ticket_message.order_id','users.display_name','ticket_id',DB::raw("count(case when ticket_message.seen = '0' then 1 end) as newtTicketMsg"))
                    ->groupBy('ticket_message.order_id')                    
                    ->get();

        $ticket ='<li class="name-first-letter">ORDER</li>';
        if(!empty($ticketUser)){

            foreach($ticketUser as $t)
            {
                if($t->newtTicketMsg>0){
                    $tot = "<span class='badge light text-white bg-warning'>".$t->newtTicketMsg."</span>";
                }else{
                    $tot='';
                }
                 
                $name = explode(" ", $t->display_name);
                $sortnm = "";
                foreach ($name as $w) {
                    $sortnm .= $w[0];
                }                                       

                $ticket .='<li class="dz-chat-user tic" data-ticketid='.$t->ticket_id.' data-id='.Crypt::encrypt($t->user_id).' data-orderid='.$t->order_id.'>
                <div class="d-flex bd-highlight">
                <div class="img_cont warning">
                '.$sortnm.'</div>
                <div class="user_info">
                <span id="ticName">'.$t->display_name.'</span>'.$tot.'
                <p>Order : #'.$t->order_id.'</p>
                </div>
                </div>
                </li>';                                  
                                            

            }

        }
        return response()->json(['output'=>$output,'ticket'=>$ticket]);  
    }
    public function showMessage(Request $request)
    {
        
        $id= Crypt::decrypt($request->id);
        if(!empty($id))
        {
            
            $allMessages = null;
             
            $allMessages=Message::with('user')->where('from_id',auth('chef')->user()->id)
                    ->where('to_id',$id)
                    ->orWhere('from_id',$id)
                    ->where('to_id',auth('chef')->user()->id)
                    ->orderBy('created_at','asc')->get();
            
            $output = '';
            foreach($allMessages as $row)
            {
                if($row["from_id"] == auth('chef')->user()->id)
                {
                    $output .= '<div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                   '.$row->message.'
                                    <span class="msg_time_send">'.$row->created_at->diffForHumans().'</span>
                                </div>
                                <div class="img_cont_msg">

                                    <img src="'.asset("/public/frontend/images/users/".$row->user->profile).'" class="rounded-circle user_img_msg" alt=""/>
                                </div>
                            </div>';
                }
                else
                {
                    $output .= '<div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <img src="'.asset('/public/frontend/images/users/'.$row->user->profile).'" class="rounded-circle user_img_msg" alt=""/>
                                </div>
                                <div class="msg_cotainer">
                                    '.$row->message.'
                                    <span class="msg_time">'.$row->created_at->diffForHumans().'</span>
                                </div>
                            </div>';
                }
            }
            
            return response()->json($output);
            
            }
           
    }

    public function sendMessage(Request $request){

        if(request()->ajax()){
            DB::beginTransaction();
            Helper::myLog('Send message to customer Store : start');
            try {
                $to_id=Crypt::decrypt($request->to_id);
                $insertData = [
                    'from_id'=>auth('chef')->user()->id,
                    'to_id'=>$to_id,
                    'message'=>$request->message,
                    'seen'=>'0',
                ];

                $msg=Message::create($insertData);

                $output = '';
                if(!empty($msg))
                {
                    $output .= '<div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                   '.$msg->message.'
                                    <span class="msg_time_send">'.$msg->created_at->diffForHumans().'</span>
                                </div>
                                <div class="img_cont_msg">
                                    <img src="'.asset('/public/frontend/images/users/'.auth('chef')->user()->profile).'" class="rounded-circle user_img_msg" alt=""/>
                                    
                                </div>
                            </div>';
                }

                DB::commit();
                Helper::myLog('Send message to customer Store : finish');
                return response()->json(['status' => 200,'message' =>  __('validation.save'),'output'=>$output]);

            } catch (\Exception $exception) {
                DB::rollBack();
                Helper::myLog('Send message to customer Store : exception');
                Helper::myLog($exception);
                return response()->json(['status' => 500, 'message' =>  __('validation.nsave')]);
            }
        }
    }
    public function showTicket(Request $request)
    {
        
        $id= Crypt::decrypt($request->id);
        $order_id=$request->order_id;

        if(!empty($id))
        {
            
            $allMessages = null;
             
            $allMessages=TicketMessage::where('from_id',auth('chef')->user()->id)
                    ->where('to_id',$id) 
                    ->where('order_id',$order_id)                   
                    ->orWhere('from_id',$id)
                    ->where('to_id',auth('chef')->user()->id)
                    ->where('order_id',$order_id)
                    ->orderBy('created_at','asc')->get();
                    
            
            $output = '';
            foreach($allMessages as $row)
            {
                if($row["from_id"] == auth('chef')->user()->id)
                {
                    $output .= '<div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                   '.$row->message.'
                                    <span class="msg_time_send">'.$row->created_at->diffForHumans().'</span>
                                </div>
                                <div class="img_cont_msg">

                                    <img src="'.asset("/public/frontend/images/users/".$row->user->profile).'" class="rounded-circle user_img_msg" alt=""/>
                                </div>
                            </div>';
                }
                else
                {
                    $output .= '<div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <img src="'.asset('/public/frontend/images/users/'.$row->user->profile).'" class="rounded-circle user_img_msg" alt=""/>
                                </div>
                                <div class="msg_cotainer">
                                    '.$row->message.'
                                    <span class="msg_time">'.$row->created_at->diffForHumans().'</span>
                                </div>
                            </div>';
                }
            }
            
            return response()->json($output);
            
            }
           
    }
    public function sendTicketMessage(Request $request){
        if(request()->ajax()){
            DB::beginTransaction();
            Helper::myLog('Send message to customer Store : start');
            try {
                $id=Crypt::decrypt($request->to_id);
                $order_id=$request->order_id;
                $ticket=TicketMessage::select('ticket_id')->where('from_id',$id)
                                    ->where('to_id',auth('chef')->user()->id)
                                    ->where('order_id',$order_id)->first();

                $insertData = [
                    'ticket_id'=>$ticket->ticket_id,
                    'from_id'=>auth('chef')->user()->id,
                    'to_id'=>$id,
                    'message'=>$request->message,
                    'order_id'=>$order_id,
                    'seen'=>'0',
                ];
                $msg=TicketMessage::create($insertData);

                $output = '';
                if(!empty($msg))
                {  
                    $output .= '<div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                   '.$msg->message.'
                                    <span class="msg_time_send">'.$msg->created_at->diffForHumans().'</span>
                                </div>
                                <div class="img_cont_msg">
                                    <img src="'.asset('/public/frontend/images/users/'.auth('chef')->user()->profile).'" class="rounded-circle user_img_msg" alt=""/>
                                    
                                </div>
                            </div>';
                }

                DB::commit();
                Helper::myLog('Send message to customer Store : finish');
                return response()->json(['status' => 200,'message' =>  __('validation.save'),'output'=>$output]);

            } catch (\Exception $exception) {
                DB::rollBack();
                Helper::myLog('Send message to customer Store : exception');
                Helper::myLog($exception);
                return response()->json(['status' => 500, 'message' =>  __('validation.nsave')]);
            }
        }
    } 
    public function seenMessage(Request $request)
    {
      
        $from_id= Crypt::decrypt($request->id);
       
        if(!empty($from_id))
        {
            Message::where('from_id',$from_id)->update(['seen'=>'1']);
        }
    }
    public function seenTicket(Request $request)
    {        
        $from_id= Crypt::decrypt($request->id);
        $order_id=$request->order_id;
        if(!empty($from_id))
        {
            TicketMessage::where('from_id',$from_id)->where('order_id',$order_id)->update(['seen'=>'1']);
        }
    }
     public function ticketClose(Request $request){
        try {
          
            $ticket = Ticket::find($request->ticket_id);
            $ticket->status = '0';
            $status=$ticket->save();            
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
