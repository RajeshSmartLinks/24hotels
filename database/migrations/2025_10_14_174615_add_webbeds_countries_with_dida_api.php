<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebbedsCountriesWithDidaApi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webbeds_countries', function (Blueprint $table) {
            $table->string('dida_city_dumped')->nullable()->default(0);
            $table->tinyInteger('dida_hotel_dumped')->nullable()->default(0);
            $table->timestamp('hotel_list_dumped_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webbeds_countries', function (Blueprint $table) {
            //
        });
    }
}
