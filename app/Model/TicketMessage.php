<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketMessage extends Model
{
    use SoftDeletes;
    protected $table = "ticket_message";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function user(){
     	return $this->belongsTo('App\Model\Users','from_id','id');
 	}
 	 public function chef(){
     	return $this->belongsTo('App\Model\Users','to_id','id');
 	}
 	
}
