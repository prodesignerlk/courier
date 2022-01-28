<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'waybill_option' => ['feature' => 'waybill_option', 'relevent_model' => 'WaybillOption'],
            'sms_option' => ['feature' => 'sms_option', 'relevent_model' => 'SmsOption']
        ];

        foreach($settings as $setting){
            Setting::create([
                'feature' => $setting['feature'],
                'relevent_model' => $setting['relevent_model'],
            ]);
        }
    }
}
