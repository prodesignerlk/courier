<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->id('rider_id');
            $table->string('rider_name');
            $table->string('vehicle_no_1');
            $table->string('vehicle_no_2')->nullable();

            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('staff_id')->on('staff');
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
        Schema::dropIfExists('riders');
    }
}
