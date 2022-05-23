<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');

            $table->float('regular_price');
            $table->float('extra_price');
            $table->float('handling_free');

            $table->float('total_cod_amount');
            $table->float('total_delivery_fee');
            $table->float('total_handling_fee');
            $table->float('total_payable');
            $table->float('total_weight');
            $table->integer('package_count');

            $table->boolean('payment_status')->default('0');
            $table->dateTime('payment_at')->nullable();
            $table->unsignedBigInteger('payment_by')->nullable();

            $table->dateTime('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();

            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('seller_id')->on('sellers');

            $table->date('invoice_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
