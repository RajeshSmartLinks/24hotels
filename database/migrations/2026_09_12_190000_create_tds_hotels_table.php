<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdsHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tds_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_code')->nullable();
            $table->string('hotel_jp_code')->nullable()->unique();
            $table->string('name', 500)->nullable();
            $table->string('star_rating')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('postal_code')->nullable();
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->text('thumbnail')->nullable();
            $table->string('city_jpd_code')->nullable()->index();
            $table->string('region_jpd_code')->nullable();
            $table->string('country_jpd_code')->nullable()->index();
            $table->text('telephone')->nullable();
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
        Schema::dropIfExists('tds_hotels');
    }
}
