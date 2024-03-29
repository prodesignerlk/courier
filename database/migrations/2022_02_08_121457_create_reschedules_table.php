<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reschedules', function (Blueprint $table) {
            $table->id('reschedule_id');
            $table->dateTime('reschedule_date');
            
            //to check final one. final --->>> 1 , All others --->>> 0
            $table->boolean('status')->default('1');
            
            $table->unsignedBigInteger('reason_id');
            $table->foreign('reason_id')->references('reschedule_reason_id')->on('reschedule_reasons');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('order_id')->on('orders');

            $table->unsignedBigInteger('reschedule_by');//user_id
            $table->foreign('reschedule_by')->references('id')->on('users');

            $table->boolean('reassign')->default('0');

            $table->dateTime('reschedule_at');
            
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
        Schema::dropIfExists('reschedules');
    }
}
