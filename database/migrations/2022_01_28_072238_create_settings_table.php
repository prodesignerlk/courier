<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id('setting_id');

            $table->string('feature')->unique();
            $table->unsignedBigInteger('option')->nullable();
            $table->string('relevent_model')->nullable();

            $table->unsignedBigInteger('org_id');
            $table->foreign('org_id')->references('org_id')->on('organizations');
            
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
        Schema::dropIfExists('settings');
    }
}
