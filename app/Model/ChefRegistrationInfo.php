<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ChefRegistrationInfo extends Model
{
    use SoftDeletes;
    protected $table = "chef_registration_info";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    
}