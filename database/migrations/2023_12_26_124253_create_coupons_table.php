<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_title');
            $table->string('coupon_code')->unique();
            $table->enum('coupon_type', ['percentage', 'amount']);
            $table->decimal('coupon_amount', 10, 2);
            $table->date('coupon_valid_from');
            $table->date('coupon_valid_to');
            $table->string('coupon_valid_for')->default(0)->comment('0 for multiple');
            $table->tinyInteger('coupon_valid_on')->default(0)->comment('0 for none, 1 for Hotels, 2 for Flights, 3 for both');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('coupons');
    }
}
