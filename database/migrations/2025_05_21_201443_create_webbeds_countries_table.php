<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebbedsCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webbeds_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('region_name')->nullable();
            $table->string('region_code')->nullable();
            $table->string('alpha_code')->nullable();
            $table->string('country_code')->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->string('gts_code')->nullable();
            $table->tinyInteger('gts_city_dumped')->default(0)->nullable();
            $table->tinyInteger('dida_city_dumped')->default(0)->nullable();
            $table->timestamps();

            // Note: ENGINE = MyISAM is not supported directly in Laravel
            // Laravel uses InnoDB by default, which supports foreign keys
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webbeds_countries');
    }
}
