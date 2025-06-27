<?php

use Illuminate\Database\Seeder;
use App\Model\Roles;
use App\Model\Helper;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $roleList = [
            'Super Admin','Admin','Vendor','Account'
        ];

        foreach ($roleList as $key => $value) {
            $count = Roles::where('name', $value)->count();
            if ($count == 0) {
                $date = date('Y-m-d H:i:s');
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'name' => $value,
                    'created_at' => $date,
                    'updated_at' => $date
                ];

                Roles::create($insertData);
            }
        }
    }
    
}
