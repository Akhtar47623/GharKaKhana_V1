<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChefBankingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_banking', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chef_id');
            $table->string('bank_name');
            $table->string('bank_address');
            $table->string('iban');
            $table->string('account');
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
        Schema::dropIfExists('chef_banking');
    }
}
