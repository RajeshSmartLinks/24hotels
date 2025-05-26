<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportsCountryCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports_country_cities', function (Blueprint $table) {
            $table->id();
            $table->string('airport_code');
            $table->string('name');
            $table->string('name_ar');
            $table->string('synonym')->comment('City code for the primary city associated with this airport.');
            $table->string('state_code');
            $table->string('metro_code')->comment('City code for the primary city associated with this airport.');
            $table->string('airport_type')->comment('1 = Major with a club,2 = Major, no club,3 = Secondary, no club, scheduled service,4 = Heliport, no club, scheduled service,5 = Bus station,6 = Train station,8 = Heliport, not scheduled,9 = Secondary, not scheduled');
            $table->string('host_service')->comment('“Y” =	Served by host , “N” =	No host service ');
            $table->string('reference_number')->comment('Reference Number');

            $table->string('city_code');
            $table->string('city_synonym')->comment('"S" =	Synonym record ,blank =	Primary record ,"C" =	Created city record, ');
            $table->string('city_name');
            $table->string('city_name_ar');
            $table->string('city_associated_airports')->comment('CCodes for associated airports.  Up to eight 5-character codes are concatenated for multiple air¬ports.  Can be blank if there is no airport.  Will also be blank when the Metro Code field is used.');
            $table->string('city_host_service')->comment('“Y” =	Served by host , “N” =	No host service ');
            $table->string('city_commercial_service')->comment('Indicates if the city is served by an airport with commercial service."Y" =	Yes, commercial service "N" =	No');
            

            $table->string('country_code');
            $table->string('country_name');
            $table->string('country_name_ar');
            $table->string('country_currency_code');
            $table->string('country_iata_code');
            $table->string('country_postal_code_significant_digits')->comment('"S" =Synonym record ,blank =	Primary record ,"C" =	Created city record ');
            $table->string('country_associated_city_or_airport')->comment('Indicates if the country contains any airport or city records in associated files: "Y" =	Yes ,"N" =	None');
            $table->string('country_phone_code');

            $table->string('display_name');
            $table->string('display_name_ar');
            $table->string('airport_en_ar');
            
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
        Schema::dropIfExists('airports_country_cities');
    }
}
