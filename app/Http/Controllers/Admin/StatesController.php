<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\States;
use App\Model\Countries;
use App\Model\Permissions;
use App\Model\PermissionRole;
use Yajra\DataTables\Facades\DataTables;
use App\Model\Helper;
use DB;
use Config;
use Redirect;
use Session;
use File;
use Log;
use Toastr;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_states');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $pageData = ['title' => Config::get('constants.title.state')];
        return view('admin.state.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkPermission = Permissions::checkActionPermission('create_states');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }

        $countries = Countries::pluck('name', 'id');
        $pageData = ["title" => Config::get('constants.title.state_add'),'countries'=>$countries];
        return view('admin.state.create', $pageData);
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
        Helper::myLog('State store : start');
        try {
            $name = $request->name;
            $slug = Helper::slugify($request->name);
            $country_id = $request->country_id;
            $checkName = States::where('name', $name)->count();
            if ($checkName > 0) {
                Helper::myLog('State store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The state name is already exists!']);
            } else {
                $insertData = [
                    'name' => $name,
                    'slug' => $slug,
                    'country_id' => $country_id,
                ];
                States::create($insertData);
                DB::commit();
                Helper::myLog('State store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('State store : exception');
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
        
        $stateData = States::where('id', $id)->first();
        $countries = Countries::pluck('name', 'id');
        $pageData = [
                    "title" => Config::get('constants.title.state_edit'), 
                    'stateData' => $stateData,
                    'countries' => $countries
                    ];
        return view('admin.state.edit', $pageData);
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
        Helper::myLog('State update : start');
        try {

            $name = $request->name;
            $slug = Helper::slugify($request->name);
            $country_id = $request->country_id;

            $checkName = States::where('name', $name)->where('id', '!=', $id)->count();
            if ($checkName > 0) {
                Helper::myLog('State store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The state name is already exists!']);
            } else {
                $updateData = [
                    'name' => $name,
                    'slug' => $slug,
                    'country_id' => $country_id,
                ];
                States::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('State update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('State update : exception');
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
        Helper::myLog('State Delete : start');
        try {

            States::where('id', $id)->delete();
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
     /**
     * Remove the multiple resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = States::whereIn('id', explode(",", $ids))->delete();
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_success_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }
     /**
     * Listing of States 
     *
     */
    public function getData()
    {
        try {
            
            $selectedItems = ['states.*', 'countries.name as country_id'];
            $data = States::select($selectedItems)
            ->leftjoin('countries', 'states.country_id', 'countries.id');
            
            return Datatables::of($data)
            ->addColumn('itechcheck', function($r) {
                //return '<input type="checkbox" class="sub_chk" data-id="' . $r->id . '">';
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
                $checkPermission = Permissions::checkActionPermission('update_states');
                if ($checkPermission == true) {
                    $editButton='<a href="'.route('state.edit', $r->id).'" id="edit" title="Edit" rel="tooltip" class="btn btn-round btn-warning edit"><i class="fa fa-pencil"></i></a>';
                }
                $checkPermission = Permissions::checkActionPermission('delete_states');
                if ($checkPermission == true) {
                    $deleteButton='<button id="state" type="button" title="Delete" rel="tooltip" class="btn  btn-danger remove"  data-id="'.$r->id.'"  data-action="' . route('state.destroy', $r->id) . '" data-message="'.Config::get('constants.message.confirm').'"><i class="fa fa-trash"></i></button>';
                }
                return $editButton . ' ' . $deleteButton ;
            })
            ->rawColumns(['action', 'itechcheck'])
            ->toJson();
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['data' => 0, 'message' => $ex->getMessage()], 500);
        }
    }
    public function stateSubCategory($id){       
        $pageData = [
            "title" => '',
            'countryCategories' => $countryCategories,
            'categoryList' => $categoryList,
            'countryId' => $countryId
        ];        
        return view('admin.country.country-category',$pageData);
    }
}
