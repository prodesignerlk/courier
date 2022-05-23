<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_finances', function (Blueprint $table) {

            $table->id('daily_finance_id');
            $table->date('bill_date');
            $table->float('total_cod_amount');
            $table->integer('order_count');
            $table->integer('payment_status')->default('0'); //0->unpaid , 1->payed, 2->pending

            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branches');

            $table->unsignedBigInteger('daily_deposit_id');

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
        Schema::dropIfExists('daily_finances');
    }
}
