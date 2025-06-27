<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pickup_delivery_id');
            $table->string('address');
            $table->string('city_id');
            $table->string('state_id');
            $table->string('zipcode');
            $table->integer('mobile');
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
        Schema::dropIfExists('pickup_details');
    }
}
