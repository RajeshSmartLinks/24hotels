<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebbedsHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webbeds_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_code')->nullable()->index();
            $table->string('hotel_name')->nullable();
            $table->string('hotel_rating')->nullable();
            $table->text('address')->nullable();
            $table->text('attractions')->nullable();
            $table->string('country_name')->nullable();
            $table->string('country_code')->nullable();
            $table->text('description')->nullable();
            $table->string('fax_number')->nullable();
            $table->text('hotel_facilities')->nullable();
            $table->string('map')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('city_name')->nullable();
            $table->string('city_code')->nullable();
            $table->longText('images')->nullable();
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->string('preferred')->nullable();
            $table->string('exclusive')->nullable();
            $table->text('thumbnail')->nullable();
            $table->string('lastUpdated')->nullable();
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
        Schema::dropIfExists('webbeds_hotels');
    }
}
