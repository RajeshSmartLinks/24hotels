<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelRoomBookingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_room_booking_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_booking_id');
            $table->integer('room_no')->nullable();
            $table->string('room_name')->nullable();
            $table->string('room_rate_basis')->nullable();
            $table->string('booking_code')->nullable();
            $table->string('itinerary_code')->nullable();
            $table->string('booking_reference_no')->nullable();
            $table->string('status')->nullable();

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
        Schema::dropIfExists('hotel_room_booking_infos');
    }
}
