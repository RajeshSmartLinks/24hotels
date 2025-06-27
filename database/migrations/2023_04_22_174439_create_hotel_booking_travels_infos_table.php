<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelBookingTravelsInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_booking_travels_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('hotel_booking_id')->nullable();
            $table->string('traveler_type')->nullable();
            $table->integer('room_no')->nullable();
            // $table->string('traveler_ref_id')->comment('')->default(NULL)->nullable();
            $table->string('gender')->default(NULL)->nullable();
            $table->string('webbeds_code')->default(NULL)->nullable();
            $table->integer('age')->default(NULL)->nullable();
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
        Schema::dropIfExists('hotel_booking_travels_infos');
    }
}
