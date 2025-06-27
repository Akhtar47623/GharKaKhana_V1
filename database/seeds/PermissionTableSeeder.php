<?php

use Illuminate\Database\Seeder;
use App\Model\Permissions;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionList = Permissions::allPermission();
        
        foreach ($permissionList as $value) {
            $count = Permissions::where('name', $value)->count();
            if ($count == 0) {
                Permissions::create(['name' => $value]);
            }
        }
    }
}