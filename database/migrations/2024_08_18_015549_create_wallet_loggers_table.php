<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletLoggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_loggers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('user id from users table as agent');
            $table->string('unique_id')->comment('unique id forevery transation')->nullable();
            $table->integer('reference_id')->nullable();
            $table->decimal('amount',18,3)->nullable()->default(0.000);
            $table->decimal('remaining_amount',18,3)->nullable()->default(0.000);
            $table->string('amount_description')->nullable();
            $table->enum('action',['added','subtracted'])->default('added');
            $table->enum('reference_type',['hotel','flight','user']);
            $table->enum('status',['Active','InActive'])->default('Active');
            $table->enum('wallet_amount_type',['cash','cheque'])->nullable();
            $table->string('wallet_reference_id')->nullable();
            $table->dateTime('date_of_transaction')->nullable();
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
        Schema::dropIfExists('wallet_loggers');
    }
}
