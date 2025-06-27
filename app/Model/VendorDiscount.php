<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorDiscount extends Model
{
    use SoftDeletes;
    protected $table = "vendor_discount";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
    public function user(){
     	return $this->belongsTo('App\Model\Admin','user_id','id');
	}
}
