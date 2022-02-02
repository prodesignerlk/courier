<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaybillTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waybill_types', function (Blueprint $table) {
            $table->id('waybill_type_id');
            $table->string('type');
            $table->text('description')->nullable();

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
        Schema::dropIfExists('waybill_types');
    }
}
