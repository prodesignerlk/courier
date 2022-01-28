<?php

namespace Database\Seeders;

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
            'sajana' => ['name' => 'Institute', 'email' => 'ins@ins.lk', 'password' => 'password']
        ];

        foreach($users as $user){
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'email_verified_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}