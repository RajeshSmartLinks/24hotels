<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateSupplierHotelXmlRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_xml_requests', function (Blueprint $table) {
             DB::statement("
                ALTER TABLE hotel_xml_requests
                MODIFY COLUMN supplier ENUM('Webbeds','Dida','Gts','Restel')
                NULL DEFAULT 'Webbeds'
            ");

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
