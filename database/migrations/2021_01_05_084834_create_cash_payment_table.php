<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->decimal('amount_received',10,2)->nullable();
            $table->string('driver_id')->nullable();
            $table->enum('confirmed_by',[0,1,2])->default(0)->comment('0:Not Confirmed 1:Account 2:Agent');
            $table->dateTime('confirmation_date')->nullable();
            $table->string('bank')->nullable();
            $table->string('batch')->nullable();
            $table->string('deposite_date')->nullable();
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
        Schema::dropIfExists('cash_payment');
    }
}
