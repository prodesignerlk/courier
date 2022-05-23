<?php

namespace Database\Seeders;

use App\Models\PermissionList;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_info = [

            //waybill
            'waybill-reservation.view',
            'waybill-reservation.create',
            
        ];

        foreach($permission_info as $permission){
            Permission::create(['name' => $permission]);
        }

        $permission_list = [
            'waybill-reservation' => ['catagory' => 'waybill-reservation', 'view' => '1', 'create' => '1'],            
        ];

        foreach($permission_list as $permission){
            
                PermissionList::create([
                    'name' => $permission['catagory'],
                    'view' => $permission['view'],
                    'create' => $permission['create'],
                ]);
            
        }

        //permission
        // $permissions = [
        //     'Seller' => ['role' => 'Seller', 'permission' => 'waybill-reservation.view'],
        // ];

        // foreach($permissions as $per){
        //     $role = Role::where('name', $per['role'])->first();
        //     $role->givePermissionTo($per['permission']); 
        // }
    }
}
