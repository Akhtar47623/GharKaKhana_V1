<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\CustLocation;
use App\Model\Users;
use App\Model\Countries;
use DB;
class ChefReportController extends Controller
{
    public function index()
    {
   	    $orderList = Order::with('orderItems','orderItemOptions')
                        ->where('chef_id',auth('chef')->user()->id)
                        ->where('status',7)->get();
        $countryId=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $currency=[];
        if($countryId){
            $currency = Countries::where('id',$countryId->country_id)->first();
        }  
        $pageData = ['orderList' => $orderList,'currency'=>$currency];
   		return view("frontend.chef-dashboard.report.index",$pageData);
    }
    public function export(Request $request)
    {	
        $headers = ['Content-type' => 'text/csv'];

        $callback = function() {
            $orderList = Order::with('orderItems','orderItemOptions')
            ->where('chef_id',auth('chef')->user()->id)
            ->where('status',7)->get();
            
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Order Id',
                'Completed Date',
                'Customer Name',
                'Delivery / Pickup',
                'Zip Code', 
                'Subtotal', 
                'Discount',
                'Refund',
                'Service Fee', 
                'Earning',
                'Delivery Fee',
                'Tip',
                'Payout',
                'Status',
                'Tax',
                'Payroll Status',
                'Payroll Date',
            ]); 

            foreach ($orderList as $ol){ 

                $row = [
                     $ol->id,
                     date('F d, Y',strtotime($ol->completed_at)),
                     $ol->user->first_name  .' '.$ol->user->last_name ,
                     $ol->pick_del_option==1?"Pickup":"Delivery",
                     '200909',
                     $ol->sub_total,
                     $ol->chef_discount,
                     '0',
                     $ol->service_fee,
                     $ol->sub_total - $ol->chef_discount-$ol->service_fee,
                     $ol->delivery_fee,
                     $ol->tip_fee,
                     $ol->tip_fee + $ol->sub_total - $ol->chef_discount - $ol->service_fee,
                     'Completed',
                     $ol->tax_fee,
                     'pending',
                     date('F d, Y',strtotime($ol->completed_at))
                ];  
                fputcsv($handle, $row);
            }
            fclose($handle);
        };
        $todayDate=date("Y-m-d");
        return response()->streamDownload($callback, 'chef_order_report_'.$todayDate.'.csv', $headers);
   }
}
