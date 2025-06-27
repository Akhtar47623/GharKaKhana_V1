<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RolesRequest;
use Illuminate\Support\Facades\Auth;
use App\Model\Roles;
use App\Model\Permissions;
use App\Model\PermissionRole; 
use App\Model\Admin;
use App\Model\Helper;
use Datatables;
use Redirect;
use Session;
use Config;
use File;
use Log;
use DB;
use Toastr;


class RolesController extends Controller {


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $role = Roles::where('id','!=',1)->get();
        $checkPermission = Permissions::checkActionPermission('view_roles');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $pageData = ['title' => Config::get('constants.title.roles'),'role' => $role];
        return view('admin.roles.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $checkPermission = Permissions::checkActionPermission('add_roles');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $pageData = ["title" => Config::get('constants.title.roles_add')];
        return view('admin.roles.create', $pageData);
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
        Helper::myLog('Role store : start');
        try {
            $name = $request->name;
            $uuid = Helper::getUuid($request->uuid);
            $checkName = Roles::where('name', $name)->count();
          
              if ($checkName > 0) {
                Helper::myLog('Role store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The role name is already exists!']);
            }else {
                $insertData = [
                     'name' => $name,
                     'uuid' => $uuid,
                     'created_at' => date('Y-m-d H:i:s'),   
                ];
                Roles::create($insertData);
                DB::commit();
                Helper::myLog('Roles store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('User store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been saved!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $role) {
        if (!empty($role)) {
            $pageData = ["title" => Config::get('constants.title.roles_edit'), 'roles' => $role];
            return view('admin.roles.edit', $pageData);
        }
        return Redirect::back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        DB::beginTransaction(); // Begin Transaction
        try {

            $name = $request->name;
            $checkName = Roles::where('name', $name)->where('id', '!=', $id)->count();
            if ($checkName > 0) {
                Helper::myLog('Role store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The role name is already exists!']);
            } else {
                $updateData = [
                  'name' => $name,
               ];
               Roles::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('Role update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Role update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been updated!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::beginTransaction();
        Helper::myLog('Role delete : start');
        try {

            Roles::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Role delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Role delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }

    /**
     * Remove the multiple resource from storage.
     *
     * @param  ids(required)
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = Roles::whereIn('id', explode(",", $ids))->delete();
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_success_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }
    public function show() {
        
    }
   
    public function permission($uuid)
    {
        $pageData = ["title" => Config::get('constants.title.permission')];
        Helper::myLog('Permission role : start');
        try {
            $checkPermission = Permissions::checkActionPermission('update_roles');
            if ($checkPermission == false) {
                return view('backend.access-denied');
            }
            $roleData = Roles::where('uuid', $uuid)->first();

            if (!empty($roleData)) {
                $roleId = $roleData->id;
                $allowPermissionList = [];
                $rolePermissionList = PermissionRole::join('permission AS P', 'P.id', '=', 'role_permission.permission_id')
                    ->where('role_permission.role_id', $roleId)
                    ->select(['name'])
                    ->get();
                    
                foreach ($rolePermissionList as $value) {
                    array_push($allowPermissionList, $value->name);
                }
                $roleData->allowPermission = $allowPermissionList;

                $roleData->actionList = Permissions::actionList();
                $roleData->moduleList = Permissions::permissionList();
                $roleData->permissionList = Permissions::allPermission();
                Helper::myLog('Permission role : finish');
                return view('admin.roles.permission',$pageData, compact('roleData'));
            } else {
                return redirect(env('BACKEND') . '/roles')->with('error', 'Ooops...Something went wrong. Data not found.');
            }
        } catch (\Exception $exception) {
            Helper::myLog('Permission role : exception');
            Helper::myLog($exception);
            return redirect(env('BACKEND') . '/roles')->with('error', 'Ooops...Something went wrong.');
        }
    }
    public function permissionStore(Request $request, $uuid)
    {
        Helper::myLog('Role Permission store : start');
        DB::beginTransaction();
        try {

            $roleData = Roles::where('uuid', $uuid)->first();
            $roleId = $roleData->id;
       
          PermissionRole::where('role_id', $roleId)->delete();
           $permissions = $request->permissions;
            if (isset($permissions) && count($permissions) > 0) {
               foreach ($permissions as $value) {
                   $permissionData = Permissions::where('name', $value)->first();
                   if (!empty($permissionData)) {
                       $data = [
                           'role_id' => $roleId,
                           'permission_id' => $permissionData->id
                        ];

                        PermissionRole::create($data);
                   }
               }
           }
                Helper::myLog('Role Permission store : finish');
                DB::commit();
                Toastr::success(Config::get('constants.message.edit'), 'Edit');
               return \Response::json(['status' => 1, 'msg' => Config::get('onstants.message.edit'),'redirect'=>route('roles.index')]);
            // return response()->json(['status' => 200, 'message' => 'Role permission has been updated!']);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback(); // Rollback Transaction
            Log::error("QueryException While Create new Role, " . $e->getMessage());
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return \Response::json(['status' => 0, 'msg' => Config::get('constants.message.oops')]);
        }
    }
}