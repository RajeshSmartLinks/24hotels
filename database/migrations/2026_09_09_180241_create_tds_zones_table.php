<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdsZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tds_zones', function (Blueprint $table) {
            $table->id();
            $table->string('jpd_code')->nullable();
            $table->string('parent_jpd_code')->nullable();
            $table->string('area_type')->nullable();
            $table->string('searchable')->nullable();
            $table->string('code')->nullable();
            $table->string('parent_code')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('tds_zones');
    }
}
