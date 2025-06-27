<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Model\Helper;
use App\Model\Cuisine;
use App\Model\Options;
use App\Model\Schedule;
use App\Model\ChefSchedule;
use App\Model\Categories;
use App\Model\Menu;
use App\Model\Nutrition;
use App\Model\OptionGroup;
use App\Model\Group;
use App\Model\Countries;
use App\Model\PickupDelivery;
use App\Model\Location;
use App\Model\Taxes;
use App\Model\Business;
use App\Model\Banking;
use App\Model\Tax;
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

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index()
    {
        $chefId=auth('chef')->user()->id;
    
        $chefItemCategory=Menu::select('id','item_category')
                            ->where('chef_id',$chefId)
                            ->groupBy('item_category')->get();

        $chefMainCategory=Menu::select('item_category')
                            ->where('chef_id',$chefId)
                            ->distinct('item_category')->get();
        
        $mainCategory=array();
        foreach ($chefMainCategory as $value) {
            $subCategory=Menu::select('item_type')->where('chef_id',$chefId)
                                        ->where('item_category',$value->item_category)
                                        ->distinct('item_type')->pluck('item_type')->toArray();
            $mCat = ['maincategory'=>$value->item_category,'subcategory'=>$subCategory,'items'=>[]];             
            foreach ($subCategory as $value1) {
                $items = Menu::with('menuOptions','menuSchedule','menuNutrition')->where('chef_id',$chefId)
                            ->where('item_category',$value->item_category)
                            ->where('item_type',$value1)
                            ->get();
                
                array_push($mCat['items'],$items);
                
            }
            array_push($mainCategory,$mCat);            
        }  
        
        $chekPickDel=PickupDelivery::where('chef_id',auth('chef')->user()->id)->count();
        $checkBunssinessDetail=Business::Where('chef_id',auth('chef')->user()->id)->count();
        $checkTaxDetail=Tax::Where('chef_id',auth('chef')->user()->id)->count();
        $check=0;
        if($chekPickDel > 0 &&  $checkBunssinessDetail > 0 &&  $checkTaxDetail > 0){

            $check=1;
        }

        $pageData = [                
            'chefMainCategory'=>$chefMainCategory,
            'mainCategory'=>$mainCategory,
            'check'=>$check
        ];
        return view("frontend.chef-dashboard.menu.index",$pageData);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $cuisines = Cuisine::where('status','A')->pluck('name', 'id');
        $ChefSchedule=ChefSchedule::where('chef_id',auth('chef')->user()->id)->first();        
        $groups = Group::select('id','group_name')->where('chef_id',auth('chef')->user()->id)->get();        
        $countryId=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        $chefLocation = Location::select('city_id','state_id')->with('state','city')->where('chef_id',auth('chef')->user()->id)->first();
        $taxes = Taxes::select('service_fee_per','tax')->where('state_id',$chefLocation->state_id)->where('city_id',$chefLocation->city_id)->first(); 
        $currency=[];
        if($countryId){
        $currency = Countries::where('id',$countryId->country_id)->first();
        }
        $userLocationInfo = Users::getCountryState(auth('chef')->user()->id);
        $categories=Categories::where('country_id',$userLocationInfo->country_id)
                        ->whereIn('state_id',[$userLocationInfo->state_id,0])
                        ->orderBy('name', 'ASC')->pluck('name','name');

        $pageData = [
        'cuisines'=>$cuisines,
        'ChefSchedule' => $ChefSchedule,
        'groups'=>$groups,
        'currency'=>$currency,
        'categories' => $categories,
        'taxes'=>$taxes
        ];
        return view('frontend.chef-dashboard.menu.create',$pageData);
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
        Helper::myLog('Menu Item Store : start');
        try { 
                 
            $dietary_restriction = implode(',',$request->dietary_restriction);
            $options = $request->options;
            $item_visibility = $request->item_visibility;
            $status = $request->status;
            if ($file = $request->file('profile')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $file->move(base_path() . '/public/frontend/images/menu/', $fileName);
                $profile = $fileName;
            }    
            $insertData = [ 
                'chef_id'=>auth('chef')->user()->id,
                'uuid' => Helper::getUuid(),
                'item_name'=> $request->item_name,                  
                'item_description' => $request->item_description,
                'item_type' => ucfirst($request->item_type),
                'item_category' => $request->item_category,
                'rate' => $request->rate,
                'dietary_restriction' => $dietary_restriction,
                'minimum_order' => $request->minimum_order,
                'maximum_order' => $request->maximum_order,
                'options' => $request->options=='on' ? '1':'0',
                'item_visibility' =>$request->item_visibility=='on' ? '1':'0',
                'status' =>$request->status=='on' ? '1':'0',
                'photo' => $profile
            ];
            
            if ($file1 = $request->file('label')) {
                $extension1 = $file1->getClientOriginalExtension();
                $fileName1 = rand(11111, 99999) . '.' . $extension1;
                $file1->move(base_path() . '/public/frontend/images/menu/', $fileName1);
                $insertData['label_photo'] = $fileName1;
            }

            $itemData=Menu::create($insertData);
           
            if($options=='on'){
                foreach ($request->addmore as $key => $value) {
                    
                    $insertOption = [
                        'menu_id' =>  $itemData->id,
                        'option' => $value['option'],                            
                        'group_id'=> $value['group'],                                      
                    ];
                    if(isset($value['upcharge'])){
                        $insertOption['upcharge']=$value['upcharge']=='on'?'1':'0';
                        $insertOption['rate']=$value['rate'];
                    }else{
                        $insertOption['upcharge']='0';
                        $insertOption['rate']='0';
                    }

                    if(isset($value['status'])){
                        $insertOption['status']=$value['status']=='on'?'1':'0';
                    }else{
                        $insertOption['status']='0';
                    }

                    Options::create($insertOption);
                }
                
            }
            $insertSchedule = [
                'menu_id' =>  $itemData->id,
                'recurring' => $request->input('recurring')=='on'?'1':'0',
                'lead_time' => $request->lead_time

            ];
            if($request->input('mon')=='on'){
                $insertSchedule['mon']= $request->input('mon')=='on'?"1":"0";
                $insertSchedule['mon_start_time']=$request->mon_start_time;
                $insertSchedule['mon_end_time']=$request->mon_end_time;
            }
            if($request->input('tue')=='on'){
                $insertSchedule['tue']= $request->input('tue')=='on'?"1":"0";
                $insertSchedule['tue_start_time']=$request->tue_start_time;
                $insertSchedule['tue_end_time']=$request->tue_end_time;
            }
            if($request->input('wed')=='on'){
                $insertSchedule['wed']= $request->input('wed')=='on'?"1":"0";
                $insertSchedule['wed_start_time']=$request->wed_start_time;
                $insertSchedule['wed_end_time']=$request->wed_end_time;
            }
            if($request->input('thu')=='on'){
                $insertSchedule['thu']= $request->input('thu')=='on'?"1":"0";
                $insertSchedule['thu_start_time']=$request->thu_start_time;
                $insertSchedule['thu_end_time']=$request->thu_end_time;
            }
            if($request->input('fri')=='on'){
                $insertSchedule['fri']= $request->input('fri')=='on'?"1":"0";
                $insertSchedule['fri_start_time']=$request->fri_start_time;
                $insertSchedule['fri_end_time']=$request->fri_end_time;
            }
            if($request->input('sat')=='on'){
                $insertSchedule['sat']= $request->input('sat')=='on'?"1":"0";
                $insertSchedule['sat_start_time']=$request->sat_start_time;
                $insertSchedule['sat_end_time']=$request->sat_end_time;
            }
            if($request->input('sun')=='on'){
                $insertSchedule['sun']= $request->input('sun')=='on'?"1":"0";
                $insertSchedule['sun_start_time']=$request->sun_start_time;
                $insertSchedule['sun_end_time']=$request->sun_end_time;
            }
            Schedule::create($insertSchedule);

            $insertNutritionData = [
                'menu_id'=>$itemData->id,
                'service_per_container' => $request->service_per_container,
                'rounding' => $request->rounding,
                'quantity' => $request->quantity,
                'units' => $request->units,
                'serving_size' => $request->serving_size,
                'serving_size_unit' => $request->serving_size_unit,
                'calories' => $request->calories,
                'total_fat' => $request->total_fat,
                'saturated_fat' => $request->saturated_fat,
                'trans_fat' => $request->trans_fat,
                'cholesterol' => $request->cholesterol,
                'sodium' => $request->sodium,
                'total_carbohydrates' => $request->total_carbohydrates,
                'dietry_fiber' => $request->dietry_fiber,
                'sugars' => $request->sugars,
                'added_sugar' => $request->added_sugar,
                'protein' => $request->protein
            ];
            if($request->service_per_container!=NULL && $request->quantity!=NULL && $request->calories!=NULL){
                Nutrition::create($insertNutritionData);
            }
            DB::commit();            
            Helper::myLog('Menu Item store : finish');
            Toastr::success(Config::get('constants.message.add'), 'Save');
            return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Menu Item store : exception');
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
    public function show($uuid)
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
        $menuItemData = Menu::where('uuid', $uuid)->first();

        $itemOptionData = Menu::find($menuItemData->id)->menuOptions()->get();
        $itemCount = Menu::find($menuItemData->id)->menuOptions()->count();
        $selCuisines =  explode (",", $menuItemData->cuisine_id);
        $selDietary = explode(",", $menuItemData->dietary_restriction);

        $itemScheduleData  =  Schedule::where('menu_id',$menuItemData->id)->first();
        $groups = Group::select('id','group_name')->where('chef_id',auth('chef')->user()->id)->get();
        $countryId=Users::select('country_id')->where('id',auth('chef')->user()->id)->first();
        if($countryId){
            $currency = Countries::where('id',$countryId->country_id)->first();
        }else{
            $currency = Countries::where('id',231)->first();
        }
        $nutrition = Nutrition::where('menu_id',$menuItemData->id)->first();
        $userLocationInfo = Users::getCountryState(auth('chef')->user()->id);

        $categories=Categories::where('country_id',$userLocationInfo->country_id)
                                        ->whereIn('state_id',[$userLocationInfo->state_id,0])->pluck('name','name');
        $chefLocation = Location::select('city_id','state_id')->with('state','city')->where('chef_id',auth('chef')->user()->id)->first();
        $taxes = Taxes::select('service_fee_per','tax')->where('state_id',$chefLocation->state_id)->where('city_id',$chefLocation->city_id)->first();      
        $pageData = [
            'menuItemData' => $menuItemData,
            'itemOptionData' =>  $itemOptionData,
            'itemCount'=>$itemCount,
            'selCuisines'=>$selCuisines,
            'itemScheduleData'=>$itemScheduleData,
            'groups'=>$groups,
            'currency'=>$currency,
            'nutrition'=>$nutrition,
            'selDietary'=>$selDietary,
            'categories' => $categories,
            'taxes'=>$taxes
        ];
        
        return view('frontend.chef-dashboard.menu.edit',$pageData);
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
        Helper::myLog('Menu Item update : start');
        try {

            $dietary_restriction = implode(',',$request->dietary_restriction);
            $options = $request->options;
            $item_visibility = $request->item_visibility;
            $status = $request->status;
                
            $updateData = [ 
                'item_name'=> $request->item_name,                  
                'item_description' => $request->item_description,
                'item_type' => $request->item_type,
                'item_category' => $request->item_category,
                'rate' => $request->rate,
                'minimum_order' => $request->minimum_order,
                'maximum_order' => $request->maximum_order,
                'dietary_restriction' => $dietary_restriction,
                'options' => $request->options=='on' ? '1':'0',
                'item_visibility' =>$request->item_visibility=='on' ? '1':'0',
                'status' =>$request->status=='on' ? '1':'0'
            ];

            if($file = $request->file('profile')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $file->move(base_path() . '/public/frontend/images/menu/', $fileName);
                $updateData['photo'] = $fileName;
                
                if ($request->oldImage != null) {
                    $destinationPath = base_path() . '/public/frontend/images/menu/' . $request->oldImage;
                    File::delete($destinationPath); // remove oldfile
                }
            }
            if ($file1 = $request->file('label')) {
                $extension1 = $file1->getClientOriginalExtension();
                $fileName1 = rand(11111, 99999) . '.' . $extension1;
                $file1->move(base_path() . '/public/frontend/images/menu/', $fileName1);
                $updateData['label_photo'] = $fileName1;

                if ($request->oldImage1 != null) {
                    $destinationPath1 = base_path() . '/public/frontend/images/menu/' . $request->oldImage1;
                    File::delete($destinationPath1); // remove oldfile
                }
            }
            
            $itemData=Menu::where('id', $id)->update($updateData);

            
            if($options=='on'){
                foreach ($request->addmore as $key => $value) {                    
                                     
                    if(!empty($value['option'])){
                        $optId = $value['id'];

                        if($optId!=0){
                            $updateOption = [
                                'option' => $value['option'],
                                'group_id'=>$value['group'],

                            ];

                            if(isset($value['upcharge'])){
                                $updateOption['upcharge']=$value['upcharge']=='on'?'1':'0';
                                $updateOption['rate']=$value['rate'];
                            }else{
                                $updateOption['upcharge']='0';
                                $updateOption['rate']='0';
                            }
                            if(isset($value['status'])){
                                $updateOption['status']=$value['status']=='on'?'1':'0';
                            }else{
                                $updateOption['status']='0';
                            }
                            Options::where('id', $optId)->update($updateOption);                               

                        }
                        if($optId==0){                                    
                            $insertOption = [
                                'menu_id' =>  $id,
                                'option' => $value['option'],
                                'group_id'=>$value['group'],

                            ];
                            
                            if(isset($value['upcharge'])){
                                $insertOption['upcharge']=$value['upcharge']=='on'?'1':'0';
                                $insertOption['rate']=$value['rate'];
                            }else{
                                $insertOption['upcharge']='0';
                                $insertOption['rate']='0';
                            }
                            if(isset($value['status'])){
                                $insertOption['status']=$value['status']=='on'?'1':'0';
                            }else{
                                $insertOption['status']='0';
                            }
                            Options::create($insertOption);
                        }                        
                    }                        
                                     
                }                
            }
            $updateSchedule = [
                'recurring' => $request->input('recurring')=='on'?'1':'0',
                'lead_time' => $request->lead_time
            ];
           
            $updateSchedule['mon']= $request->input('mon')=='on'?"1":"0";
            $updateSchedule['mon_start_time']=$request->mon_start_time;
            $updateSchedule['mon_end_time']=$request->mon_end_time;
            
            $updateSchedule['tue']= $request->input('tue')=='on'?"1":"0";
            $updateSchedule['tue_start_time']=$request->tue_start_time;
            $updateSchedule['tue_end_time']=$request->tue_end_time;
           
            $updateSchedule['wed']= $request->input('wed')=='on'?"1":"0";
            $updateSchedule['wed_start_time']=$request->wed_start_time;
            $updateSchedule['wed_end_time']=$request->wed_end_time;
           
            $updateSchedule['thu']= $request->input('thu')=='on'?"1":"0";
            $updateSchedule['thu_start_time']=$request->thu_start_time;
            $updateSchedule['thu_end_time']=$request->thu_end_time;
           
            $updateSchedule['fri']= $request->input('fri')=='on'?"1":"0";
            $updateSchedule['fri_start_time']=$request->fri_start_time;
            $updateSchedule['fri_end_time']=$request->fri_end_time;
           
            $updateSchedule['sat']= $request->input('sat')=='on'?"1":"0";
            $updateSchedule['sat_start_time']=$request->sat_start_time;
            $updateSchedule['sat_end_time']=$request->sat_end_time;
           
            $updateSchedule['sun']= $request->input('sun')=='on'?"1":"0";
            $updateSchedule['sun_start_time']=$request->sun_start_time;
            $updateSchedule['sun_end_time']=$request->sun_end_time;
            
            Schedule::where('menu_id', $id)->update($updateSchedule);

            $updateNutritionData = [
                
                'service_per_container' => $request->service_per_container,
                'rounding' => $request->rounding,
                'quantity' => $request->quantity,
                'units' => $request->units,
                'serving_size' => $request->serving_size,
                'serving_size_unit' => $request->serving_size_unit,
                'calories' => $request->calories,
                'total_fat' => $request->total_fat,
                'saturated_fat' => $request->saturated_fat,
                'trans_fat' => $request->trans_fat,
                'cholesterol' => $request->cholesterol,
                'sodium' => $request->sodium,
                'total_carbohydrates' => $request->total_carbohydrates,
                'dietry_fiber' => $request->dietry_fiber,
                'sugars' => $request->sugars,
                'added_sugar' => $request->added_sugar,
                'protein' => $request->protein
            ];
            $checkExist=Nutrition::where('menu_id',$id)->count();
            if($checkExist==1){
                Nutrition::where('menu_id', $id)->update($updateNutritionData);
            }else{
                if($request->service_per_container!=NULL && $request->quantity!=NULL && $request->calories!=NULL){
                    $updateNutritionData['menu_id']=$id;                
                    Nutrition::create($updateNutritionData);
                }
                
            }

            DB::commit();
            Helper::myLog('Menu Item update : finish');
            Toastr::success(Config::get('constants.message.edit'), 'Update');
            return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Menu Item update : exception');
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
        Helper::myLog('Menu Item delete : start');
        try {

            Menu::where('id', $id)->delete();
            Options::where('menu_id', $id)->delete();
            DB::commit();
            Helper::myLog('Menu Item delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Menu Item : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function deleteItem(Request $request){

        DB::beginTransaction();
        Helper::myLog('Item option delete : start');
        try {
            Options::where('id', $request->id)->delete();
            DB::commit();
            Helper::myLog('Item option delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Item option delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function changeStatus(Request $request){
        try {

            $menu = Menu::find($request->id);
            $menu->status = $request->status;
            $status=$menu->save();            
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_status_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }

    public function changeAllMenuStatus(Request $request) {
        try {
            $ids = $request->ids;
            $status = $request->status;
           
            $status1 = Menu::whereIn('id', explode(",", $ids))->update(['status' => $status]);

            if ($status1) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_status_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }

    public function menuSchedule(Request $request){
        $ChefSchedule=ChefSchedule::where('chef_id',auth('chef')->user()->id)->first();
        $pageData = ['ChefSchedule' => $ChefSchedule];
        return view('frontend.chef-dashboard.menu.menu-schedule',$pageData);
    }
    
    public function saveChefSchedule(Request $request){
        DB::beginTransaction();
        Helper::myLog('Chef schedule Store : start');
        try {            
            if(!empty($request->btnSubmit)){  
                $scheduleData = [ 
                    'chef_id'=>auth('chef')->user()->id,
                    'uuid' => Helper::getUuid(),

                    'mon'=> $request->input('mon')=='on'?"1":"0",
                    'mon_start_time'=>$request->mon_start_time,
                    'mon_end_time'=>$request->mon_end_time,

                    'tue'=> $request->input('tue')=='on'?"1":"0",
                    'tue_start_time'=>$request->tue_start_time,
                    'tue_end_time'=>$request->tue_end_time,
               
                    'wed'=> $request->input('wed')=='on'?"1":"0",
                    'wed_start_time'=>$request->wed_start_time,
                    'wed_end_time'=>$request->wed_end_time,
                
                    'thu'=> $request->input('thu')=='on'?"1":"0",
                    'thu_start_time'=>$request->thu_start_time,
                    'thu_end_time'=>$request->thu_end_time,
                
                    'fri'=> $request->input('fri')=='on'?"1":"0",
                    'fri_start_time'=>$request->fri_start_time,
                    'fri_end_time'=>$request->fri_end_time,
                
                    'sat'=> $request->input('sat')=='on'?"1":"0",
                    'sat_start_time'=>$request->sat_start_time,
                    'sat_end_time'=>$request->sat_end_time,
                
                    'sun'=> $request->input('sun')=='on'?"1":"0",
                    'sun_start_time'=>$request->sun_start_time,
                    'sun_end_time'=>$request->sun_end_time,
                ];

                ChefSchedule::create($scheduleData);
                DB::commit();            
                Helper::myLog('Chef schedule store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }else{
                $updateSchedule['mon']= $request->input('mon')=='on'?"1":"0";
                $updateSchedule['mon_start_time']=$request->mon_start_time;
                $updateSchedule['mon_end_time']=$request->mon_end_time;
                
                $updateSchedule['tue']= $request->input('tue')=='on'?"1":"0";
                $updateSchedule['tue_start_time']=$request->tue_start_time;
                $updateSchedule['tue_end_time']=$request->tue_end_time;
               
                $updateSchedule['wed']= $request->input('wed')=='on'?"1":"0";
                $updateSchedule['wed_start_time']=$request->wed_start_time;
                $updateSchedule['wed_end_time']=$request->wed_end_time;
               
                $updateSchedule['thu']= $request->input('thu')=='on'?"1":"0";
                $updateSchedule['thu_start_time']=$request->thu_start_time;
                $updateSchedule['thu_end_time']=$request->thu_end_time;
               
                $updateSchedule['fri']= $request->input('fri')=='on'?"1":"0";
                $updateSchedule['fri_start_time']=$request->fri_start_time;
                $updateSchedule['fri_end_time']=$request->fri_end_time;
               
                $updateSchedule['sat']= $request->input('sat')=='on'?"1":"0";
                $updateSchedule['sat_start_time']=$request->sat_start_time;
                $updateSchedule['sat_end_time']=$request->sat_end_time;
               
                $updateSchedule['sun']= $request->input('sun')=='on'?"1":"0";
                $updateSchedule['sun_start_time']=$request->sun_start_time;
                $updateSchedule['sun_end_time']=$request->sun_end_time;
                $menuIds=Menu::where('chef_id',auth('chef')->user()->id)->pluck('id')->toArray();
                
                Schedule::whereIn('id', $menuIds)->update($updateSchedule);
                DB::commit();
                Helper::myLog('Chef schedule update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef schedule store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been saved!']);
        }
    }

    public function updateChefSchedule(Request $request,$id){
        DB::beginTransaction();
        Helper::myLog('Chef schedule update : start');
        try {

            if(!empty($request->btnSubmit)){
           
                $updateSchedule['mon']= $request->input('mon')=='on'?"1":"0";
                $updateSchedule['mon_start_time']=$request->mon_start_time;
                $updateSchedule['mon_end_time']=$request->mon_end_time;
                
                $updateSchedule['tue']= $request->input('tue')=='on'?"1":"0";
                $updateSchedule['tue_start_time']=$request->tue_start_time;
                $updateSchedule['tue_end_time']=$request->tue_end_time;
               
                $updateSchedule['wed']= $request->input('wed')=='on'?"1":"0";
                $updateSchedule['wed_start_time']=$request->wed_start_time;
                $updateSchedule['wed_end_time']=$request->wed_end_time;
               
                $updateSchedule['thu']= $request->input('thu')=='on'?"1":"0";
                $updateSchedule['thu_start_time']=$request->thu_start_time;
                $updateSchedule['thu_end_time']=$request->thu_end_time;
               
                $updateSchedule['fri']= $request->input('fri')=='on'?"1":"0";
                $updateSchedule['fri_start_time']=$request->fri_start_time;
                $updateSchedule['fri_end_time']=$request->fri_end_time;
               
                $updateSchedule['sat']= $request->input('sat')=='on'?"1":"0";
                $updateSchedule['sat_start_time']=$request->sat_start_time;
                $updateSchedule['sat_end_time']=$request->sat_end_time;
               
                $updateSchedule['sun']= $request->input('sun')=='on'?"1":"0";
                $updateSchedule['sun_start_time']=$request->sun_start_time;
                $updateSchedule['sun_end_time']=$request->sun_end_time;
                
                ChefSchedule::where('id', $id)->update($updateSchedule);
                DB::commit();
                Helper::myLog('Chef schedule update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }else{
                $updateSchedule['mon']= $request->input('mon')=='on'?"1":"0";
                $updateSchedule['mon_start_time']=$request->mon_start_time;
                $updateSchedule['mon_end_time']=$request->mon_end_time;
                
                $updateSchedule['tue']= $request->input('tue')=='on'?"1":"0";
                $updateSchedule['tue_start_time']=$request->tue_start_time;
                $updateSchedule['tue_end_time']=$request->tue_end_time;
               
                $updateSchedule['wed']= $request->input('wed')=='on'?"1":"0";
                $updateSchedule['wed_start_time']=$request->wed_start_time;
                $updateSchedule['wed_end_time']=$request->wed_end_time;
               
                $updateSchedule['thu']= $request->input('thu')=='on'?"1":"0";
                $updateSchedule['thu_start_time']=$request->thu_start_time;
                $updateSchedule['thu_end_time']=$request->thu_end_time;
               
                $updateSchedule['fri']= $request->input('fri')=='on'?"1":"0";
                $updateSchedule['fri_start_time']=$request->fri_start_time;
                $updateSchedule['fri_end_time']=$request->fri_end_time;
               
                $updateSchedule['sat']= $request->input('sat')=='on'?"1":"0";
                $updateSchedule['sat_start_time']=$request->sat_start_time;
                $updateSchedule['sat_end_time']=$request->sat_end_time;
               
                $updateSchedule['sun']= $request->input('sun')=='on'?"1":"0";
                $updateSchedule['sun_start_time']=$request->sun_start_time;
                $updateSchedule['sun_end_time']=$request->sun_end_time;
                $menuIds=Menu::where('chef_id',auth('chef')->user()->id)->pluck('id')->toArray();
                
                //dd($menuIds);
                Schedule::whereIn('id', $menuIds)->update($updateSchedule);
                DB::commit();
                Helper::myLog('Chef schedule update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef schedule update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been updated!']);
        }
    }
    function suggetion(Request $request)
    {

        if($request->get('category'))
        {
            $query = $request->get('category');
            $data = Menu::select('item_type')->where('item_category',$query)
                    ->where('chef_id',auth('chef')->user()->id)
                    ->groupBy('item_type')->get();
            $output='';
            if(!empty($data)){
                $output = '<ul class="subcat-dropdown-menu">';
                foreach($data as $row)
                {
                   $output .= '<li>'.$row->item_type.'</li>';
                }
                $output .= '</ul>';
                echo $output;
            }
        }
    }
    public function changeVisibility(Request $request){
        try {
               
            $menu = Menu::find($request->id);
            $menu->item_visibility = $request->visibility;
            $visibility=$menu->save();            
            if ($visibility) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_status_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }
   
}
