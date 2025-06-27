<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $table = "ticket";
    protected $guarded = ['id'];


    public function category()
    {
        return $this->belongsTo('App\Model\TicketCategory','category_id','id');
    }
    public function messages()
    {
        return $this->hasMany('App\Model\TicketMessage','ticket_id','id')->where('seen','0');
    }
    public function user(){
        return $this->belongsTo('App\Model\Users','user_id','id');
    }
    public function order(){
        return $this->belongsTo('App\Model\Order','order_id','id');
    }
     public function chef(){
        return $this->belongsTo('App\Model\Users','to_id','id');
    }
}
