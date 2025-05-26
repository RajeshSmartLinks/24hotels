<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJsonRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('json_requests', function (Blueprint $table) {
            $table->id();
            $table->longtext('request_json');
            $table->longtext('response_json');
            $table->string('ip_address');
            $table->enum('request_type',['search','hotel_details','get_all_rooms','pre_booking','booking','booking_details','cancel','baggage'])->nullable();
            $table->enum('supplier',['tbo'])->default('tbo')->nullable();
            $table->string('city_code')->nullable();
            $table->string('transactionIdentifier')->nullable();
            $table->integer('search_id')->nullable();
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
        Schema::dropIfExists('json_requests');
    }
}
