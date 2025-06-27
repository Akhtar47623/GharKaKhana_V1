<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ChefDiscount;
use App\Model\Helper;
use Toastr;
use Config;
use Auth;
use DB;

class ChefDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $chefPromotion=ChefDiscount::where('chef_id',auth('chef')->user()->id)->get();
       $pageData = [
                        'chefPromotion'=>$chefPromotion,
                    ];
        return view('frontend.chef-dashboard.chef-discount.index',$pageData);       
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         return view("frontend.chef-dashboard.chef-discount.create");
        
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
        Helper::myLog('Promocode Store : start');
        try {            
                
            $promocode=$request->promocode;
            $discount=$request->discount;
            $total_coupons=$request->total_coupons;
            $minimum_order_value=$request->minimum_order_value;
            $start_date=$request->start_date;
            $expired_date=$request->expired_date;

            $insertData = [ 
                'chef_id'=>auth('chef')->user()->id,
                'uuid' => Helper::getUuid(),
                'promo_code'=> $promocode,                  
                'discount' => $discount,
                'starts_at' => $start_date,
                'total_coupons' => $total_coupons,
                'expired_at' => $expired_date,
                'minimum_order_value' => $minimum_order_value,
            ];
            $itemData=ChefDiscount::create($insertData);
         
            DB::commit();            
            Helper::myLog('Promocode store : finish');
            Toastr::success(Config::get('constants.message.add'), 'Save');
            return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Promocode Store : exception');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {        
           $chefDiscount = ChefDiscount::where('uuid', $uuid)->first();
           return view('frontend.chef-dashboard.chef-discount.edit',compact('chefDiscount'));
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
        Helper::myLog('Promocode Update : start');
        try {            
                
            $promocode=$request->promocode;
            $discount=$request->discount;
            $total_coupons=$request->total_coupons;
            $minimum_order_value=$request->minimum_order_value;
            $start_date=$request->start_date;
            $expired_date=$request->expired_date;

            $updateData = [ 
                'promo_code'=> $promocode,                  
                'discount' => $discount,
                'total_coupons' => $total_coupons,
                'starts_at' => $start_date,
                'expired_at' => $expired_date,
                'minimum_order_value' => $minimum_order_value,
            ];
            ChefDiscount::where('id', $id)->update($updateData);         
            DB::commit();            
            Helper::myLog('Promocode Update : finish');
            Toastr::success(Config::get('constants.message.add'), 'Update');
            return response()->json(['status' => 200, 'message' => 'This information has been Updated!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Promocode Update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been Updated!']);
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
        Helper::myLog('Promocode delete : start');
        try {

            ChefDiscount::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Promocode delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Promocode  Delete: exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function changeStatus(Request $request){
        try {
            $chefDiscount = ChefDiscount::find($request->id);
            $chefDiscount->status = $request->status;
            $status=$chefDiscount->save();            
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
