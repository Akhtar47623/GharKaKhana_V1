<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Model\States;
use App\Model\Cities;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = File::get('database/seeds/data-json/cities.json');
        $cityList = json_decode($data, true);

        foreach ($cityList['cities'] as $key => $value) {
            $cityName = $value['name'];
            $stateId = $value['state_id'];
            $slug = strtolower(str_replace(' ', '-', $cityName));

            $checkState = States::where('id', $stateId)->count();
            if ($checkState > 0) {
                $count = Cities::where('slug', $slug)->where('state_id', $stateId)->count();
                if ($count == 0) {
                    $insertData = [
                        'id' => $value['id'],
                        'name' => $cityName,
                        'slug' => $slug,
                        'state_id' => $stateId
                    ];
                    Cities::create($insertData);
                }
            }
        }

        $data = File::get('database/seeds/data-json/cities1.json');
        $cityList = json_decode($data, true);

        foreach ($cityList['cities'] as $key => $value) {
            $cityName = $value['name'];
            $stateId = $value['state_id'];
            $slug = strtolower(str_replace(' ', '-', $cityName));
            $checkState = States::where('id', $stateId)->count();
            if ($checkState > 0) {
                $count = Cities::where('slug', $slug)->where('state_id', $stateId)->count();
                if ($count == 0) {
                    $insertData = [
                        'id' => $value['id'],
                        'name' => $cityName,
                        'slug' => $slug,
                        'state_id' => $stateId
                    ];
                    Cities::create($insertData);
                }
            }
        }

        $data = File::get('database/seeds/data-json/cities2.json');
        $cityList = json_decode($data, true);

        foreach ($cityList['cities'] as $key => $value) {
            $cityName = $value['name'];
            $stateId = $value['state_id'];
            $slug = strtolower(str_replace(' ', '-', $cityName));
            $checkState = States::where('id', $stateId)->count();
            if ($checkState > 0) {
                $count = Cities::where('slug', $slug)->where('state_id', $stateId)->count();
                if ($count == 0) {
                    $insertData = [
                        'id' => $value['id'],
                        'name' => $cityName,
                        'slug' => $slug,
                        'state_id' => $stateId
                    ];
                    Cities::create($insertData);
                }
            }
        }

        $data = File::get('database/seeds/data-json/cities3.json');
        $cityList = json_decode($data, true);

        foreach ($cityList['cities'] as $key => $value) {
            $cityName = $value['name'];
            $stateId = $value['state_id'];
            $slug = strtolower(str_replace(' ', '-', $cityName));
            $checkState = States::where('id', $stateId)->count();
            if ($checkState > 0) {
                $count = Cities::where('slug', $slug)->where('state_id', $stateId)->count();
                if ($count == 0) {
                    $insertData = [
                        'id' => $value['id'],
                        'name' => $cityName,
                        'slug' => $slug,
                        'state_id' => $stateId
                    ];
                    Cities::create($insertData);
                }
            }
        }

        $data = File::get('database/seeds/data-json/cities4.json');
        $cityList = json_decode($data, true);

        foreach ($cityList['cities'] as $key => $value) {
            $cityName = $value['name'];
            $stateId = $value['state_id'];
            $slug = strtolower(str_replace(' ', '-', $cityName));
            $checkState = States::where('id', $stateId)->count();
            if ($checkState > 0) {
                $count = Cities::where('slug', $slug)->where('state_id', $stateId)->count();
                if ($count == 0) {
                    $insertData = [
                        'id' => $value['id'],
                        'name' => $cityName,
                        'slug' => $slug,
                        'state_id' => $stateId
                    ];
                    Cities::create($insertData);
                }
            }
        }
    }
}
