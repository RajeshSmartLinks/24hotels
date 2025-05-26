<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelMarkUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_mark_ups', function (Blueprint $table) {
            $table->id();
            $table->enum('fee_type',['addition','subtraction']);
            $table->enum('fee_value',['fixed','percentage']);
            $table->integer('fee_amount');
            $table->enum('status',['Active','InActive'])->default('Active');
            $table->integer('user_id')->default(0)->comment('adding user id for agent specific');
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
        Schema::dropIfExists('hotel_mark_ups');
    }
}
