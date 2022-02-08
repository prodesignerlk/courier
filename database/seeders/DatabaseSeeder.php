<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            DistrictSeeder::class,
            CitySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            FeatureSeeder::class,
            BranchSeeder::class,
            OrderStatusSeeder::class,
        ]);
    }
}
