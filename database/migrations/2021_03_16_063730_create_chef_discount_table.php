<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChefDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('chef_id');
            $table->string('promo_code');
            $table->integer('discount');
            $table->date('starts_at');
            $table->date('expired_at');
            $table->integer('total_coupons');
            $table->integer('total_used_coupons')->default(0);
            $table->integer('minimum_order_value');
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
        Schema::dropIfExists('chef_discount');
    }
}
