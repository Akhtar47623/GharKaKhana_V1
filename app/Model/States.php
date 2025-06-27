<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class States extends Model
{
    use SoftDeletes;
    protected $table = "states";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    static function listByCountry($countryId)
    {
        return self::where('country_id', $countryId)->orderBy('name', 'ASC')->get();
    }

    static function nameById($stateId)
    {
        $stateData = self::where('id', $stateId)->first();
        $stateName = '';
        if (!empty($stateData)) {
            $stateName = $stateData->name;
        }
        return $stateName;
    }
}
