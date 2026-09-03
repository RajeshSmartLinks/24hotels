<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGtsHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gts_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_id')->unique();
            $table->string('city_code')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('country_name')->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->string('name', 500)->nullable();
            $table->string('star_rating')->nullable();
            $table->string('address', 1000)->nullable();
            $table->string('telephone', 100)->nullable();
            $table->string('zipcode', 100)->nullable();
            $table->string('thumbnail', 1000)->nullable();
            $table->string('checkin', 100)->nullable();
            $table->string('checkout', 100)->nullable();
            $table->string('rooms' , 2000)->nullable();
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
        Schema::dropIfExists('gts_hotels');
    }
}
