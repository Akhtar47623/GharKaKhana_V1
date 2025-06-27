<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('promo_code');
            $table->integer('company_discount');
            $table->date('starts_at');
            $table->date('expired_at');
            $table->integer('total_coupons');
            $table->integer('total_used_coupons')->default(0);
            $table->integer('minimum_order_value');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id');
            $table->enum('status', [0,1])->default(0)->comment('0:InActive 1:Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount');
    }
}
