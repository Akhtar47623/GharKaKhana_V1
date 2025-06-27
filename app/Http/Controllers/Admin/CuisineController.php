<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\Cuisine;
use App\Model\Helper;
use DB;
use Config;
use Redirect;
use Session;
use File;
use Log;
use Toastr;

class CuisineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_cuisine');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $cuisineData = Cuisine::get();
        $pageData = ['title' => Config::get('constants.title.cuisine'),'cuisineData'=>$cuisineData];
        return view('admin.cuisine.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = ["title" => Config::get('constants.title.cuisine_add')];
        return view('admin.cuisine.create', $pageData);
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
        Helper::myLog('cuisine store : start');
        try {
            $name = $request->name;
            $checkName = Cuisine::where('name', $name)->count();
            if ($checkName > 0) {
                Helper::myLog('cuisine store : name is exists');
                return response()->json(['status' => 409, 'message' => 'Name is already exists!']);
            } else {
                
                             
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'name' => $name,
                    'status' => $request->status
                ];
                
                Cuisine::create($insertData);
                DB::commit();
                Helper::myLog('cuisine store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('cuisine store : exception');
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
        $cuisineData = Cuisine::where('id', $id)->first();
        $pageData = ["title" => Config::get('constants.title.cuisine_edit'), 'cuisineData' => $cuisineData];
        return view('admin.cuisine.edit', $pageData);
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
        Helper::myLog('cuisine update : start');
        try {

            $name = $request->name;
            
            $checkName = Cuisine::where('name', $name)->where('id', '!=', $id)->count();
           
            if ($checkName > 0) {
                Helper::myLog('cuisine update : name is exists');
                return response()->json(['status' => 409, 'message' => 'Name is already exists!']);
            } else {
                $updateData = [
                    'name' => $name,
                    'status' => $request->status
                ];
                
                Cuisine::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('cuisine update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('cuisine update : exception');
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
        Helper::myLog('cuisine delete : start');
        try {

            Cuisine::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('cuisine delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('cuisine delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = Cuisine::whereIn('id', explode(",", $ids))->delete();
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

            $cuisine = Cuisine::find($request->id);
            $cuisine->status = $request->status;
            $status=$cuisine->save();            
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
