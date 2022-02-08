<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id('branch_id');

            $table->string('branch_code')->unique();

            $table->string('branch_name')->nullable();
            $table->string('branch_address');
            $table->string('branch_city');
            $table->string('branch_district');

            $table->boolean('status')->default('0');
            
            $table->string('branch_tp')->unique();
            $table->string('branch_email')->nullable();

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
        Schema::dropIfExists('branches');
    }
}
