<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailers', function (Blueprint $table) {
            $table->id();
            $table->string('from')->nullable();
            $table->string('from_name')->nullable();
            $table->string('to')->nullable();
            $table->string('to_name')->nullable();
            $table->string('attachment')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message')->nullable();
            $table->date('send_date');
            $table->enum('status' , ['Active' ,'InActive'])->default('Active');
            $table->tinyInteger('is_cron')->default(0);
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('mailers');
    }
}
