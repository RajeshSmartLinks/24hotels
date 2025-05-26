<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightBookingSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_booking_searches', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('flight_trip')->nullable();
            $table->string('flight_from')->nullable();
            $table->string('flight_from_airport_code')->nullable();
            $table->string('flight_to')->nullable();
            $table->string('flight_to_airport_code')->nullable();
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('flight_travellers_class')->nullable();
            $table->string('noof_adults')->nullable();
            $table->string('noof_children')->nullable();
            $table->string('noof_infants')->nullable();
            $table->string('flight_class')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('request_json')->nullable();
            $table->text('request_url')->nullable();
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
        Schema::dropIfExists('flight_booking_searches');
    }
}
