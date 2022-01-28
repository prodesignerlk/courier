<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id('seller_id');

            //contact
            $table->string('seller_name');
            $table->string('seller_tp_1');
            $table->string('seller_tp_2')->nullable();

            //address
            $table->string('address_line_1')->nullable();
            $table->string('city_id')->nullable();
            $table->string('district_id')->nullable();

            //payment
            $table->integer('payment_period');
            $table->integer('regular_price');
            $table->integer('extra_price');
            $table->integer('handeling_fee');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('sellers');
    }
}
