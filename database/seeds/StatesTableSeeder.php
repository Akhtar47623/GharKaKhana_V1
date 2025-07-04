<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Model\Countries;
use App\Model\States;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = File::get('database/seeds/data-json/states.json');
        $stateList = json_decode($data, true);
        foreach ($stateList['states'] as $key => $value) {
            $stateName = $value['name'];
            $countryId = $value['country_id'];
            $slug = strtolower(str_replace(' ', '-', $stateName));

            $checkCountry = Countries::where('id', $countryId)->count();
            if ($checkCountry > 0) {
                $count = States::where('slug', $slug)->where('country_id', $countryId)->count();
                if ($count == 0) {
                    $insertData = [
                        'id' => $value['id'],
                        'name' => $stateName,
                        'slug' => $slug,
                        'country_id' => $countryId
                    ];
                    States::create($insertData);
                }
            }
        }
    }
}
