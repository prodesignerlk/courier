<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = [
            'Quicklk.com' => ['name' => 'Quicklk.com', 'tp_1' => '+94112564543']
        ];

        foreach($organizations as $org){
            Organization::create([
                'org_name' => $org['name'],
                'org_tp_1' => $org['tp_1']
            ]);
        }
    }
}
