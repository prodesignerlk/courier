<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_settings', function (Blueprint $table) {
            $table->id('default_setting_id');
            
            //default price rates
            $table->float('regular_price')->nullable();
            $table->float('extra_price')->nullable();
            $table->float('handeling_fee')->nullable();

            //waybill start from
            $table->integer('waybill_start_from')->nullable();

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
        Schema::dropIfExists('default_settings');
    }
}
