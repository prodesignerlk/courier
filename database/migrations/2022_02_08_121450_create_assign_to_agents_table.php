<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignToAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_to_agents', function (Blueprint $table) {
            $table->id('assign_to_agent_id');

            $table->dateTime('assign_date');

            $table->unsignedBigInteger('staff_id');//rider
            $table->foreign('staff_id')->references('staff_id')->on('staff');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('order_id')->on('orders');

            $table->unsignedBigInteger('assign_by');//user_id
            $table->foreign('assign_by')->references('id')->on('users');

            $table->dateTime('assign_at');

            //to check final one. final --->>> 1 , All others --->>> 0
            $table->boolean('status')->default('1');
            
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
        Schema::dropIfExists('assign_to_agents');
    }
}
