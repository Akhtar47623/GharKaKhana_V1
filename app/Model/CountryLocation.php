<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Model\Countries;

class CountryLocation extends Model
{	
	use SoftDeletes;
    protected $table = "country_location";
    protected $primaryKey = "id";

    protected $guarded = ['id'];


	public function country()
	{
	  return $this->belongsTo('App\Model\Countries');
	}

}

