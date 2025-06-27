<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Permissions extends Model
{
     protected $table = 'permission';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guard = 'admin';

    protected $guarded = ['id'];

    public static function actionList()
    {
        $list = ["view", "create", "update", "delete"];
        return $list;
    }

    public static function permissionList()
    {
        $permissionList = ['dashboard', 'roles', 'users', 'chef_list','countries', 'states', 'cities','cuisine','taxes','category','chef_reg_info','discount','vendor_discount','country_location','invoice','support','contactus','ticket','ticket_category'];
        return $permissionList;
    }

    public static function allPermission()
    {
        $permissionList = self::permissionList();

        $action = self::actionList();
        $permission = [];
        foreach ($permissionList as $value) {
            if ($value == 'dashboard') {
                array_push($permission, $action[0] . "_" . $value);
            } else if ($value == 'chef_list') {
                array_push($permission, $action[0] . "_" . $value);
                array_push($permission, $action[2] . "_" . $value);
            } else{
                for ($i = 0; $i < 4; $i++) {
                    array_push($permission, $action[$i] . "_" . $value);
                }
            }
        }
        return $permission;
    }

    public static function checkActionPermission($permissionName)
    {
        $userData = Auth::guard('admin')->user();
        if (!empty($userData)) {
            $roleId = $userData->role_id;
            if ($roleId == 1) {
                return true;
            }

            if (!is_array($permissionName)) {
                $permissionName = [$permissionName];
            }

            $checkPermission = PermissionRole::join('permission AS P', 'P.id', '=', 'role_permission.permission_id')
                ->where('role_permission.role_id', $roleId)
                ->whereIn('P.name', $permissionName)
                ->count();
            if ($checkPermission == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}