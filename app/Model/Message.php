<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";

    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function user()
	{
	    return $this->belongsTo('App\Model\Users','from_id','id');
	}
	public function chef()
	{
	    return $this->belongsTo('App\Model\Users','to_id','id');
	}

	
}
