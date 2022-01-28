<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id('package_id');

            $table->string('waybill_id')->unique();
            $table->string('waybill_type')->nullable();
            $table->float('package_weight')->nullable();
            $table->boolean('package_used_status')->default(0);
            $table->integer('batch_number');
            
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('seller_id')->on('sellers');
            
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
        Schema::dropIfExists('packages');
    }
}
