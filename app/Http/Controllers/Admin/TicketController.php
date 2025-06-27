<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\Ticket;
use App\Model\TicketMessage;
use App\Model\Business;
use App\Model\Order;
use App\Model\Users;
use App\Model\Countries;
use App\Model\TicketCategory;
use Config;
use DB;
use Toastr;
use App\Model\Helper;
use Session;

class TicketController extends Controller
{
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_ticket');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $categories=TicketCategory::where('status','1')->get();
        $ticket = Ticket::with('category','messages','user','order')->get();
        $pageData = ['title' => Config::get('constants.title.ticket'),'ticket'=>$ticket,'categories'=>$categories];
        return view('admin.ticket.index',$pageData);
    }
    public function destroy($id)
    {
       DB::beginTransaction();
        Helper::myLog('State Delete : start');
        try {

            Ticket::where('id', $id)->delete();
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
    public function changeStatus(Request $request){
        try {
            $ticket = Ticket::find($request->id);
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
    public function seenMessage(Request $request)
    {
        
        $ticket_id=$request->id;
        if(!empty($ticket_id))
        {
            $allMessages=null;
            TicketMessage::where('ticket_id',$ticket_id)->update(['seen'=>'1']);
            $allMessages=TicketMessage::with('user')->where('ticket_id',$ticket_id)->get();
            $checkSupport=Ticket::select('to')->where('id',$ticket_id)->first()->toArray();
            if(!empty($checkSupport) && $checkSupport['to']==0){
                $support=0;
            }
            else{
                $support=1;
            }
            $output = '';
            foreach($allMessages as $row)
            {
                if($row["from_id"] == auth('admin')->user()->id)
                {
                    $output .= '<div class="direct-chat-msg right">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name pull-right">'.Session::get("name").'</span>
                                        <span class="direct-chat-timestamp pull-left">'.date('M d, Y  h:i:sa',strtotime($row->created_at)).'</span>
                                    </div>
                                    <img class="direct-chat-img" src="'.Session::get ('profile').'" alt="message user image">
                                    <div class="direct-chat-text">
                                         '.$row->message.'
                                    </div>
                                </div>';
                }
                else
                {   

                    $output .= '<div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-left">'.$row->user->display_name.'</span>
                                    <span class="direct-chat-timestamp pull-right">'.date('M d, Y h:i:sa',strtotime($row->created_at)).'</span>
                                </div>
                                <img class="direct-chat-img" src="'.asset('public/frontend/images/users/'.$row->user->profile).'" alt="message user image">
                                <div class="direct-chat-text">
                                   '.$row->message.'
                                </div>
                                </div>';
                }  
            }
            
            return response()->json(['output'=>$output,'support'=>$support]);
            
            }
    }
    public function sendMessage(Request $request){

        if(request()->ajax()){
            DB::beginTransaction();
            Helper::myLog('Send Message Store : start');
            try {            
                $ticket_id=$request->ticket_id;
                $ticket=Ticket::where('id',$ticket_id)->first();
                
                $insertData = [ 
                    'ticket_id'=>$ticket_id,
                    'from_id'=>auth('admin')->user()->id,
                    'to_id'=>$ticket->user_id,
                    'message'=>$request->message,
                    'seen'=>'1',
                ];
                $msg=TicketMessage::create($insertData);
                $output = '';
                if(!empty($msg))
                {
                    $output .= '<div class="direct-chat-msg right">
                    <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">'.Session::get("name").'</span>
                    <span class="direct-chat-timestamp pull-left">'.date('M d, Y  h:i:sa',strtotime($msg->created_at)).'</span>
                    </div>
                    <img class="direct-chat-img" src="'.Session::get ('profile').'" alt="message user image">
                    <div class="direct-chat-text">
                    '.$msg->message.'
                    </div>
                    </div>';
                }

                DB::commit();            
                Helper::myLog('Send Message store : finish');
                return response()->json(['status' => 200,'message' => 'This information has been saved!','output'=>$output]);
               
            } catch (\Exception $exception) {
                DB::rollBack();
                Helper::myLog('Send Message store : exception');
                Helper::myLog($exception);
                return response()->json(['status' => 500, 'message' => 'This information has not been saved!']);
            }
        }
    }
    public function orderDetail($orderid)
    {       

        $orderList=Order::with('orderItems','user','chef')
        ->where('id',$orderid)
        ->whereIn('status',[2,4,5,6,7])
        ->first();

        $country = Users::select('country_id')->where('id',auth('admin')->user()->id)->first();
            $currency = Countries::where('id',$country->country_id)->first();
        $pageData = ['title' => Config::get('constants.title.order_detail'),'orderList' => $orderList, 'currency'=>$currency];
        return view('admin.ticket.order-detail',$pageData);
    }
      
}
