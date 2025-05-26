<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelport_requests', function (Blueprint $table) {
            $table->id();
            $table->longtext('request_xml');
            $table->longtext('response_xml');
            $table->text('trace_id');
            $table->string('ip_address');
            $table->enum('request_type',['search','airPricing','booking','farerule','ticketing','baggage','BookingQuote','TripSell','AddPassengers','CommitBooking','bspcash/pay','universalRecordRetrieve'])->nullable();
            $table->enum('supplier',['travelport','airarabia'])->default('travelport')->nullable();
            $table->string('jsessionid')->nullable();
            $table->string('transactionIdentifier')->nullable();
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
        Schema::dropIfExists('travelport_requests');
    }
}
