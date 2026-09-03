<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGtsCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gts_cities', function (Blueprint $table) {
            $table->id();
            $table->string('gts_city_id');
            $table->string('name');
            $table->string('full_name');
            $table->string('country_code');
            $table->string('country_name');
            $table->integer("is_hotel_dumped")->default(0);
            $table->integer("is_migrated")->default(0);
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
        Schema::dropIfExists('gts_cities');
    }
}
