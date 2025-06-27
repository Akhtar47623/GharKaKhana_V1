<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\ChefRegistrationInfo;
use App\Model\Countries;
use App\Model\States;
use App\Model\Helper;
use DB;
use Config;
use Redirect;
use Session;
use File;
use Log;
use Toastr;

class ChefRegistrationInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $checkPermission = Permissions::checkActionPermission('view_chef_reg_info');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $selectedItems = ['chef_registration_info.*', 'countries.name as country_id','states.name as state_id'];
        $chefRegData = ChefRegistrationInfo::select($selectedItems)
                        ->leftjoin('countries', 'chef_registration_info.country_id', 'countries.id')
                        ->leftjoin('states', 'chef_registration_info.state_id', 'states.id')
                        ->get();
        $pageData = ['title' => Config::get('constants.title.chef_reg_info'),'chefRegData'=>$chefRegData];
        return view('admin.chef-regi-info.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $countries = Countries::whereIn('id', [30,101,231,38,142,166])->pluck('name', 'id');
        $pageData = ["title" => Config::get('constants.title.chef_reg_info_add'),'countries'=>$countries];
        return view('admin.chef-regi-info.create', $pageData);
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
        Helper::myLog('Chef Registration Info : start');
        try {
            $country_id = $request->country_id;
            $state_id = $request->state_id;
            $desc=$request->summary_ckeditor;
            $usertype=$request->user_type;
            $checkName = ChefRegistrationInfo::where('country_id', $country_id)
            ->where('state_id',$state_id)->where('user_type',$usertype)->count();
            if ($checkName > 0) {
                Helper::myLog('Chef Registration Info : Infromation is exists');
                return response()->json(['status' => 409, 'message' => 'Information is already exists!']);
            } else {
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'user_type'=>$usertype,
                    'description'=>$desc
                ];
                ChefRegistrationInfo::create($insertData);
                DB::commit();
                Helper::myLog('Chef Registration Info : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Registration Info : exception');
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

        $chefRegInfo =ChefRegistrationInfo::where('id', $id)->first();
        $countries = Countries::whereIn('id', [30,101,231,38,142])->pluck('name', 'id');
        $states = States::where('country_id',$chefRegInfo->country_id)->pluck('name','id');

        $pageData = [
            "title" => Config::get('constants.title.category_edit'),
            'chefRegInfo' => $chefRegInfo,
            'countries' => $countries,
            'states' => $states
            ];
        return view('admin.chef-regi-info.edit', $pageData);
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
        Helper::myLog('Chef Registration Info update : start');
        try {

            $country_id = $request->country_id;
            $state_id = $request->state_id;
            $desc=$request->summary_ckeditor;
            $usertype=$request->user_type;
            $checkName = ChefRegistrationInfo::where('country_id',$country_id)
                        ->where('state_id',$state_id)
                        ->where('user_type',$usertype)
                        ->where('id', '!=', $id)->count();

            if ($checkName > 0) {
                Helper::myLog('Chef Registration Info update : Infromation is exists');
                return response()->json(['status' => 409, 'message' => 'Infromation is already exists!']);
            } else {
                $updateData = [
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'user_type'=>$usertype,
                    'description'=>$desc
                ];

                ChefRegistrationInfo::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('Chef Registration Info update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Registration Info update : exception');
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
        Helper::myLog('Chef Registration info delete : start');
        try {

            ChefRegistrationInfo::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Chef Registration info delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Registration info delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $exception->getMessage()], 200);

        }
    }
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = ChefRegistrationInfo::whereIn('id', explode(",", $ids))->delete();
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_success_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }

}
