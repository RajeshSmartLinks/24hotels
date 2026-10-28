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
        Schema::dropIfExists('mailers');

        Schema::create('mailers', function (Blueprint $table) {
            $table->id();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('subject')->nullable();
            $table->longText('html_data')->nullable();
            $table->enum('is_send', ['0', '1'])->default('0');
            $table->timestamp('sent_at')->nullable();
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
