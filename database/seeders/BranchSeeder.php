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
        Branch::create([
            'branch_code' => 'COL1',
            'branch_name' => 'Colombo Branch',
            'branch_address' => 'Colombo 3',
            'branch_city' => 2,
            'branch_district' => 1,
            'branch_tp' => 0112715464,
            'branch_email' => 'col@qds.lk',
            'status' => 1,
        ]);
    }
}
