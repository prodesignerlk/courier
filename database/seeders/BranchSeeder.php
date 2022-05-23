<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            'branch_1' => ['branch_code' => 'COL1', 'branch_name' => 'Colombo Branch', 'branch_address' => 'Colombo 3', 'branch_city' => 2, 'branch_district' => 1, 'branch_tp' => 0112715464, 'branch_email' => 'col@qds.lk', 'status' => 1,],
            'branch_2' => ['branch_code' => 'RAT1', 'branch_name' => 'Rathnapura Branch', 'branch_address' => 'Town Rathnapura', 'branch_city' => 5, 'branch_district' => 2, 'branch_tp' => 0452715464, 'branch_email' => 'rath@qds.lk', 'status' => 1,]
        ];

        foreach($branches as $branch){
            Branch::create([
                'branch_code' => $branch['branch_code'],
                'branch_name' => $branch['branch_name'],
                'branch_address' => $branch['branch_address'],
                'branch_city' => $branch['branch_city'],
                'branch_district' => $branch['branch_district'],
                'branch_tp' => $branch['branch_tp'],
                'branch_email' => $branch['branch_email'],
                'status' => $branch['status'],
            ]);
        }
    }
}
