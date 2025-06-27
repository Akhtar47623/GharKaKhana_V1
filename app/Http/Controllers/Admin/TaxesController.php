<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\States;
use App\Model\Countries;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\Cities;
use App\Model\Helper;
use App\Model\Taxes;
use DB;
use Config;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;
use File;
use Log;
use Toastr;


class TaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_taxes');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $pageData = ['title' => Config::get('constants.title.taxes')];
        return view('admin.taxes.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkPermission = Permissions::checkActionPermission('create_taxes');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }

        $countries = Countries::pluck('name', 'id');
        $pageData = ["title" => Config::get('constants.title.taxes_add'),'countries'=>$countries];
        return view('admin.taxes.create', $pageData);
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
        Helper::myLog('Taxes store : start');
        try {
            
            $state_id = $request->state;
            $country_id = $request->country;
            $city_id = $request->city;
           
            $check = Taxes::where('country_id', $country_id)
                        ->where('state_id',$state_id)
                        ->where('city_id',$city_id)
                        ->count();
                         
            if ($check > 0) {
                Helper::myLog('Taxes store : This tax detail already added');
                return response()->json(['status' => 409, 'message' => 'This country and state tax detail already added']);
            } else {
                $insertData = [
                    'uuid'=>Helper::getUuid(),
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'city_id' => $city_id,
                    'currency' => $request->currency,
                    'chef_commission' => $request->chef_commission,
                    'delivery_commission' => $request->delivery_commission,
                    'service_fee_base' => $request->service_fee_base,
                    'service_fee_per' => $request->service_fee_per,
                    'tax' => $request->tax,
                    'cc_fees' => $request->cc_fees,
                    'house' => $request->house,
                ];  
                
                Taxes::create($insertData);
                DB::commit();
                Helper::myLog('Taxes store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Taxes store : exception');
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
    public function edit($id)
    {
        $taxesData = Taxes::where('id',$id)->first();
        $countries = Countries::pluck('name', 'id');
        
        $taxesData->country = $taxesData->country_id;
        $stateList = States::select('name', 'id')->where('country_id', $taxesData->country_id)->orderBy('name', 'ASC')->get();
        $cityList = Cities::select('name', 'id')->where('state_id', $taxesData->state_id)->orderBy('name', 'ASC')->get();
        $pageData = [
            "title" => Config::get('constants.title.taxes_edit'), 
            'stateList' => $stateList,
            'countries'=> $countries,
            'cityList' => $cityList,
            'taxesData' => $taxesData
        ];
        return view('admin.taxes.edit', $pageData);        
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
        Helper::myLog('Taxes update : start');
        try {

            $state_id = $request->state;
            $country_id = $request->country;
            $city_id = $request->city;
           
            $checkName = Taxes::where('country_id', $country_id)
                        ->where('state_id',$state_id)
                        ->where('city_id',$city_id)
                        ->where('id', '!=', $id)
                        ->count();
            
            if ($checkName > 0) {
                Helper::myLog('Taxes store : This country and state and city tax detail exists');
                return response()->json(['status' => 409, 'message' => 'This country and state and city tax detail already added']);
            } else {
                $updateData = [
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'city_id' => $city_id,
                    'currency' => $request->currency,
                    'chef_commission' => $request->chef_commission,
                    'delivery_commission' => $request->delivery_commission,
                    'service_fee_base' => $request->service_fee_base,
                    'service_fee_per' => $request->service_fee_per,
                    'tax' => $request->tax,
                    'cc_fees' => $request->cc_fees,
                    'house' => $request->house,
                ];
                Taxes::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('Taxes update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('City update : exception');
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
        Helper::myLog('Taxes Delete : start');
        try {

            Taxes::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Taxes Delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Taxes delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function getStateList(Request $request)
    {
            $state = States::where("country_id",$request->country_id)->pluck("name","id");
            return response()->json($state);
    }
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = Taxes::whereIn('id', explode(",", $ids))->delete();
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_success_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }
    public function getData()
    {
        try {
            
            $data= Taxes::leftjoin('cities', 'taxes.city_id', 'cities.id')
            ->leftjoin('states', 'taxes.state_id', 'states.id')
            ->leftjoin('countries','taxes.country_id','countries.id')
            ->select('taxes.id','taxes.currency','taxes.chef_commission','taxes.delivery_commission','taxes.service_fee_base','taxes.service_fee_per','taxes.tax','taxes.cc_fees','taxes.house','cities.name as city_id','states.name as state_id','countries.name as country_id');

            return Datatables::of($data)
            ->addColumn('itechcheck', function($r) {
                return '<div class="form-check pull-left">
                            <label class="form-check-label">
                              <input type="checkbox" id="master" class="sub_chk" data-id="' . $r->id . '">
                              <span class="form-check-sign"></span>
                            </label>
                        </div>';
            })
            ->editColumn('chef_commission', function($r) {
                return $r->chef_commission.'%';
            })
            ->editColumn('delivery_commission', function($r) {
                return $r->delivery_commission.'%';
            })
             ->editColumn('service_fee_per', function($r) {
                return $r->service_fee_per.'%';
            })
            ->editColumn('tax', function($r) {
                return $r->tax.'%';
            })
            ->editColumn('cc_fees', function($r) {
                return $r->cc_fees.'%';
            })
            ->editColumn('house', function($r) {
                return $r->house.'%';
            })
            ->addColumn('action', function($r) {
                $editButton = '';
                $deleteButton = '';
                $checkPermission = Permissions::checkActionPermission('update_taxes');
                if ($checkPermission == true) {
                    $editButton='<a href="'.route('taxes.edit', $r->id).'" id="edit" title="Edit" rel="tooltip" class="btn btn-round btn-warning edit"><i class="fa fa-pencil"></i></a>';
                }
                $checkPermission = Permissions::checkActionPermission('delete_taxes');
                if ($checkPermission == true) {
                    $deleteButton='<button id="state" type="button" title="Delete" rel="tooltip" class="btn  btn-danger remove"  data-id="'.$r->id.'"  data-action="' . route('taxes.destroy', $r->id) . '" data-message="'.Config::get('constants.message.confirm').'"><i class="fa fa-trash"></i></button>';
                }
                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['action', 'itechcheck'])
            ->toJson();
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['data' => 0, 'message' => $ex->getMessage()], 500);
        }
    }
}