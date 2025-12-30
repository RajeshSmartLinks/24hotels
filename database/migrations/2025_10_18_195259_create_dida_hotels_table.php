<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDidaHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dida_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('language', 10)->nullable();
            $table->unsignedBigInteger('hotel_id')->unique();
            $table->string('name', 500)->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('country_name')->nullable();
            $table->string('destination_code', 50)->nullable();
            $table->string('destination_name')->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->string('state_code', 100)->nullable();
            $table->string('address',500)->nullable();
            $table->string('telephone', 100)->nullable();
            $table->string('star_rating')->nullable();
            $table->string('zip_code', 100)->nullable();
            $table->longText('images')->nullable();
            $table->string('thumbnail',1000)->nullable();
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
        Schema::dropIfExists('dida_hotels');
    }
}
