<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Menu extends Model
{
    use SoftDeletes;
    protected $table = "menu";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function menuOptions()
    {
        return $this->hasMany('App\Model\Options','menu_id','id')->where('status','1');
    }
    public function menuSchedule()
    {
        return $this->hasOne('App\Model\Schedule','menu_id','id');
    }
    

    public function menuNutrition()
    {
        return $this->hasOne('App\Model\Nutrition','menu_id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\Model\Users','chef_id','id')->select(array('id', 'display_name','profile_id','country_id'));
    }
    public function chefLocation()
    {
        return $this->hasOne('App\Model\Location','chef_id','chef_id')->select(['id','address' ,'city_id', 'chef_id']);
    }
    public function ratings()
    {
        return $this->hasMany('App\Model\ReviewRating','chef_id','chef_id');
    }
    public function service()
    {
        return $this->hasOne('App\Model\PickupDelivery','chef_id','chef_id');
    }
}




