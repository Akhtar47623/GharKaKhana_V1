<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    //
     use SoftDeletes;
    protected $table = "discount";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
