<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class UsedCoupons extends Model
{
   
    protected $table = "used_coupons";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
