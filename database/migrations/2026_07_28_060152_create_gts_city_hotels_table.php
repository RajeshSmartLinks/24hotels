<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGtsCityHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gts_city_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('city_name');
            $table->string('city_code');
            $table->string('country_name');
            $table->string('country_code');
            $table->string('hotel_id');
            $table->tinyInteger("is_hotel_details_dumped")->default(0);
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
        Schema::dropIfExists('gts_city_hotels');
    }
}
