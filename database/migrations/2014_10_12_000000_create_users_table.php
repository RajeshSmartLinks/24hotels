<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();;
            $table->string('mobile')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('title')->nullable();
            $table->string('country_id')->nullable();
            $table->enum('user_type', ['app', 'web'])->default('web');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['Active', 'InActive'])->default('Active');
            $table->tinyInteger('back_end_user')->default(0);
            $table->string('profile_pic');
            $table->tinyInteger('is_deleted')->default(0);
            $table->dateTime('deleted_at')->default(Null);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
