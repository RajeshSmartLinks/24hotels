<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightTicketNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_ticket_numbers', function (Blueprint $table) {
            $table->id();
            $table->integer('flight_booking_id');
            $table->integer('flight_booking_travels_info_id');
            $table->string('from');
            $table->string('to');
            $table->string('flight_number')->nullable();
            $table->string('carrier')->nullable();
            $table->string('ticket_number')->nullable();
            $table->string('ticket_status')->nullable();
            $table->string('extra_baggage')->nullable();
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
        Schema::dropIfExists('flight_ticket_numbers');
    }
}
