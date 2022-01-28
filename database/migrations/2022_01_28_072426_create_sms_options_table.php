<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_options', function (Blueprint $table) {
            $table->id('sms_option_id');

            //details
            $table->string('option')->unique();
            $table->text('description')->nullable();
            
            //api
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();

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
        Schema::dropIfExists('sms_options');
    }
}
