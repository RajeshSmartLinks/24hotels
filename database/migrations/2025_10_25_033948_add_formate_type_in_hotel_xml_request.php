<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormateTypeInHotelXmlRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_xml_requests', function (Blueprint $table) {
            $table->enum('formate_type' ,['xml' , 'json'])->default('xml')->nullable();
            $table->longText('json_request')->nullable();
            $table->longText('json_response')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_xml_requests', function (Blueprint $table) {
            //
        });
    }
}
