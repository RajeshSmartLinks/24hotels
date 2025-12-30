<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebbedsCityWithDidaApi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webbeds_cities', function (Blueprint $table) {
            $table->string('dida_code')->nullable();
            $table->tinyInteger('is_webbed')->nullable();
            $table->tinyInteger('is_dida')->nullable();
            $table->string('long_name')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webbeds_cities', function (Blueprint $table) {
            //
        });
    }
}
