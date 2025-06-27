<?php

use Illuminate\Database\Seeder;
use App\Model\Admin;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     * php artisan db:seed --class=UsersTableSeeder
     * @return void
     */
    public function run() { 
        $addUsers = [
                ['role_id' => '1',
                'uuid' => 'c37ab70f-e34e-11e9-84cb-386077062cca',
                'display_name' => 'Ali Khorasanee',
                'first_name' => 'Ali', 
                'last_name' => 'Khorasanee', 
                'email' => 'admin@admin.com', 
                'phone' => '8324210735',
                'password' => bcrypt('admin123'),
                'full_address' => 'Full Address',
                'country_id' => '1',
                'state_id' => '1',
                'city_id' => '1',
                'zip_code' => '1',
                'device_type_id' => '1',
                'device_token' => '1',
                'api_token' => '1',
                 'profile' => 'default.png',
                 'email_verified_at' => '1',
                 'remember_token' =>'',
                 'created_at' => Carbon::now(),
                 'updated_at' => Carbon::now()],
                 
        ];
        Admin::insert($addUsers);
    }

}
