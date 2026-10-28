<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterSupplierInHotelXmlRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE hotel_xml_requests MODIFY COLUMN supplier VARCHAR(50) NULL DEFAULT 'Webbeds'");
        DB::statement("ALTER TABLE hotel_bookings MODIFY COLUMN supplier enum('tbo','webbeds','dida','gts','tds') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tbo' AFTER `type_of_payment`");
        DB::statement("ALTER TABLE hotel_xml_requests ADD COLUMN url varchar(100) NULL AFTER `json_response`");

        DB::statement("ALTER TABLE hotel_room_booking_infos MODIFY COLUMN booking_code text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `room_rate_basis`");

        DB::statement("ALTER TABLE pending_hotel_room_bookings MODIFY COLUMN supplier enum('dida','tds') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'dida' AFTER `updated_at`");
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
