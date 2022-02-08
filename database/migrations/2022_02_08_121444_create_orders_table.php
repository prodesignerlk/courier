<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->float('cod_amount');
            $table->float('delivery_cost')->nullable();

            $table->unsignedBigInteger('status')->default('1');

            //1->processing 
            //2->pickup colleded ny branch 
            //3->pickup despated by branch 
            //4->pickup/reroute colledted by delivery hub
            //5->Dispatched 
            //6->Received by branch 
            //7->Assign to agent 
            //8->reschedule 
            //9->Delivered 
            //10->Delivery fail 
            //11->reroute 
            //12->return 
            //13->return collected by delivery hub
            //14->return to Seller

            $table->dateTime('st_1_at');
            $table->unsignedBigInteger('st_1_by');

            $table->dateTime('st_2_at')->nullable();
            $table->unsignedBigInteger('st_2_by')->nullable();

            $table->dateTime('st_3_at')->nullable();
            $table->unsignedBigInteger('st_3_by')->nullable();

            $table->dateTime('st_4_at')->nullable();
            $table->unsignedBigInteger('st_4_by')->nullable();

            $table->dateTime('st_5_at')->nullable();
            $table->unsignedBigInteger('st_5_by')->nullable();

            $table->dateTime('st_6_at')->nullable();
            $table->unsignedBigInteger('st_6_by')->nullable();

            // $table->unsignedBigInteger('assign_to_agent_id');
            // $table->foreign('assign_to_agent_id')->references('assign_to_agent_id')->on('assign_to_agents');      

            // $table->unsignedBigInteger('reschedule_id');
            // $table->foreign('reschedule_id')->references('reschedule_id')->on('reschedules');

            $table->dateTime('st_9_at')->nullable();
            $table->unsignedBigInteger('st_9_by')->nullable();

            $table->dateTime('st_10_at')->nullable();
            $table->unsignedBigInteger('st_10_by')->nullable();

            $table->dateTime('st_11_at')->nullable();
            $table->unsignedBigInteger('st_11_by')->nullable();

            $table->dateTime('st_12_at')->nullable();
            $table->unsignedBigInteger('st_12_by')->nullable();

            $table->dateTime('st_13_at')->nullable();
            $table->unsignedBigInteger('st_13_by')->nullable();

            $table->dateTime('st_14_at')->nullable();
            $table->unsignedBigInteger('st_14_by')->nullable();
        
            $table->string('waybill_id')->unique();

            $table->unsignedBigInteger('receiver_id');
            $table->foreign('receiver_id')->references('receiver_id')->on('receivers');

            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('seller_id')->on('sellers');

            $table->unsignedBigInteger('pickup_branch_id');

            $table->unsignedBigInteger('branch_id')->nullable();

            // $table->unsignedBigInteger('daily_invoice_id')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
