<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTdsFieldsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('hotel_cities')) {
            Schema::table('hotel_cities', function (Blueprint $table) {
                if (!Schema::hasColumn('hotel_cities', 'tds_code')) {
                    $table->string('tds_code')->nullable()->after('gts_code');
                }
                if (!Schema::hasColumn('hotel_cities', 'is_tds')) {
                    $table->integer('is_tds')->default(0)->after('is_gts');
                }
            });
        }

        if (Schema::hasTable('webbeds_hotel_searches')) {
            Schema::table('webbeds_hotel_searches', function (Blueprint $table) {
                if (!Schema::hasColumn('webbeds_hotel_searches', 'tds_code')) {
                    $table->string('tds_code')->nullable()->after('gts_code');
                }
            });
        }

        if (Schema::hasTable('hotel_xml_requests')) {
            try {
                DB::statement("
                    ALTER TABLE hotel_xml_requests
                    MODIFY COLUMN supplier ENUM('Webbeds','Dida','Gts','Restel','Tds')
                    NULL DEFAULT 'Webbeds'
                ");
            } catch (\Throwable $e) {
                // Ignore if DB dialect differs
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('hotel_cities')) {
            Schema::table('hotel_cities', function (Blueprint $table) {
                if (Schema::hasColumn('hotel_cities', 'tds_code')) {
                    $table->dropColumn('tds_code');
                }
                if (Schema::hasColumn('hotel_cities', 'is_tds')) {
                    $table->dropColumn('is_tds');
                }
            });
        }

        if (Schema::hasTable('webbeds_hotel_searches')) {
            Schema::table('webbeds_hotel_searches', function (Blueprint $table) {
                if (Schema::hasColumn('webbeds_hotel_searches', 'tds_code')) {
                    $table->dropColumn('tds_code');
                }
            });
        }
    }
}
