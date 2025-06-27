<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMexicoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mexico_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');            
            $table->string('rfc');
            $table->string('curp');
            $table->string('name');
            $table->string('email',128);
            $table->integer('mobile');
            $table->string('address');
            $table->string('city');
            $table->string('state');            
            $table->string('country');
            $table->string('zipcode');
            $table->string('invoice')->nullable();
            $table->enum('status', [1, 2, 3])->default(1)->comment('1:PENDING 2:PROCESS 3:READY');
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
        Schema::dropIfExists('mexico_invoice');
    }
}
