<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MexicoInvoice extends Model
{
    use SoftDeletes;
    protected $table = "mexico_invoices";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function orderItems()
    {
        return $this->hasMany('App\Model\OrderItems','order_id','id');
    }
    public function orderItemOptions()
    {
        return $this->hasMany('App\Model\OrderItemOptions','order_item_id','id');
    }
    public function user(){
     	return $this->belongsTo('App\Model\Users','cust_id','id');
 	}
 	 public function chef(){
        return $this->belongsTo('App\Model\Users','chef_id','id');
    }

}