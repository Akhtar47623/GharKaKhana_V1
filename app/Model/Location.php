<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Location extends Model
{
    use SoftDeletes;
    protected $table = "chef_location";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function state()
    {
        return $this->belongsTo('App\Model\States','state_id','id');
    }
    public function city()
    {
        return $this->belongsTo('App\Model\Cities','city_id','id');
    }
    public static function chefAddress($chefId)
    {

        $chefAddressData = self::where('chef_id',$chefId)->first();
        $address = $chefAddressData->address;
        $city = Cities::select('name')->where('id',$chefAddressData->city_id)->first();
        $state = States::select('name')->where('id',$chefAddressData->state_id)->first();
        $userCountry=Users::select('country_id')->where('id',$chefId)->first();
        $country = Countries::select('name')->where('id',$userCountry->country_id)->first();
        $address = $address.','.$city->name; 
        $address = $address.','.$state->name;
        $address = $address.','.$country->name;
        return $address;
    }
}
