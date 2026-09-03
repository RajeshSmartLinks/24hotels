<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_cities', function (Blueprint $table) {
            $table->id();
            $table->string('dida_code')->nullable();
            $table->string('name',500)->nullable();
            $table->string('long_name',500)->nullable();
            $table->string('country_code',500)->nullable();
            $table->string('country_name',500)->nullable();
            $table->integer('is_dida')->default(0);
            $table->enum('preference', ['0', '1'])->nullable()->default('0');
            $table->integer('is_city_checked')->default(0);
            $table->integer('is_gts')->default(0);
            $table->string('gts_code')->nullable();
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
        Schema::dropIfExists('hotel_cities');
    }
}
