<?php

namespace App\Console\Commands;

use App\Models\InvoiceFail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class Invoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Invoices for sellers. Check seller invoice period and create relavent invoice.';

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
        $all_sellers = Role::where('name', 'Seller')->first()->users;

        foreach ($all_sellers as $seller) {
            $seller = $seller->seller;
            $payment_period = $seller->payment_period;
            $today = date('d');

            $total_cod_amount = 0;
            $total_delivery_cost = 0;
            $total_net_price = 0;
            $total_weight = 0;

            if ($today % $payment_period == 0) {
//            if (1) {

                $order_details = $seller->order->where('invoice_id', null)->whereIn('status', ['9', '10', '12', '13', '14']);

                if (count($order_details) > 0) {
                    foreach ($order_details as $order) {
                        if($order->status == 9){
                            $total_cod_amount += $order->cod_amount;
                        }

                        $total_weight += $order->package->package_weight;
                        $total_delivery_cost += $order->delivery_cost;
                        $total_net_price += $order->net_price;

                    }

                    if (($total_cod_amount - $total_delivery_cost) == $total_net_price) {
                        $handling_rate = $seller->handling_fee;
                        $total_handling_fee = ($handling_rate * $total_net_price) / 100;
                        $total_payable_price = $total_net_price - $total_handling_fee;

                        try {
                            DB::transaction(function () use ($total_weight, $order_details, $seller, $total_handling_fee, $total_delivery_cost, $total_cod_amount, $total_payable_price) {

                                $invoice_info = \App\Models\Invoice::create([
                                    'regular_price' => $seller->regular_price,
                                    'extra_price' => $seller->extra_price,
                                    'handling_free' => $seller->handling_fee,
                                    'total_cod_amount' => $total_cod_amount,
                                    'total_delivery_fee' => $total_delivery_cost,
                                    'total_handling_fee' => $total_handling_fee,
                                    'total_payable' => $total_payable_price,
                                    'total_weight' => $total_weight,
                                    'package_count' => count($order_details),
                                    'seller_id' => $seller->seller_id,
                                    'invoice_date' => date('Y-m-d H:i:s'),
                                ]);

                                foreach ($order_details as $order) {
                                    $order->update([
                                        'invoice_id' => $invoice_info->invoice_id,
                                    ]);
                                }

                            });

                        } catch (\Throwable $e) {
                            InvoiceFail::create([
                                'seller_id' => $seller->seller_id,
                                'fail_reason' => $e->getMessage(),
                            ]);
                        }


                    } else {
                        InvoiceFail::create([
                            'seller_id' => $seller->seller_id,
                            'fail_reason' => '(total_cod_amount - total_delivery_cost) != total_net_price',
                        ]);

                    }
                }

                dd('Invoice Completed');
            }
        }
    }
}
