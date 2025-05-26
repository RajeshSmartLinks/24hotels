<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightBookingTravelsInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_booking_travels_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('flight_booking_id')->nullable();
            $table->string('passport_issued_country_id')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_expire_date')->nullable(); 
            $table->string('traveler_type')->nullable();
            $table->string('traveler_ref_id')->comment('Booking traveler ref id in travelport request (BookingTravelerRef)')->default(NULL)->nullable();
            $table->string('gender')->default(NULL)->nullable();
            $table->string('travel_port_ticket_status')->comment('"U"=>"Unticketed","T"=>"Ticketed","V"=>"Voided","R"=>"Refunded","X"=>"eXchanged","Z"=>"Unknown/Archived/Carrier Modified","N"=>"Unused","S"=>"Used",1=>hold airaribia,3=>airarabia confirmed')->nullable();
            $table->string('travel_port_ticket_number')->nullable();
            $table->string('depature_extra_baggage')->nullable();
            $table->string('return_extra_baggage')->nullable();
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
        Schema::dropIfExists('flight_booking_travels_infos');
    }
}
