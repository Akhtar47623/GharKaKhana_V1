<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_location', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cust_id');
            $table->string('address');
            $table->string('city');
            $table->string('state');            
            $table->string('country');
            $table->string('lat');
            $table->string('log');
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
        Schema::dropIfExists('customer_location');
    }
}
