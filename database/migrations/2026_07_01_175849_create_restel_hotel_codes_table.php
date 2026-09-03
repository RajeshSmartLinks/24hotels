<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestelHotelCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restel_hotel_codes', function (Blueprint $table) {
            $table->id();
        
            $table->string('codesthot')->nullable();
            $table->string('codpobhot')->comment('Restel city code')->nullable();
            $table->string('hot_codigo')->nullable();
            $table->string('hot_codcobol')->comment('Restel hotel code')->nullable();
            $table->string('hot_coddup')->nullable();
            $table->string('hot_afiliacion')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->nullable();
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
        Schema::dropIfExists('restel_hotel_codes');
    }
}
