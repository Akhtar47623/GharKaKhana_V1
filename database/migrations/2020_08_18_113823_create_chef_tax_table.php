<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChefTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_tax', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chef_id');
            $table->string('business_name')->nullable();
            $table->string('federal_tax_id');
            $table->string('social');
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
        Schema::dropIfExists('chef_tax');
    }
}
