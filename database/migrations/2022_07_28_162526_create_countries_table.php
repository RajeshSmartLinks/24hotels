<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();         
            $table->string('country_code');
            $table->string('name');
            $table->string('currency_code');
            $table->string('iata_code');
            $table->string('postal_code_significant_digits')->comment('"S" =	Synonym record ,blank =	Primary record ,"C" =	Created city record, ');
            $table->string('associated_city_or_airport')->comment('Indicates if the country contains any airport or city records in associated files: "Y" =	Yes ,"N" =	None');
            $table->string('phone_code')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
