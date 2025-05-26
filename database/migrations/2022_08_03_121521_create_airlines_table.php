<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_code');
            $table->string('name');
            $table->string('short_name');
            $table->string('apollo_articipation')->comment('"P" =	Full CRS participation,"N" =	Non-participant.');
            $table->string('vendor_type')->comment('"S" =	Synonym record ,blank =	Primary record ,"C" =	Created city record, ');
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
        Schema::dropIfExists('airlines');
    }
}
