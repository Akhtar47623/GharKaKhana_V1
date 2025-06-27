<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChefDiscount extends Model
{
    //
    use SoftDeletes;
    protected $table = "chef_discount";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
