<?php

namespace Database\Seeders;

use App\Models\Seller;
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
            'Sangeeth' => ['name' => 'Sangeeth Fernando', 'email' => 'sangeeth@qds.lk', 'password' => 'password', 'model' => 'Super Admin'],
            'Isuru' => ['name' => 'Isuru Fernando', 'email' => 'isuru@qds.lk', 'password' => 'password', 'model' => 'Seller',
                        'store_name' => 'Isuru Super', 'tp1' => '0717122252', 'address' => '66/5, Kalawana', 'city' => '18', 'district' => '1477',
                        'payment_period' => '7', 'regular_price' => '280', 'extra_price' => '80', 'handeling_fee' => '1']
        ];

        foreach($users as $user){
            $user_info = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'email_verified_at' => date('Y-m-d H:i:s'),
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
                    'handeling_fee' => $user['handeling_fee'],
                    'user_id' => $user_info->id,
                ]);
            }
        }

        $user = User::find(1);
        $user->assignRole('Super Admin');

        $user = User::find(2);
        $user->assignRole('Seller');
    }
}
