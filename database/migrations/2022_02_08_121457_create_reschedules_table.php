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
            $table->string('reschedule_reson');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('order_id')->on('orders');

            $table->unsignedBigInteger('reschedule_by');//user_id
            $table->foreign('reschedule_by')->references('id')->on('users');

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
