<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Admin extends Authenticatable {

    use Notifiable;

    const ACTIVE = 'A';
    const INACTIVE = 'I';
    const DELETED = 'D';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'admin';
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public static function addNew($input)
    {
        $check = self::where('provider_id',$input['provider_id'])->first();

        if(is_null($check)){
            return self::create($input);
        }
        return $check;
    }
    public function role()
    {
        return $this->belongsTo('App\Model\Roles','role_id','id');
    }

}
