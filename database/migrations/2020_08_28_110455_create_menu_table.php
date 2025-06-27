<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('chef_id');
            $table->string('item_name');
            $table->text('item_description');
            $table->string('item_type');
            $table->string('item_category');
            $table->unsignedBigInteger('cuisine_id');
            $table->string('calories')->nullable();
            $table->string('rate');
            $table->enum('options', [0, 1])->default(0)->comment('0:NO 1:YES');
            $table->integer('minimum_order')->default(1);
            $table->enum('item_visibility', [0, 1])->default(0)->comment('0:ON 1:OFF');
            $table->enum('status', [0,1])->default(0)->comment('1:Available 0:Not Available');
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
        Schema::dropIfExists('menu');
    }
}
