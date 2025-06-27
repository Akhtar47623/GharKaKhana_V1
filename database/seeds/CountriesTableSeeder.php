<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Model\Countries;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = File::get('database/seeds/data-json/countries.json');
        $countryList = json_decode($data, true);
        foreach ($countryList['countries'] as $key => $value) {
            $countryName = $value['name'];
            $slug = strtolower(str_replace(' ', '-', $countryName));
            $count = Countries::where('slug', $slug)->count();
            if ($count == 0) {
                $insertData = [
                    'id' => $value['id'],
                    'sortname' => $value['sortname'],
                    'name' => $countryName,
                    'slug' => $slug,
                    'phone_code' => $value['phone_code']
                ];
                Countries::create($insertData);
            }
        }
    }
}
