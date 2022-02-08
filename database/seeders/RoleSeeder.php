<?php

namespace Database\Seeders;

use App\Models\User;
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
        /** @var User $user */

        $user_role = [
            'Super Admin',
            'User',
            'Seller',
        ];
        foreach($user_role as $role){
            Role::create(['name' => $role]);
        }
    }
}
