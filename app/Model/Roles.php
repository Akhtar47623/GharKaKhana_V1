<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin;
use Session;

class Roles extends Model {

    use SoftDeletes;
    protected $table = "roles";
    protected $primaryKey = "id";

    protected $guard = 'admin';

    protected $guarded = ['id'];

    const ADMIN = 1;
    
}
