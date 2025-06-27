<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuisineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuisine', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->string('image'); 
            $table->enum('status', ['A', 'I'])->default('A')->comment('A:ACTIVE I:INACTIVE'); 
            $table->softDeletes();
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
        Schema::dropIfExists('cuisine');
    }
}
