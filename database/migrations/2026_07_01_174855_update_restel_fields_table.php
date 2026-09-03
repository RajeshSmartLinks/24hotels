<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRestelFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_cities', function (Blueprint $table) {
            $table->string('restel_city_code')->nullable();
            $table->string('restel_country_code')->nullable();
            $table->string('restel_provincia_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_cities', function (Blueprint $table) {
            //
        });
    }
}
