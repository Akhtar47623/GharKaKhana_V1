<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Model\Helper;
use App\Model\Order;
use App\Model\Countries;
use App\Model\Menu;
use App\Model\ReviewRating;
use App\Model\ThirdPartyDetail;
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
use PDF;

class OrderController extends Controller
{
	public function orderView(){
        $country = Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $currency = Countries::where('id',$country->country_id)->first();

        //new dashboard
        $orderList=Order::with('user')
        ->where('chef_id',auth('chef')->user()->id)
        ->whereIn('status',[2,4,5,6,7])
        ->get();

         $countryId=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $currency=[];
        if($countryId){
            $currency = Countries::where('id',$countryId->country_id)->first();
        }
        $pageData = [
                        'currency' => $currency,
                        'orderList'=> $orderList,
                        'currency'=> $currency
                    ];
        return view('frontend.chef-dashboard.order.order-queue',$pageData);
    }
    public function changeStatus(Request $request){
        $status=$request->status;
        DB::beginTransaction();
        Helper::myLog('Order Status change : start');
        try {
            if($status=="accepted"){
                $orderUpdate = ['status'=>4,'accepted_at'=>now(),'accepted_at_timezone'=>$request->timezone];
            }elseif($status=="ready"){
                $orderUpdate = ['status'=>5,'ready_at'=>now(),'ready_at_timezone'=>$request->timezone];
            }elseif($status=='ready-for-delivery'){
                $orderUpdate = ['status'=>6,'delivery_at'=>now(),'delivery_at_timezone'=>$request->timezone];
            }elseif($status=='delivered'){
                $orderUpdate = ['status'=>7,'completed_at'=>now(),'completed_at_timezone'=>$request->timezone];
                $orderData=Order::where('id',$request->id)->first();

                $insertReviewRatingData=[
                    'uuid' => Helper::getUuid(),
                    'order_id' => $orderData->id,
                    'cust_id' => $orderData->cust_id,
                    'chef_id' => $orderData->chef_id,
                    'delivery_id' =>$orderData->delivery_company_id,
                    'pick_del_option' => $orderData->pick_del_option,
                    'date_of_order' => $orderData->delivery_date
                ];
                ReviewRating::create($insertReviewRatingData);
            }
            Order::where('id', $request->id)->update($orderUpdate);
            DB::commit();
            Helper::myLog('Order Status change : finish');
            return \Response::json(['status'=> Config::get('constants.status.success'), 'msg' => 'Order Accepted'],200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Order Status change : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $exception->getMessage()], 500);
        }
    }
    public function setFlag(Request $request){
        $id=$request->id;
        DB::beginTransaction();
        Helper::myLog('Order flag change : start');
        try {
            $updateData=['flag' => 1];
            Order::where('id', $id)->update($updateData);
            DB::commit();
            Helper::myLog('Order flag change : finish');
            return \Response::json(['status'=> Config::get('constants.status.success'), 'msg' => 'Order Highlighted'],200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Order flag change : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $exception->getMessage()], 500);
        }
    }
    public function generateLabelPDF($order_id)
    {
        if(!empty($order_id)){
            $order = Order::with('orderItems')
                        ->where('id',$order_id)->first();

            if(!empty($order)){
                foreach ($order->orderItems as $i) {
                   $menuId[]=$i->menu_id;

                }
                $menuData = Menu::select('label_photo')->whereIn('id',$menuId)->get();
                if(!empty($menuData)){
                    $data = ['menuData'=>$menuData];
                    $pdf = PDF::loadView('frontend.chef-dashboard.order.label-pdf', $data);
                    return $pdf->download('Label.pdf');

                }
            }
        }
    }
    public function generateOrderPDF($order_id)
    {
        if(!empty($order_id)){
            $order = Order::with('orderItems')
                        ->where('id',$order_id)->first();

            $country = Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
            $currency = Countries::where('id',$country->country_id)->first();
            $pageData = [
                        'order' => $order,
                        'currency' => $currency
                    ];
            $pdf = PDF::loadView('frontend.chef-dashboard.order.order-pdf', $pageData);

            return $pdf->stream('order.pdf');

        }
    }
    public function orderDetail($id)
    {
        $orderList=Order::with('orderItems','user')
        ->where('chef_id',auth('chef')->user()->id)
        ->where('id',$id)
        ->whereIn('status',[2,4,5,6,7])
        ->get();
        $deliveryDetail=ThirdPartyDetail::where('order_id',$id)->first();
        $country = Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $currency = Countries::where('id',$country->country_id)->first();
        $pageData=['orderList'=>$orderList,'deliveryDetail'=>$deliveryDetail,'currency'=>$currency];
        return view('frontend.chef-dashboard.order.order-detail',$pageData);

    }
}
