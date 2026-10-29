<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            if (!Schema::hasColumn('agencies', 'country_id')) {
                $table->string('country_id')->nullable()->after('phone_number');
            }
            if (!Schema::hasColumn('agencies', 'agency_code')) {
                $table->string('agency_code')->nullable()->after('name');
            }
            if (!Schema::hasColumn('agencies', 'created_by')) {
                $table->integer('created_by')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agencies', function (Blueprint $table) {
            if (Schema::hasColumn('agencies', 'agency_code')) {
                $table->dropColumn('agency_code');
            }
        });
    }
}
