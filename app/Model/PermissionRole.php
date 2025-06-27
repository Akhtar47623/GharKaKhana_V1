<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'role_permission';
    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'permission_id',
        'created_at',
        'updated_at'
    ];
}