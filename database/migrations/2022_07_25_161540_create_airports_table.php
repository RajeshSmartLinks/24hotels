<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('airport_code');
            $table->string('synonym')->comment('"S" =	Synonym record ,blank =	Primary record');
            $table->string('name');
            $table->string('country_code');
            $table->string('state_code');
            $table->string('metro_code');
            $table->string('reference_city_code')->comment('City code for the primary city associated with this airport.');
            $table->string('airport_type')->comment('1 = Major with a club,2 = Major, no club,3 = Secondary, no club, scheduled service,4 = Heliport, no club, scheduled service,5 = Bus station,6 = Train station,8 = Heliport, not scheduled,9 = Secondary, not scheduled');
            $table->string('host_service')->comment('“Y” =	Served by host , “N” =	No host service ');
            $table->string('reference_number')->comment('Reference Number');
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
        Schema::dropIfExists('airports');
    }
}
