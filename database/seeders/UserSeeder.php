<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'Sangeeth' => ['name' => 'Sangeeth Fernando', 'email' => 'sangeeth@qds.lk', 'password' => 'password', 'model' => 'Super Admin', 'branch_staff' => '0'],

            'Isuru' => ['name' => 'Isuru Fernando', 'email' => 'isuru@qds.lk', 'password' => 'password', 'model' => 'Seller',
                        'store_name' => 'Isuru Super', 'tp1' => '0717122252', 'address' => '66/5, Kalawana', 'city' => '184', 'district' => '14',
                        'payment_period' => '7', 'regular_price' => '280', 'extra_price' => '80', 'handling_fee' => '1', 'branch_staff' => '0'],

            'Rashmika' => ['name' => 'Rashmika Fernando', 'email' => 'rashmika@qds.lk', 'password' => 'password', 'model' => 'Staff',
                        'staff_position' => 'Rider', 'staff_nic' => '9785684542V', 'staff_address' => '66/5, Kandy Rd, Haputhale',
                        'staff_contact_1' => '0717155565', 'staff_contact_2' => '0452255458', 'branch_id' => '1', 'branch_staff' => '1']
        ];

        foreach($users as $user){
            $user_info = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'branch_staff' => $user['branch_staff']
            ]);

            if($user['model'] == 'Seller'){
                Seller::create([
                    'seller_name' => $user['store_name'],
                    'seller_tp_1' => $user['tp1'],
                    'address_line_1' => $user['address'],
                    'city_id' => $user['city'],
                    'district_id' => $user['district'],
                    'payment_period' => $user['payment_period'],
                    'regular_price' => $user['regular_price'],
                    'extra_price' => $user['extra_price'],
                    'handling_fee' => $user['handling_fee'],
                    'user_id' => $user_info->id,
                ]);
            }

            if($user['model'] == 'Staff'){
                Staff::create([
                    'staff_position' => $user['staff_position'],
                    'staff_nic' => $user['staff_nic'],
                    'staff_address' => $user['staff_address'],
                    'staff_contact_1' => $user['staff_contact_1'],
                    'staff_contact_2' => $user['staff_contact_2'],
                    'branch_id' => $user['branch_id'],
                    'user_id' => $user_info->id,
                ]);
            }
        }

        $user = User::find(1);
        $user->assignRole('Super Admin');

        $user = User::find(2);
        $user->assignRole('Seller');

        $user = User::find(3);
        $user->assignRole('Rider');
    }
}
