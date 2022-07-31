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

            //order
            'order.create',
            'order.view',

            'pickup-pending.view',
            'pickup-collected.view',
            'pickup-dispatched.view',

            'order-collected.view',
            'order-dispatched.view',
            'order-to-be-receive.view',
            'order-received.view',
            'order-assign-to-agent.view',
            'order-delivered.view',
            'order-reschedule.view',
            'order-deliver-fail.view',
            'order-miss-route.view',
            'order-re-route.view',

            'order-return-to-hub.view',
            'order-return-to-seller.view',

            //invoice
            'invoice.view',
            'daily-invoice.view',
            'daily-deposit.view',
            'daily-deposit.confirm',

            //status
            'pickup-collected.mark',
            'pickup-dispatched.mark',

            'order-collected.mark',
            'order-dispatch.mark',
            'order-received.mark',
            'order-assign-to-agent.mark',
            'order-delivered.mark',
            'order-reschedule.mark',
            'order-re-route.mark',

            'order-return-to-hub.mark',
            'order-return-to-seller.mark',

            //Settings
            'setting.view',
            'setting.create',

            //seller
            'seller.view',
            'seller.create',

            //rider
            'rider.view',
            'rider.create',
        ];

        foreach ($permission_info as $permission) {
            Permission::create(['name' => $permission]);
        }

        $permission_list = [
            ['category' => 'waybill-reservation', 'view' => '1', 'create' => '1', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'order', 'view' => '1', 'create' => '1', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'pickup-pending', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'pickup-collected', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '1'],
            ['category' => 'pickup-dispatched', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '1'],
            ['category' => 'order-collected', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '1'],
            ['category' => 'order-dispatched', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '1'],
            ['category' => 'order-to-be-receive', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'order-assign-to-agent', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '1'],
            ['category' => 'order-delivered', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '1'],
            ['category' => 'order-reschedule', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '1'],
            ['category' => 'order-deliver-fail', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'order-miss-route', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'order-re-route', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '1'],
            ['category' => 'order-deliver-fail', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'invoice', 'view' => '1', 'create' => '0', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'daily-invoice', 'view' => '1', 'create' => '0', 'confirm' => '1', 'mark' => '0'],
            ['category' => 'seller', 'view' => '1', 'create' => '1', 'confirm' => '0', 'mark' => '0'],
            ['category' => 'rider', 'view' => '1', 'create' => '1', 'confirm' => '0', 'mark' => '0'],
        ];

        foreach ($permission_list as $permission) {

            PermissionList::create([
                'name' => $permission['category'],
                'view' => $permission['view'],
                'create' => $permission['create'],
                'confirm' => $permission['confirm'],
                'mark' => $permission['mark'],
            ]);

        }

        //permission
        $permissions = [
            ['role' => 'Seller', 'permission' => [
                    'waybill-reservation.view',
                    'waybill-reservation.create',

                    'order.create',
                    'order.view',
                    'pickup-pending.view',
                    'pickup-collected.view',
                    'pickup-dispatched.view',
                    'order-collected.view',
                    'order-dispatched.view',
                    'order-to-be-receive.view',
                    'order-received.view',
                    'order-assign-to-agent.view',
                    'order-delivered.view',
                    'order-reschedule.view',
                    'order-deliver-fail.view',
                    'order-miss-route.view',
                    'order-re-route.view',

                    'invoice.view',
                ]
            ],

            ['role' => 'Rider', 'permission' => [
                    'order.view',
                    'order-delivered.mark',
                    'order-reschedule.mark',
                    'order-re-route.mark',
                ]
            ]

        ];

        foreach ($permissions as $per) {
            $role = Role::findByName($per['role']);
            foreach ($per['permission'] as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
