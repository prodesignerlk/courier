<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasons = [
            'r1' => ['name' => 'Customer unavailable', 'model' => 'RescheduleReason'],
            'r2' => ['name' => 'Customer rejected', 'model' => 'RescheduleReason'],
            'r3' => ['name' => 'Wrong Package', 'model' => 'DeliverFailReason'],
        ];

        foreach($reasons as $reason){
            $model = 'App\Models\\'.$reason['model'];
            $model::create([
                'reason' => $reason['name'],
            ]);
        }
    }
}
