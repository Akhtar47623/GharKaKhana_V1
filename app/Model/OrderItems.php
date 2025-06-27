<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderItems extends Model
{
    use SoftDeletes;
    protected $table = "order_items";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function menu(){
     	return $this->belongsTo('App\Model\Menu','menu_id','id');
 	}
 	public function orderItemOptions()
    {
        return $this->hasMany('App\Model\OrderItemOptions','order_item_id','id');
    }
}
