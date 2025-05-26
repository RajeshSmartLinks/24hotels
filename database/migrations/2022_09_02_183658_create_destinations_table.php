<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->text('name_en');
            $table->text('name_ar');
            $table->text('image');
            $table->text('slug');
            $table->enum('status',['Active','InActive'])->default('active');
            $table->text('description_en');
            $table->text('description_ar');
            $table->text('meta_tag_keywords');
            $table->text('meta_tag_description');
            $table->text('order');
            $table->text('flightToCode')->nullable();
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
        Schema::dropIfExists('destinations');
    }
}
