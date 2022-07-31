<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->id('receiver_id');
            $table->string('receiver_name');
            $table->string('receiver_contact');
            $table->string('receiver_contact_2')->nullable();

            $table->text('receiver_address');
            $table->unsignedBigInteger('receiver_city_id')->nullable();
            $table->unsignedBigInteger('receiver_district_id')->nullable();

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
        Schema::dropIfExists('receivers');
    }
}
