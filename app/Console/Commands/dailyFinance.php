<?php

namespace App\Console\Commands;

use App\Models\Branch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class dailyFinance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily-finance:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Daily finance for branches.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all_branches = Branch::where('status', '1')->get();
        $total_cod_amount = 0;

        foreach ($all_branches as $branch) {
            $order_details = $branch->order->where('branch_finance_id', NULL)->where('status', 9);
            $order_count = count($order_details);

            if($order_count > 0){
                foreach ($order_details as $order) {
                    $total_cod_amount += $order->cod_amount;
                }

                DB::transaction(function () use($total_cod_amount, $order_count, $branch, $order_details){
                    $finance_info = \App\Models\DailyFinance::create([
                        'bill_date' => date('Y-m-d'),
                        'total_cod_amount' => $total_cod_amount,
                        'order_count' => $order_count,
                        'branch_id' => $branch->branch_id,
                    ]);

                    foreach ($order_details as $order) {
                        $order->update([
                            'branch_finance_id' => $finance_info->daily_finance_id,
                        ]);
                    }

                });

            }
        }
        dd('daily finance generated.');
    }
}
