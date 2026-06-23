<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingHotelRoomBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_hotel_room_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_booking_id');
            $table->enum('cron_status', ['pending', 'processing', 'completed', 'failed'])->default('pending')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'failed'])->default('pending')->nullable();
            $table->dateTime('enable_request_on')->nullable();
            $table->enum('supplier' , [ 'dida'])->default('dida')->nullable();
            $table->dateTime('execuated_on')->nullable();
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
        Schema::dropIfExists('pending_hotel_room_bookings');
    }
}
