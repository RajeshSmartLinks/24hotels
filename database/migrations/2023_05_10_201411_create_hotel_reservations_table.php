<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->string('confirmation_number');
            $table->string('reservation_status');
            $table->integer('json_request_id')->nullable();
            $table->tinyInteger('cron_status')->default(0)->comment('0=>not executed , 1=>executed');
            $table->tinyInteger('status')->default(0);
            $table->dateTime('enable_request_on')->comment('we should call booking details api after 120 seconds of book');
            $table->dateTime('execuated_date_time')->nullable();
            $table->text('hotel_reservation_booking_path')->nullable();
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
        Schema::dropIfExists('hotel_reservations');
    }
}
