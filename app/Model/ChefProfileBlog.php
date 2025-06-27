<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChefProfileBlog extends Model
{
    use SoftDeletes;
    protected $table = "chef_profile_blog";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

}
