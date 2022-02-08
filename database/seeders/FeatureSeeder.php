<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            //waybill feature
            'waybill_option1' => ['model' => 'WaybillOption', 'option' => 'Auto Increment', 'description' => 'Automatically increase waybill one by one. There is not a Waybill reservation section'],
            'waybill_option2' => ['model' => 'WaybillOption', 'option' => 'Manual Range', 'description' => 'User have to have defind waybill ranges.'],
            'waybill_option3' => ['model' => 'WaybillOption', 'option' => 'Manual Qnt', 'description' => 'User have to have defind waybill quantity.'],

            //sms feature
            'SmsOption1' => ['model' => 'SmsOption', 'option' => 'Lankabell', 'description' => 'Lankabell sms gateway.'],
            'SmsOption2' => ['model' => 'SmsOption', 'option' => 'Dialog', 'description' => 'Dialog sms gateway.'],
        ];

        foreach($features as $feature){
            $model = 'App\Models\\'.$feature['model'];

            $model::create([
                'option' => $feature['option'],
                'description' => $feature['description'],
            ]);
        }

    }
}
