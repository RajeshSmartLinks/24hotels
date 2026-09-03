<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingRestelFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webbeds_hotel_searches', function (Blueprint $table) {
            $table->string('restel_city_code')->nullable();
            $table->string('residency_alpha_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webbeds_hotel_searches', function (Blueprint $table) {
            //
        });
    }
}
