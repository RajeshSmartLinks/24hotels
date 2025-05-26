<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_searches', function (Blueprint $table) {
            $table->id();
            $table->string('no_of_rooms');
            $table->string('no_of_nights')->nullable();
            $table->string('no_of_guests')->nullable();
            $table->string('nationality')->nullable();
            $table->string('city_code');
            $table->string('city_name');
            $table->string('country');
            $table->string('country_code');
            $table->date('check_in');
            $table->date('check_out');
            $table->text('rooms_request');
            $table->string('ip_address');
            $table->string('hotel_traveller_info')->nullable();
            $table->text('request_json')->nullable();
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
        Schema::dropIfExists('hotel_searches');
    }
}
