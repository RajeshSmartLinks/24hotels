<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdsHotelListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tds_hotel_lists', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_jp_code')->nullable()->unique();
            $table->string('tds_city_id')->nullable()->index();
            $table->string('tds_city_jpd_code')->nullable();
            $table->string('hotel_name')->nullable();
            $table->tinyInteger('is_hotel_details_dumped')->default(0)->index();
            $table->text('next_token')->nullable();
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
        Schema::dropIfExists('tds_hotel_lists');
    }
}
