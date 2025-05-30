<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelXmlRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_xml_requests', function (Blueprint $table) {
            $table->id();
            $table->longtext('request_xml');
            $table->longtext('response_xml');
            $table->integer('hotel_search_id')->nullable();
            $table->string('ip_address');
            $table->enum('request_type',['search','getRooms' ,'getRoomsWithBlocking' ,'confirmBooking','cancelBooking'])->nullable();
            $table->enum('supplier',['Webbeds'])->default('Webbeds')->nullable();
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
        Schema::dropIfExists('hotel_xml_requests');
    }
}
