<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Users extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
    * Social Login Check
    */
    public static function addNew($input)
    {
        $check = self::where('provider_id',$input['provider_id'])->first();
        if(is_null($check)){
            $checkEmail = self::where('email',$input['email'])->where('type','Customer')->count();

            if($checkEmail==0){
                return self::create($input);
            }
        }
        return $check;
    }

    public function business()
    {
        return $this->hasOne('App\Model\Business','id','chef_id');       
    }
    public function location()
    {
        return $this->hasOne('App\Model\CustLocation','cust_id','id');       
    }
    public function country()
    {
        return $this->belongsTo('App\Model\Countries','country_id','id');
    }
    static public function getCountryState($chef_id){
        $selectedItems = ['users.country_id as country_id','chef_location.state_id as state_id'];
        $userLocation = self::select($selectedItems)
                    ->leftjoin('chef_location', 'chef_location.chef_id', 'users.id')
                    ->where('users.id',$chef_id)->first();
        return $userLocation;       
    }

    public function ratings()
    {
        return $this->hasMany('App\Model\ReviewRating','chef_id');
    }
    public function chefLocation()
    {
        return $this->hasOne('App\Model\Location','chef_id','id')->select(['id','address','city_id','state_id','chef_id']);
    }
    public function chefBussiness()
    {
        return $this->hasOne('App\Model\Business','chef_id','id')->select(['id', 'description','cuisine', 'chef_id']);
    }
    public function chefMenu()
    {
        return $this->hasMany('App\Model\Menu','chef_id','id');
    }
    
    public function messages()
    {
        return $this->hasMany('App\Model\Message','chef_id');
    }
}
