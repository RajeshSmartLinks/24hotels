<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('city_code');
            $table->string('synonym')->comment('"S" =	Synonym record ,blank =	Primary record ,"C" =	Created city record, ');
            $table->string('name');
            $table->string('country_code');
            $table->string('state_code');
            $table->string('metro_code');
            $table->string('associated_airports')->comment('CCodes for associated airports.  Up to eight 5-character codes are concatenated for multiple air¬ports.  Can be blank if there is no airport.  Will also be blank when the Metro Code field is used.');
            $table->string('host_service')->comment('“Y” =	Served by host , “N” =	No host service ');
            $table->string('commercial_service')->comment('Indicates if the city is served by an airport with commercial service."Y" =	Yes, commercial service "N" =	No');
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
        Schema::dropIfExists('cities');
    }
}
