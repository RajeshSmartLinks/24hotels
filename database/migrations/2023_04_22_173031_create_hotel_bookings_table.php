<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('search_id')->nullable();
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->enum('user_type',['app','web','web_guest','app_guest']);
            $table->string('mobile');
            $table->string('email');
            $table->string('country_code')->nullable();
            $table->string('country_id');
            $table->string('invoice_id')->nullable();
            $table->string('myfatoorah_url')->nullable();
            $table->string('invoice_status')->nullable();

            $table->string('currency_code')->nullable();
            $table->decimal('basefare',18,3)->nullable();
            $table->decimal('tax',18,3)->nullable();
            $table->decimal('sub_total',18,3)->nullable();
            $table->decimal('service_charges',18,3)->nullable();  
            $table->decimal('total_amount',18,3)->nullable();

            $table->string('actual_currency_code')->nullable();
            $table->decimal('actual_price',18,3)->nullable();

            $table->string('currency_code_from_supplier')->nullable();
            $table->string('price_from_supplier')->nullable();


            $table->text('booking_code')->nullable();
            $table->enum('booking_status',['booking_initiated','payment_initiated','payment_successful','payment_failure','payment_exipre','booking_failure','booking_completed','refund_initiated','refund_completed','cancellation_initiated','canceled','booking_pending','booking_partially_completed'])->nullable();


            $table->string('confirmation_number')->nullable();
           
            $table->text('invoice_response')->nullable();
            $table->text('payment_gateway')->nullable();
            $table->string('booking_ref_id')->nullable();
            $table->string('invoice_path')->nullable();
            $table->string('hotel_room_booking_path')->nullable();
            $table->integer('booking_json_request_id')->nullable();
            $table->integer('booking_details_json_request_id')->nullable();
            $table->string('hotel_code')->nullable();
            $table->string('ticket_status')->default(0)->nullable();

            $table->string('no_of_rooms')->nullable();
            $table->string('no_of_nights')->nullable();
            $table->string('no_of_guests')->nullable();

            $table->enum('type_of_payment',['k_net','credit_card','wallet'])->default('k_net');
            $table->enum('supplier',['tbo','webbeds'])->default('tbo');

            $table->enum('reservation_status',['Confirmed','Cancelled','CancellationInProgress','CancelPending','CxlRequestSentToHotel','CancelledAndRefundAwaited'])->nullable();
            $table->string('supplement_charges')->nullable();
            $table->tinyInteger('is_rsp_price')->default('0')->comment('if price is Recommended Selling Price enabling this flag')->nullable();
            $table->text('hotel_name')->nullable();
            $table->string('booking_reference_number')->nullable();
            $table->string('webbeds_booking_request_id')->nullable();
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
        Schema::dropIfExists('hotel_bookings');
    }
}
