<?php

namespace Database\Seeders;

use App\Models\Bank;
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
                $sellerInfo = Seller::create([
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

                Bank::create([
                    'bank_name' => $user['bank_name'],
                    'branch_name' => $user['bank_branch'],
                    'account_no' => $user['account_no'],
                    'seller_id' => $sellerInfo->seller_id
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
    }
}
