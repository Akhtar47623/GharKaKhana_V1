<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Model\Helper;
use App\Model\Group;
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

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupData = Group::where('chef_id',auth('chef')->user()->id)->get();
        $pageData = ['groupData'=>$groupData];
        return view('frontend.chef-dashboard.group.index',$pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.chef-dashboard.group.create');
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
        Helper::myLog('Group store : start');
        try {
            $name = $request->group_name;
            $checkName = Group::where('group_name', $name)->where('chef_id',auth('chef')->user()->id)->count();
            if ($checkName > 0) {
                Helper::myLog('cuisine store : name is exists');
                return response()->json(['status' => 409, 'message' => 'Name is already exists!']);
            } else {             
                             
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'chef_id'=>auth('chef')->user()->id,
                    'group_name' => $name,
                    'option' => $request->option,
                    'required'=>$request->required=="on"?"1":"0"
                ];
                
                Group::create($insertData);
                DB::commit();
                Helper::myLog('Group store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Group store : exception');
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
        $groupData = Group::where('uuid', $uuid)->first();
        $pageData = ['groupData' => $groupData];
        return view('frontend.chef-dashboard.group.edit', $pageData);
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
        Helper::myLog('Group update : start');
        try {

            $name = $request->group_name;
            $checkName = Group::where('group_name', $name)->where('id', '!=', $id)->count();
           
            if ($checkName > 0) {
                Helper::myLog('Group update : name is exists');
                return response()->json(['status' => 409, 'message' => 'Name is already exists!']);
            } else {
                $updateData = [
                    'group_name' => $name,
                    'option' => $request->option,
                    'required'=>$request->required=="on"?"1":"0"
                ];
                
                Group::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('Group update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Group update : exception');
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
    public function destroy($uuid)
    {
        DB::beginTransaction();
        Helper::myLog('Group delete : start');
        try {
            Group::where('uuid', $uuid)->delete();
            DB::commit();
            Helper::myLog('Group delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Group delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    
   
}
