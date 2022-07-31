<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            '1' => ['status' => 'Processing', 'color' => 'yellow'],
            '2' => ['status' => 'Pickup collected ny branch', 'color' => 'green'],
            '3' => ['status' => 'Pickup dispatched by branch', 'color' => 'blue'],
            '4' => ['status' => 'Pickup/reroute collected by delivery hub', 'color' => 'perple'],
            '5' => ['status' => 'Dispatched', 'color' => 'aqua'],
            '6' => ['status' => 'Received by branch', 'color' => 'ash'],
            '7' => ['status' => 'Assign to agent', 'color' => 'brown'],
            '8' => ['status' => 'Reschedule', 'color' => 'orange'],
            '9' => ['status' => 'Delivered', 'color' => 'green'],
            '10' => ['status' => 'Delivery fail', 'color' => 'red'],
            '11' => ['status' => 'Reroute', 'color' => 'pink'],
            '12' => ['status' => 'Return', 'color' => 'salmon'],
            '13' => ['status' => 'Return collected by delivery hub', 'color' => 'darkRed'],
            '14' => ['status' => 'Return to Seller', 'color' => 'lightGreen'],
        ];

        foreach ($status as $st) {
            OrderStatus::create([
                'status' => $st['status'],
                'color' => $st['color']
            ]);
        }
    }
}
