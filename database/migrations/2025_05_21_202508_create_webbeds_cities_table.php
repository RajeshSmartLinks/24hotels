<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebbedsCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webbeds_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('country_name')->nullable();
            $table->string('country_code')->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->enum('is_hotel_data_dumped', ['yes', 'no'])->nullable();
            $table->dateTime('last_dump_on')->nullable();
            $table->enum('last_dump_staus', ['success', 'failure'])->nullable();
            $table->enum('fetch_cycle', ['one', 'two','three','four','five'])->nullable();
            $table->dateTime('cycle_update_on')->nullable();
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
        Schema::dropIfExists('webbeds_cities');
    }
}
