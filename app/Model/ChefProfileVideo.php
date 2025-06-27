<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ChefProfileVideo extends Model
{
    use SoftDeletes;
    protected $table = "chef_profile_video";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    
}
