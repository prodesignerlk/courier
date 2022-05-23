<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_deposits', function (Blueprint $table) {
            $table->id('daily_deposit_id');
            $table->float('payed_amount')->default(0);
            $table->string('remark')->nullable();
            $table->dateTime('payed_date');

            $table->unsignedBigInteger('payment_approve_by')->nullable(); //user_id
            $table->dateTime('payment_approve_at')->nullable();;

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
        Schema::dropIfExists('daily_deposits');
    }
}
