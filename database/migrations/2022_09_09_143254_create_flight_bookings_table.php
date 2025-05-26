<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('trace_id')->nullable();
            $table->string('pnr')->comment('UniversalReservation Code , MyTravelport pnr number')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->enum('user_type',['app','web','web_guest','app_guest']);
            $table->string('mobile');
            $table->string('email');
            $table->string('country_code')->nullable();
            $table->enum('booking_type',['oneway','roundtrip','multicity']);
            $table->string('country_id');
            $table->string('invoice_id')->nullable();
            $table->string('myfatoorah_url')->nullable();
            $table->string('session_uuid')->nullable();
            $table->string('invoice_status')->nullable();
            $table->decimal('basefare',18,3)->nullable();
            $table->decimal('tax',18,3)->nullable();
            $table->decimal('sub_total',18,3)->nullable();
            $table->decimal('total_amount',18,3)->nullable();
            $table->decimal('service_charges',18,3)->nullable();
            $table->string('currency_code')->nullable();
            $table->text('invoice_response')->nullable();
            $table->text('payment_gateway')->nullable();
            $table->string('booking_ref_id')->nullable();
            $table->string('invoice_path')->nullable();
            $table->string('flight_ticket_path')->nullable();
            $table->enum('booking_status',['booking_initiated','payment_initiated','payment_successful','payment_failure','payment_exipre','travelport_failure','booking_completed','refund_initiated','refund_completed','cancellation_initiated','canceled'])->nullable();
            $table->integer('travel_request_id')->nullable();
            $table->string('ticket_status')->default(0)->nullable();
            $table->string('galileo_pnr')->comment('ProviderReservation')->nullable();
            $table->string('reservation_pnr')->comment('AirReservation')->nullable();
            $table->string('supplier_pnr')->comment('supplierLocatorCode (or) Airlinespnr')->nullable();
            $table->tinyInteger('is_cancel')->default(0)->nullable();
            $table->string('ticket_travelport_request_id')->default(null)->comment('Travelport Request Ticket Id')->nullable();
            $table->string('reservation_travelport_request_id')->default(null)->comment('Travelport Request universal reservation Id')->nullable();
            $table->string('preview_travelport_request_id')->default(null)->comment('Travelport Reqest preview id')->nullable();
            $table->enum('type_of_payment',['k_net','credit_card','wallet'])->default('k_net');
            $table->enum('supplier_type',['travelport','airarabia','airjazeera'])->default('travelport')->nullable();
            $table->enum('internal_booking',['0','1'])->default('0')->comment('0->extenal booking ,1->inhouse booking(internal booking)')->nullable();
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
        Schema::dropIfExists('flight_bookings');
    }
}
