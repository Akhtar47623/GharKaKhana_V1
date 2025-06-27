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
use DB;
use Config;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;
use File;
use Log;
use Toastr;


class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_cities');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $pageData = ['title' => Config::get('constants.title.city')];
        return view('admin.city.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkPermission = Permissions::checkActionPermission('create_cities');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }

        $countries = Countries::pluck('name', 'id');
        $pageData = ["title" => Config::get('constants.title.city_add'),'countries'=>$countries];
        return view('admin.city.create', $pageData);
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
        Helper::myLog('City store : start');
        try {
            $name = $request->name;
            $slug = Helper::slugify($request->name);
            $state_id = $request->state_id;

            $checkName = Cities::where('name', $name)->count();
            if ($checkName > 0) {
                Helper::myLog('City store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The city name is already exists!']);
            } else {
                $insertData = [
                    'name' => $name,
                    'slug' => $slug,
                    'state_id' => $state_id,
                ];
                Cities::create($insertData);
                DB::commit();
                Helper::myLog('City store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('City store : exception');
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
        $countries = Countries::select('name', 'id')->get();
        $city = Cities::where('id', $id)->first();
        $state = States::where('id',$city->state_id)->first();
        $city->country_id = $state->country_id;
        $city->state = $city->state_id;
        $state= States::select('name', 'id')->where('country_id', $state->country_id)->orderBy('name', 'ASC')->get();
        if (!empty($state)) {
            $pageData = ["title" => Config::get('constants.title.city_edit'), 'state' => $state,'city' => $city,'countries'=>$countries];
            return view('admin.city.edit', $pageData);
        }
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
        Helper::myLog('City update : start');
        try {

            $name = $request->name;
            $slug = Helper::slugify($request->name);
            $state_id = $request->state_id;

            $checkName = Cities::where('name', $name)->where('id', '!=', $id)->count();
            if ($checkName > 0) {
                Helper::myLog('City store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The city name is already exists!']);
            } else {
                $updateData = [
                    'name' => $name,
                    'slug' => $slug,
                    'state_id' => $state_id,
                ];
                Cities::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('City update : finish');
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
        Helper::myLog('City Delete : start');
        try {

            Cities::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('City Delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('State delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function getStateList(Request $request)
    {  
            $currency=Countries::select('currency')->where('id',$request->country_id)->first();
            if($request->country_id=='142')
            {
                 $state = States::where("id",2437)->pluck("name","id");
            }
            else
            {
                  $state = States::where("country_id",$request->country_id)->pluck("name","id");
            }
            $data = [$state, $currency];

            return response()->json($data);
    }
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = Cities::whereIn('id', explode(",", $ids))->delete();
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
            
            $data= Cities::leftjoin('states', 'cities.state_id', 'states.id')
            ->select('cities.id','cities.name','states.name as state_id');
            return Datatables::of($data)
            ->addColumn('itechcheck', function($r) {
                return '<div class="form-check pull-left">
                            <label class="form-check-label">
                              <input type="checkbox" id="master" class="sub_chk" data-id="' . $r->id . '">
                              <span class="form-check-sign"></span>
                            </label>
                        </div>';
            })
            ->addColumn('action', function($r) {
                $editButton = '';
                $deleteButton = '';
                $checkPermission = Permissions::checkActionPermission('update_cities');
                if ($checkPermission == true) {
                    $editButton='<a href="'.route('city.edit', $r->id).'" id="edit" title="Edit" rel="tooltip" class="btn btn-round btn-warning edit"><i class="fa fa-pencil"></i></a>';
                }
                $checkPermission = Permissions::checkActionPermission('delete_cities');
                if ($checkPermission == true) {
                    $deleteButton='<button id="state" type="button" title="Delete" rel="tooltip" class="btn  btn-danger remove"  data-id="'.$r->id.'"  data-action="' . route('city.destroy', $r->id) . '" data-message="'.Config::get('constants.message.confirm').'"><i class="fa fa-trash"></i></button>';
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