<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingPnrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_pnrs', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->string('vendor_pnr')->comment('travel port (universal record) pnr');
            $table->integer('travelport_request_id')->nullable();
            $table->tinyInteger('cron_status')->default(0)->comment('0=>not executed , 1=>executed');
            $table->tinyInteger('status')->default(0);
            $table->dateTime('enable_request_on')->comment('we should call UniversalRecordRetrieve  after 2 hours');
            $table->dateTime('execuated_date_time')->nullable();
            $table->text('old_flight_ticket_path')->nullable();
            $table->text('flight_ticket_path')->nullable();
            $table->integer('old_ticketing_travelport_request_id')->nullable();
            $table->tinyInteger('is_success')->default(0)->nullable();
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
        Schema::dropIfExists('pending_pnrs');
    }
}
