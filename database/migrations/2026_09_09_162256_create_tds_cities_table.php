<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdsCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tds_cities', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id')->nullable();
            $table->string('jpd_code')->nullable();
            $table->string('name')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('country_jpd_code')->nullable();
            $table->string('country_name')->nullable();
            $table->integer('region_id')->nullable();
            $table->string('region_jpd_code')->nullable();
            $table->string('region_name')->nullable();
            $table->string('long_name',500)->nullable();
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
        Schema::dropIfExists('tds_cities');
    }
}
