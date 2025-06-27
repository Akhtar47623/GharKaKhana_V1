<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Taxes extends Model
{
    use SoftDeletes;
    protected $table = "taxes";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    static function listByState($stateId)
    {
        return self::where('state_id', $stateId)->orderBy('name', 'ASC')->get();
    }
    static function nameById($cityId)
    {
        $cityData = self::where('id', $cityId)->first();
        $cityName = '';
        if (!empty($cityData)) {
            $cityName = $cityData->name;
        }
        return $cityName;
    }
}