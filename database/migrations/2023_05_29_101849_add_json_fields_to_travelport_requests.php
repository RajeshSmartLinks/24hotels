<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJsonFieldsToTravelportRequests extends Migration
{
    public function up()
    {
        // Add the new enum value 'jazeera' to the 'supplier' field
        DB::statement("ALTER TABLE travelport_requests MODIFY COLUMN supplier ENUM('travelport', 'airarabia', 'jazeera')");

        // Add the new 'json_request' and 'json_response' fields
        Schema::table('travelport_requests', function (Blueprint $table) {
            $table->text('json_request')->nullable()->after('supplier');
            $table->text('json_response')->nullable()->after('json_request');
        });
    }

    public function down()
    {
        // Remove the 'json_request' and 'json_response' fields
        Schema::table('travelport_requests', function (Blueprint $table) {
            $table->dropColumn(['json_request', 'json_response']);
        });

        // Remove the 'jazeera' enum value from the 'supplier' field
        DB::statement("ALTER TABLE travelport_requests MODIFY COLUMN supplier ENUM('travelport', 'airarabia', 'jazeera')");
    }
}


