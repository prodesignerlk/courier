<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviousReRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_re_routes', function (Blueprint $table) {
            $table->id('previous_re_route_id');
            
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('order_id')->on('orders');

            $table->dateTime('st_4_at')->nullable();
            $table->unsignedBigInteger('st_4_by')->nullable();

            $table->dateTime('st_5_at')->nullable();
            $table->unsignedBigInteger('st_5_by')->nullable();

            $table->dateTime('st_6_at')->nullable();
            $table->unsignedBigInteger('st_6_by')->nullable();
            $table->unsignedBigInteger('st_6_branch')->nullable(); //received branch

            $table->dateTime('reroute_at')->nullable();
            $table->unsignedBigInteger('reroute_by')->nullable();
            
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
        Schema::dropIfExists('previous_re_routes');
    }
}
