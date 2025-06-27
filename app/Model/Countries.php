<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Countries extends Model
{
    use SoftDeletes;
    protected $table = "countries";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
    
    static function nameById($countryId)
    {
        $countryData = self::where('id', $countryId)->first();
        $countryName = '';
        if (!empty($countryData)) {
            $countryName = $countryData->name;
        }
        return $countryName;
    }
}
