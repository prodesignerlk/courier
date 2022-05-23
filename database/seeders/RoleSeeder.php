<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_role = [
            'Super Admin',
            'Branch',
            'Seller',
            'Rider',
        ];
        foreach($user_role as $role){
            Role::create(['name' => $role]);
        }
    }
}
