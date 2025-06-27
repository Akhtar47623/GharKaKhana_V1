<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustLocation extends Model
{
    use SoftDeletes;
    protected $table = "customer_location";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public static function customerAddress($custId)
    {
    	$custAddressData = self::where('cust_id',$custId)->first();
    	$address = $custAddressData->address;

    	return $address;
    }
    
}
