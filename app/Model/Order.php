<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes;
    protected $table = "order";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    const FAIL = '1';
    const SUCCESS = '2';
    const CANCEL = '3';
    const ACCEPT = '4';
    const READY = '5';
    const OUT = '6';
    const DELIVERED = '7';

    public function orderItems()
    {
        return $this->hasMany('App\Model\OrderItems','order_id','id');
    }
    
    public function user(){
     	return $this->belongsTo('App\Model\Users','cust_id','id');
 	}
 	 public function chef(){
        return $this->belongsTo('App\Model\Users','chef_id','id');
    }
     public function chefBusiness(){
        return $this->belongsTo('App\Model\Business','chef_id','chef_id');
    }
    public function orderMessages(){
         return $this->hasMany('App\Model\TicketMessage','order_id','id')->where('seen','0')->where('from_id','!=',auth('front')->user()->id);
    }
    public function invoice(){
        return $this->belongsTo('App\Model\MexicoInvoice','id','order_id');    
    }
}