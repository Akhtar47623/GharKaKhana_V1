<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Model\Helper;
use App\Model\PickupDelivery;
use App\Model\PickupDetails;
use App\Model\DeliveryDetails;
use App\Model\States;
use App\Model\Cities;
use App\Model\Location;
use App\Model\Countries;
use App\Model\ThirdPartyDetail;
use App\Model\Order;
use Toastr;
use Datatables;
use Validator;
use Redirect;
use Session;
use Config;
use Auth;
use File;
use DB;


class PickupDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pickupDelivery = PickupDelivery::where('chef_id',auth('chef')->user()->id)->first();        
        $pageData = ['pickupDelivery'=>$pickupDelivery];
        return view('frontend.chef-dashboard.pickup-delivery.index',$pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        if($country->country_id == '142'){
            $states = States::where('country_id',$country->country_id)->where('id',2437)->pluck('name','id');
        }else{
            $states = States::where('country_id',$country->country_id)->pluck('name','id');
        }
        $currency=[];
        if($country){
            $currency = Countries::where('id',$country->country_id)->first();
        }        
        $pageData = ['states'=>$states,'currency'=>$currency];
        return view('frontend.chef-dashboard.pickup-delivery.create',$pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        Helper::myLog('Pickup and Delivery Store : start');
        try {            
            $options = $request->options;
            $check = PickupDelivery::where('chef_id',auth('chef')->user()->id)->count();
            if ($check > 0) {
                Helper::myLog('Pickup and Delivery : Pickup and Delivery details is exists');
                return response()->json(['status' => 409, 'message' => ' Pickup and delivery details is already exists!']);
            } else {     
                $insertData = [ 
                    'chef_id'=>auth('chef')->user()->id,
                    'uuid' => Helper::getUuid(),
                    'options'=> $request->options,
                    'delivery_by' => $request->delivery_by,              
                ];

                if($options==1){
                    $itemData=PickupDelivery::create($insertData);
                    
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
                    $itemData=PickupDelivery::create($insertData);
                    
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
                    $itemData=PickupDelivery::create($insertData);
                    foreach ($request->addmore as $key => $value) {
                        $insertPickupData = [
                            'pickup_delivery_id'=>$itemData->id, 
                            'from_miles'=>$value['min_miles'],
                            'to_miles' => $value['max_miles'],
                            'rate' => $value['min_miles_rate'],
                                        
                        ];
                        DeliveryDetails::create($insertPickupData);
                    }
                }
            }
            
            DB::commit();            
            Helper::myLog('Pickup and Delivery store : finish');
            Toastr::success(Config::get('constants.message.add'), 'Save');
            return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Pickup and Delivery store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been saved!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $pickupDeliveryData = PickupDelivery::where('uuid', $uuid)->first(); 
        $pickupDetailsData = PickupDetails::where('pickup_delivery_id',$pickupDeliveryData->id)->first();
        $deliveryDetailsData = DeliveryDetails::where('pickup_delivery_id',$pickupDeliveryData->id)->get();
        $count = DeliveryDetails::where('pickup_delivery_id',$pickupDeliveryData->id)->count();
        $country=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $states = States::where('country_id',$country->country_id)->pluck('name','id');
        if(!empty($pickupDetailsData)){        
        $cityList = Cities::select('name', 'id')->where('state_id', $pickupDetailsData->state_id)->orderBy('name', 'ASC')->get();
        }else{
            $cityList = [];
        } 
        $currency=[];
        if($country){
            $currency = Countries::where('id',$country->country_id)->first();
        }         
        $pageData = [
            'pickupDeliveryData' => $pickupDeliveryData,
            'pickupDetailsData' => $pickupDetailsData,
            'deliveryDetailsData' => $deliveryDetailsData,
            'states'=>$states,
            'cityList' => $cityList,
            'count' => $count,
            'currency' => $currency
        ];
        return view('frontend.chef-dashboard.pickup-delivery.edit',$pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        Helper::myLog('Pickup and Delivery update : start');
        try {
                
                $oldOptions = $request->options;
                $pickupDelivery=$request->pickup_delivery;                
                $updateData = [ 
                    'delivery_by' => $request->delivery_by,
                    'options'=>$request->pickup_delivery              
                ];
                PickupDelivery::where('id', $id)->update($updateData); 

                if($pickupDelivery==1){
                    
                    if($oldOptions==1 || $oldOptions==2){
                        $updatePickupData = [
                            'address'=>$request->address,
                            'state_id' => $request->state,
                            'city_id' => $request->city,
                            'zipcode' => $request->zipcode,
                            'mobile' => $request->mobile             
                        ];
                        PickupDetails::where('pickup_delivery_id', $id)->update($updatePickupData); 
                    }
                    if($oldOptions==2 || $oldOptions==3){
                        DeliveryDetails::where('pickup_delivery_id', $id)->delete();    
                    }
                }
                if($pickupDelivery==2){
                    
                    $count=PickupDetails::where('pickup_delivery_id', $id)->count();
                    if($count>0){
                        $updatePickupData = [
                            'address'=>$request->address,
                            'state_id' => $request->state,
                            'city_id' => $request->city,
                            'zipcode' => $request->zipcode,
                            'mobile' => $request->mobile,
                        ];
                        PickupDetails::where('pickup_delivery_id', $id)->update($updatePickupData);
                    }else{
                        $createPickupData = [
                            'pickup_delivery_id'=>$id,
                            'address'=>$request->address,
                            'state_id' => $request->state,
                            'city_id' => $request->city,
                            'zipcode' => $request->zipcode,
                            'mobile' => $request->mobile,
                        ];
                        PickupDetails::create($createPickupData); 
                    }
                    DeliveryDetails::where('pickup_delivery_id', $id)->delete();
                    
                    foreach ($request->addmore as $key => $value) {
                        
                        $insertPickupData = [
                            'pickup_delivery_id'=>$id, 
                            'from_miles'=>$value['min_miles'],
                            'to_miles' => $value['max_miles'],
                            'rate' => $value['min_miles_rate'],                                        
                        ];
                        DeliveryDetails::create($insertPickupData);
                    }
                }
                if($pickupDelivery==3){
                    
                    if($oldOptions==3 || $oldOptions==2){
                        DeliveryDetails::where('pickup_delivery_id', $id)->delete();
                        foreach ($request->addmore as $key => $value) {
                            $insertPickupData = [
                                'pickup_delivery_id'=>$id, 
                                'from_miles'=>$value['min_miles'],
                                'to_miles' => $value['max_miles'],
                                'rate' => $value['min_miles_rate'],                                        
                            ];
                            DeliveryDetails::create($insertPickupData);
                        }
                    }
                    if($oldOptions==2 || $oldOptions==1){
                        PickupDetails::where('pickup_delivery_id', $id)->delete();    
                    }
                } 
                 
                DB::commit();
                Helper::myLog('Pickup and Delivery update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Pickup and Delivery update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been updated!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        Helper::myLog('Pickup and Delivery delete : start');
        try {

            PickupDelivery::where('id', $id)->delete();
            PickupDetails::where('pickup_delivery_id', $id)->delete();
            DeliveryDetails::where('pickup_delivery_id', $id)->delete();
            DB::commit();
            Helper::myLog('Pickup and Delivery delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Pickup and Delivery delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function getChefAddress(){
        $addressDetail=Users::select('users.mobile','chef_location.state_id','chef_location.city_id','chef_location.address','chef_location.zip_code','chef_location.chef_id')
        ->leftJoin('chef_location', 'users.id', '=', 'chef_location.chef_id')
        ->where('users.id',auth('chef')->user()->id)->first();        
        return response()->json($addressDetail);
    }

    public function deliveryDetail(Request $request)
    {
        DB::beginTransaction();
        Helper::myLog('Delivery Detail Store : start');
        try {       
                $orderId=$request->order_id;
                $name = $request->del_name;
                $mobile = $request->del_mo;
                $time = $request->del_time;
                $code= $request->delivery_code;
         
                $insertData = [ 
                    'order_id'=>$orderId,
                    'name' => $name,
                    'mobile'=> $mobile,
                    'delivery_time' => $time,
                    'delivery_code'=>$code             
                ];
            ThirdPartyDetail::create($insertData);
           $orderUpdate = ['status'=>5,'ready_at'=>now(),'ready_at_timezone'=>$request->timezone];

            Order::where('id', $orderId)->update($orderUpdate); 

            DB::commit();            
            Helper::myLog('Delivery Detail Store : finish');
            Toastr::success(Config::get('constants.message.add'), 'Save');
            return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Delivery Detail Store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been saved!']);
        }

    }
}
