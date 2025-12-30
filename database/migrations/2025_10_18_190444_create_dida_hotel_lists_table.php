<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDidaHotelListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dida_hotel_lists', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_id');
            $table->tinyInteger('is_hotel_details_dumped')->default(0);
            $table->string('country_alpha_code');
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
        Schema::dropIfExists('dida_hotel_lists');
    }
}
