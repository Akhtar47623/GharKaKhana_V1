<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Countries;
use App\Model\States;
use App\Model\Discount;
use App\Model\ChefDiscount;
use App\Model\VendorDiscount;
use App\Model\Helper;
use App\Model\Permissions;
use App\Model\PermissionRole;
use Toastr;
use Config;
use DB;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_discount');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $selectedItems = ['discount.*', 'countries.name as country_id','states.name as state_id'];
        $discountData = Discount::select($selectedItems)
                        ->leftjoin('countries', 'discount.country_id', 'countries.id')
                        ->leftjoin('states', 'discount.state_id', 'states.id')
                        ->get();
                     
        $pageData = ['title' => Config::get('constants.title.discount'),'discountData'=>$discountData];
        return view('admin.discount.index', $pageData);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::pluck('name', 'id');
        $pageData = ["title" => Config::get('constants.title.discount_add'),'countries'=>$countries];
        return view('admin.discount.create', $pageData);
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
        Helper::myLog('Discount Store : start');
        try {            
            $promocode=$request->promocode;
            $checkPromoVendor =  VendorDiscount::where('promo_code',$promocode)->count();
            $checkPromoChef =  ChefDiscount::where('promo_code',$promocode)->count(); 
            $checkPromoCompany =  Discount::where('promo_code',$promocode)->count();        
            if ($checkPromoVendor >0 || $checkPromoChef>0 ||  $checkPromoCompany>0) {
                Helper::myLog(' Discount Store : Promocode is exists.. Please enter new promocode');
                return response()->json(['status' => 409, 'message' => 'Promocode is exists!']);
            } else {
            
                $country_id = $request->country_id;
                $state_id = $request->state_id;
                $companydiscount=$request->company_discount;
                $total_coupon=$request->total_coupon;
                $minimum_order_value=$request->minimum_order_value;
                $start_date=$request->start_date;
                $expired_date=$request->expired_date;

                $insertData = [ 
                    
                    'uuid' => Helper::getUuid(),
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'promo_code'=> $promocode,                  
                    'company_discount' => $companydiscount,
                    'total_coupons' => $total_coupon,
                    'starts_at' => $start_date,
                    'expired_at' => $expired_date,
                    'minimum_order_value' => $minimum_order_value,
                ];
                $itemData=Discount::create($insertData);
             
                DB::commit();            
                Helper::myLog('Discount store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);

        }
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Discount Store : exception');
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
    public function edit($id)
    {
        $discount = Discount::where('id', $id)->first();
        $countries = Countries::pluck('name', 'id');
        $states = States::where('country_id',$discount->country_id)->pluck('name','id');
        $states[0]="All";
        $pageData = [
            "title" => Config::get('constants.title.discount_edit'), 
            'discount' => $discount,
            'countries' => $countries,
            'states' => $states,
            ];
        return view('admin.discount.edit',$pageData);
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
        Helper::myLog('Discount Update : start');
        try {            
               $promocode=$request->promocode;
                $checkPromoVendor =  VendorDiscount::where('promo_code',$promocode)->where('id', '!=', $id)->count();
                $checkPromoChef =  ChefDiscount::where('promo_code',$promocode)->where('id', '!=', $id)->count(); 
                $checkPromoCompany =  Discount::where('promo_code',$promocode)->where('id', '!=', $id)->count();        
                if ($checkPromoVendor >0 || $checkPromoChef>0 ||  $checkPromoCompany>0) {
                    Helper::myLog(' Discount Store : Promocode is exists.. Please enter new promocode');
                    return response()->json(['status' => 409, 'message' => 'Promocode is exists!']);
                } else {       
                  
                    $country_id = $request->country_id;
                    $state_id = $request->state_id;    
                    $companydiscount=$request->company_discount;
                    $total_coupon=$request->total_coupon;
                    $minimum_order_value=$request->minimum_order_value;
                    $start_date=$request->start_date;
                    $expired_date=$request->expired_date;

                    $updateData = [ 
                        'country_id' => $country_id,
                        'state_id' => $state_id,
                        'promo_code'=> $promocode,                  
                        'company_discount' => $companydiscount,
                        'total_coupons' => $total_coupon,
                        'starts_at' => $start_date,
                        'expired_at' => $expired_date,
                        'minimum_order_value' => $minimum_order_value,
                    ];
                    Discount::where('id', $id)->update($updateData);         
                    DB::commit();            
                    Helper::myLog('Discount Update : finish');
                    Toastr::success(Config::get('constants.message.add'), 'Update');
                    return response()->json(['status' => 200, 'message' => 'This information has been Updated!']);
                }

        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Discount Update : exception');
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
        Helper::myLog('Discount delete : start');
        try {
            Discount::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Discount delete : finish');
          //  Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Discount delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = Discount::whereIn('id', explode(",", $ids))->delete();
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_success_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }
     public function changeStatus(Request $request){
        try {
            $discount = Discount::find($request->discount);
            $discount->status = $request->status;
            $status=$discount->save();        
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
