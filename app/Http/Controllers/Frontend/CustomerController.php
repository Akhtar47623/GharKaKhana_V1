<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Model\Users;
use App\Model\Message;
use App\Model\TicketMessage;
use App\Model\Ticket;
use App\Model\Order;
use App\Model\Helper;
use App\Model\Countries;
use App\Model\TicketCategory;
use App\Model\Business;
use App\Model\CustLocation;
use Cookie;
use Toastr;
use Datatables;
Use \Carbon\Carbon;
use Validator;
use Redirect;
use Session;
use Config;
use Auth;
use File;
use DB;
class CustomerController extends Controller
{
    public function customerProfile(){
        $custProfile = Users::with('location')->where('id',auth('front')->user()->id)->first();
        $pageData = ['custProfile'=>$custProfile];
        return view('frontend.profile.profile',$pageData);
    }

    //Customer Profile
    public function editProfile(){
        $custProfile = Users::with('location')->where('id',auth('front')->user()->id)->first();
        $pageData = ['custProfile'=>$custProfile];
        return view('frontend.profile.edit-profile',$pageData);
    }
    public function updateProfile(Request $request){
        DB::beginTransaction();
        Helper::myLog('Customer profile update : start');
        try {                
            $firstName = $request->first_name;
            $lastName = $request->last_name;
            $mobile = $request->mobile;

            $updateData = [
                'display_name' => $firstName . " " . $lastName,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'mobile' => $mobile                
            ];
            
            if ($file = $request->file('profile')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $file->move(base_path() . '/public/frontend/images/users/', $fileName);
                $updateData['profile'] = $fileName;
                if ($request->oldImage != 'default.png') {
                    $destinationPath = base_path() . '/public/frontend/images/users/' . $request->oldImage;
                    File::delete($destinationPath); 
                }
            }
            
            Users::where('uuid', $request->uuid)->update($updateData);
            DB::commit();
            Helper::myLog('Customer profile update : finish');
            Toastr::success(Config::get('constants.message.edit'), 'Update');
            return response()->json(['status' => 200, 'message' => __('validation.profile-update')]);
            
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Customer profile update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.profile-not-update')]);
        }
    }
    public function updatePassword(Request $request){

        DB::beginTransaction();
        Helper::myLog('Customer change password: start');
        try {                
            $email = $request->email;
            $uuid = $request->uuid;
            $checkEmail = Users::where('email', $email)->where('type','customer')->count();
            
            if ($checkEmail==0) {
                Helper::myLog('Customer change password : email does not exists');
                return response()->json(['status' => 409, 'message' => __('validation.email-not-exists')]);
            } else {
                $updateData = [
                    'password' => Hash::make($request->password)                                  
                ];               
                        
                Users::where('uuid', $request->uuid)->update($updateData);
                DB::commit();
                Helper::myLog('Customer change password : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => __('validation.success-password')]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Customer change location : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.unsuccess-password')]);
        }
    }
    public function updateLocation(Request $request){
        DB::beginTransaction();
        Helper::myLog('Customer change location: start');
        try { 

            $updateLocData = [                    
                'lat' => $request->cust_lat,
                'log' => $request->cust_log,
                'country' => $request->cust_country,
                'state' => $request->cust_state,
                'city' => $request->cust_city,
                'address' => $request->locationadd                                                       
            ];  

            $country = Countries::select('id')->where('name',$request->cust_country)->first();

            $updateUserData = [
                'country_id' => $country->id,
            ];

            $user=Users::where('id', $request->id)->update($updateUserData);
            $loc=CustLocation::where('cust_id',$request->id)->update($updateLocData);
            if($user && $loc){
                $minutes = 525600;           
                Cookie::queue(Cookie::make('location', serialize($updateLocData), $minutes));
                DB::commit();
                Helper::myLog('Customer change location : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => __('validation.location-changed')]);
            }
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Customer change location : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => __('validation.location-not-changed')]);
        }
    }

    //End Customer Profile
    public function custOrders(Request $request){

        
        $order = Order::with('orderItems','chefBusiness','orderMessages')
                        ->where('cust_id',auth('front')->user()->id)
                        ->whereIn('status',[2,4,5,6])->orderBy('delivery_date','asc')
                        ->get();
        $completedOrder = Order::with('invoice')->where('cust_id',auth('front')->user()->id)->where('status',7);
        if($request->has('text') && $request->text!=''){
            $text = $request->text;
            $completedOrder = $completedOrder->where('id',$text);
        } 
        $completedOrder = $completedOrder->orderBy('id','DESC')->get(); 
        
        $cancelOrder = Order::where('cust_id',auth('front')->user()->id)->where('status',3)->orderBy('id','DESC')->get();
        $user = Users::select('country_id')->where('id',auth('front')->user()->id)->first();

        $currency = Countries::where('id',$user->country_id)->first();
        $ticketCategory=TicketCategory::where('parent_id','1')->where('status','1')->get();
        
        $pageData = [
                        'order' => $order,
                        'completedOrder' => $completedOrder,
                        'cancelOrder' => $cancelOrder,
                        'currency' => $currency,
                        'ticketCategory'=>$ticketCategory,
                        
                    ];
        
        return view('frontend.order.your-orders',$pageData);
    }
    
    public function getOrderMessages(Request $request){             
        $allMessages = null; 
         $chefId= Crypt::decrypt($request->chef_id);
        TicketMessage::where('order_id',$request->order_id)->update(['seen'=>'1']);            
        $allMessages=TicketMessage::where('from_id',auth('front')->user()->id)
                    ->where('to_id',$chefId)
                    ->where('order_id',$request->order_id)
                    ->orWhere('from_id',$chefId)
                    ->where('to_id',auth('front')->user()->id)
                    ->where('order_id',$request->order_id)->orderBy('created_at','asc')->get();

        $chef=Users::select('display_name','profile')->where('id',$chefId)->first();
        if(!empty($chef)){
            $display_name = $chef['display_name'];
            $profile = "public/frontend/images/users/".$chef['profile'];
        }else{
            $display_name = 'Customer Support';
            $profile = "public/frontend/images/support.jpg";
        }
        
        $output = '';

        foreach($allMessages as $row)
        {
            if($row["from_id"] == auth('front')->user()->id)
            {
                $output .= '<div class="message message-personal new">
                        <figure class="avatar">
                        <img src="'.asset('/public/frontend/images/users/'.auth('front')->user()->profile).'">
                        </figure>'.$row->message.'
                        <div class="timestamp">14:7</div>
                        </div>';
            }
            else
            {
                $output .= '<div class="message new">
                    <figure class="avatar">
                    <img src="'.$profile.'">
                    </figure>'.$row->message.'
                    <div class="timestamp">14:7</div>
                    </div>';
            }              

        }        
        return response()->json(['output'=>$output,'display_name'=>$display_name,'profile'=>$profile]);
    }
    public function addOrderMessage(Request $request){

        if(request()->ajax()){
            DB::beginTransaction();
            Helper::myLog('Customer chat message Store : start');
            try {        
                $order=Order::where('id',$request->order_id)->first();
                $check=Business::where('chef_id',$order->chef_id)
                        ->where('messaging','1')->count();
                        if($check > 0)
                        {
                            $ticket=TicketMessage::where('from_id',auth('front')->user()->id)
                            ->where('order_id',$request->order_id)
                            ->where('to_id',$order->chef_id)
                            ->select('ticket_id')->first(); 

                            $insertData = [ 
                            'ticket_id'=>$ticket->ticket_id,
                            'from_id'=>auth('front')->user()->id,
                            'to_id'=>$order->chef_id,
                            'message'=>$request->message,
                            'order_id'=>$request->order_id
                            ];
                        
                        }
                        else{

                            $ticket=TicketMessage::where('from_id',auth('front')->user()->id)
                            ->where('order_id',$request->order_id)
                            ->Where('to_id','0')
                            ->select('ticket_id')->first();
                                $insertData = [ 
                                'ticket_id'=>$ticket->ticket_id,
                                'from_id'=>auth('front')->user()->id,
                                'to_id'=>'0',
                                'message'=>$request->message,
                                'order_id'=>$request->order_id
                                ];
                        }                
               
                $new=TicketMessage::create($insertData);
                DB::commit();            
                Helper::myLog('Customer chat message store : finish');
                return response()->json(['status' => 200,'message' => __('validation.save')]);
               
            } catch (\Exception $exception) {
                DB::rollBack();
                Helper::myLog('Customer chat message store : exception');
                Helper::myLog($exception);
                return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
            }
        }
    }
    public function responderMessage(Request $request){

        if(request()->ajax()){
            DB::beginTransaction();
            Helper::myLog('Responder chat message Store : start');
            try {   

                    $order=Order::where('id',$request->order_id)->first();

                    $check=Business::where('chef_id',$order->chef_id)
                        ->where('messaging','1')->count();
                    if($check > 0)
                    {
                            $insertData = [ 
                            'uuid'=> Helper::getUuid(),
                            'user_id'=>auth('front')->user()->id,
                            'order_id'=>$request->order_id,
                            'to'=>'1',
                            'category_id'=>$request->cat_id,
                            'priority'=>'3',
                        ];
                    }
                    else{

                        $insertData = [ 
                            'uuid'=> Helper::getUuid(),
                            'user_id'=>auth('front')->user()->id,
                            'order_id'=>$request->order_id,
                            'to'=>'0',
                            'category_id'=>$request->cat_id,
                            'priority'=>'3',
                        ];

                    }
            
                $new=Ticket::create($insertData);
              
                if($check > 0)
                {
                    $insertMsg = [ 
                    'ticket_id'=>$new->id,
                    'from_id'=>auth('front')->user()->id,
                    'to_id'=>$order->chef_id,
                    'message'=>$request->message,
                    'order_id'=>$request->order_id,

                    ];
                }
                else{

                     $insertMsg = [ 
                    'ticket_id'=>$new->id,
                    'from_id'=>auth('front')->user()->id,
                    'to_id'=>'0',
                    'message'=>$request->message,
                    'order_id'=>$request->order_id,

                    ];

                }
                TicketMessage::create($insertMsg);
                DB::commit();            
                Helper::myLog('Responder chat message store : finish');
                return response()->json(['status' => 200,'message' => __('validation.save')]);
               
            } catch (\Exception $exception) {
                DB::rollBack();
                Helper::myLog('Responder chat message store : exception');
                Helper::myLog($exception);
                return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
            }
        }
    }
    public function addCustMessage(Request $request){

        if(request()->ajax()){
            $profile_id=Crypt::decrypt($request->profile_id);
            $chef_id=Users::select('id')->where('profile_id',$profile_id)->first();
            DB::beginTransaction();
            Helper::myLog('Customer message Store : start');
            try {            
                
                $insertData = [ 
                    'from_id'=>auth('front')->user()->id,
                    'to_id'=>$chef_id->id,
                    'message'=>$request->message                    
                ];
                
                Message::create($insertData);               
                DB::commit();            
                Helper::myLog('Customer message store : finish');
                return response()->json(['status' => 200, 'message' => __('validation.msg-sent')]);
               
            } catch (\Exception $exception) {
                DB::rollBack();
                Helper::myLog('Customer message store : exception');
                Helper::myLog($exception);
                return response()->json(['status' => 500, 'message' => __('validation.msg-not-sent')]);
            }
        }
    }
    public function getChefList(Request $request){
        
      $messageUser = Message::with('user:id,display_name,profile')
                ->selectRaw("*,count(case when seen = '0' then 1 end) as totmsg")
                ->where('to_id',auth('front')->user()->id)                
                ->groupBy('from_id')->get();
                
        $output = '';      
        if(!empty($messageUser)){

            foreach($messageUser as $row)
            {
                if($row->totmsg>0){
                    $tot = "<span>".$row->totmsg."</span>";
                }else{
                    $tot='';
                }
                $output .='<li data-attr='.Crypt::encrypt($row->from_id).'>
                <div class="messages-list-box">
                <div class="messages-img">
                <img src="'.asset('/public/frontend/images/users/'.$row->user->profile).'" class="rounded-circle user_img_msg" alt=""/>
                </div>
                <div class="messages-list-content">
                 <h3>'.$row->user->display_name.'</h3>'.$tot.'
                <p>Last Message</p>
                </div>
                </div>
                </li>  ';

            }

        }
                                 
     $ticketUser = TicketMessage::with('user:id,display_name,profile')
                        ->where('to_id',auth('front')->user()->id)
                        ->selectRaw("*,count(case when seen = '0' then 1 end) as totmsg")
                        ->groupBy('order_id')
                        ->get();
                    
        $ticket ='';

        if(!empty($ticketUser)){

            foreach($ticketUser as $row)
            {                
                if($row->totmsg>0){
                    $tot = "<span>".$row->totmsg."</span>";
                }else{
                    $tot='';
                }
                $ticket .='<li data-attr='.Crypt::encrypt($row->from_id).' data-orderid='.$row->order_id.' data-ticketid='.$row->ticket_id.'>
                <div class="messages-list-box">
                <div class="messages-img">
                <img src="'.asset('/public/frontend/images/users/'.$row->user->profile).'" class="rounded-circle user_img_msg" alt=""/>
                </div>
                <div class="messages-list-content">
                <h3>'.$row->user->display_name.'</h3>'.$tot.'
                <p>Order ID#'.$row->order_id.'</p>
                </div>
                </div>
                </li>  ';

            }

        }  
       
        return response()->json(['output'=>$output,'ticket'=>$ticket]);  
                           
        
    }

    public function getMessages(Request $request){

        $id= Crypt::decrypt($request->id);
        $allMessages = null;
             
        $allMessages=Message::with('chef')->where('from_id',auth('front')->user()->id)
                    ->where('to_id',$id)
                    ->orWhere('from_id',$id)
                    ->where('to_id',auth('front')->user()->id)
                    ->orderBy('created_at','asc')->get();
      
        Message::where('to_id',auth('front')->user()->id)->where('from_id',$id)->update(['seen'=>'1']);         
        $output = '';

        foreach($allMessages as $row)
        {

            if($row["from_id"] == auth('front')->user()->id)
            {
                $output .= '<div class="message new right">
                            <figure class="avatar">
                            <img src="'.asset('/public/frontend/images/users/'.$row->chef->profile).'" class="rounded-circle user_img_msg" alt=""/>
                            </figure>'.$row->message.'
                            <div class="timestamp">'.$row->created_at->diffForHumans().'</div>                                     
                            </div> ';
            }
            else
            {
                $output .= '<div class="message new">
                            <figure class="avatar">
                            <img src="'.asset('/public/frontend/images/users/'.$row->chef->profile).'" class="rounded-circle user_img_msg" alt=""/>
                            </figure>'.$row->message.'
                            <div class="timestamp">'.$row->created_at->diffForHumans().'</div>                                     
                            </div>';
            }              

        }
        return response()->json($output);
    }
    public function addMessage(Request $request){

        if(request()->ajax()){
            DB::beginTransaction();
            Helper::myLog('Customer chat message Store : start');
            try {            

                $insertData = [ 
                    'from_id'=>auth('front')->user()->id,
                    'to_id'=>Crypt::decrypt($request->id),
                    'message'=>$request->message,
                   
                ];
                Message::create($insertData); 
                DB::commit();            
                Helper::myLog('Customer chat message store : finish');
                return response()->json(['status' => 200,'message' => __('validation.save')]);
               
            } catch (\Exception $exception) {
                DB::rollBack();
                Helper::myLog('Customer chat message store : exception');
                Helper::myLog($exception);
                return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
            }
        }
    }
    public function getTicketMessages(Request $request){

        $id= Crypt::decrypt($request->id);
        $allMessages = null;
        $allMessages=TicketMessage::with('chef')->where('from_id',auth('front')->user()->id)
                    ->where('to_id',$id)
                    ->where('order_id',$request->order_id)
                    ->orWhere('from_id',$id)
                    ->where('to_id',auth('front')->user()->id)
                    ->where('order_id',$request->order_id)
                    ->orderBy('created_at','asc')->get();
                  
        $output = '';
        TicketMessage::where('from_id',$id)
                    ->where('to_id',auth('front')->user()->id)
                    ->where('order_id',$request->order_id)
                    ->update(['seen'=>'1']);
        foreach($allMessages as $row)
        {
            if($row["from_id"] == auth('front')->user()->id)
            {
                $output .= '<div class="message new right">
                            <figure class="avatar">
                            <img src="'.asset('/public/frontend/images/users/'.$row->chef->profile).'" class="rounded-circle user_img_msg" alt=""/>
                            </figure>'.$row->message.'
                            <div class="timestamp">'.$row->created_at->diffForHumans().'</div>                                     
                            </div> ';
            }
            else
            {
                $output .= '<div class="message new">
                            <figure class="avatar">
                            <img src="'.asset('/public/frontend/images/users/'.$row->chef->profile).'" class="rounded-circle user_img_msg" alt=""/>
                            </figure>'.$row->message.'
                            <div class="timestamp">'.$row->created_at->diffForHumans().'</div>                                     
                            </div>';
            }              

        }
        return response()->json($output);
    }
     public function addTicketMessage(Request $request){

        if(request()->ajax()){
            DB::beginTransaction();
            Helper::myLog('Customer chat message Store : start');
            try {        
           
                  $insertData = [ 
                            'ticket_id'=>$request->ticket_id,
                            'from_id'=>auth('front')->user()->id,
                            'to_id'=>Crypt::decrypt($request->to_id),
                            'message'=>$request->message,
                            'order_id'=>$request->order_id
                            ];
                        
                TicketMessage::create($insertData); 
                DB::commit();            
                Helper::myLog('Customer chat message store : finish');
                return response()->json(['status' => 200,'message' => __('validation.save')]);
               
            } catch (\Exception $exception) {
                DB::rollBack();
                Helper::myLog('Customer chat message store : exception');
                Helper::myLog($exception);
                return response()->json(['status' => 500, 'message' => __('validation.nsave')]);
            }
        }
    }

  
}
