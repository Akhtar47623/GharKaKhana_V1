<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderItemOptions extends Model
{
    use SoftDeletes;
    protected $table = "order_item_options";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}