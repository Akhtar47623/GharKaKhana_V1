<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_delivery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('chef_id');
            $table->enum('options', [1, 2,3])->default(1)->comment('1:PICKUP 2:PICKUP AND DELIVERY 3:DELIVERY');
            $table->enum('delivery_by', [1, 2])->comment('1:CHEF 2:DELIVERY COMPANY');
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
        Schema::dropIfExists('pickup_delivery');
    }
}
