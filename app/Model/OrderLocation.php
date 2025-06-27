<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderLocation extends Model
{
    use SoftDeletes;
    protected $table = "order_location";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}