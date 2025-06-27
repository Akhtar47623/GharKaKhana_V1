<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChefScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('chef_id');
            
            
            $table->enum('mon', [0, 1])->default(0)->comment('0:NO 1:YES');
            $table->time('mon_start_time')->nullable();
            $table->time('mon_end_time')->nullable();

            $table->enum('tue', [0, 1])->default(0)->comment('0:NO 1:YES');
            $table->time('tue_start_time')->nullable();
            $table->time('tue_end_time')->nullable();

            $table->enum('wed', [0, 1])->default(0)->comment('0:NO 1:YES');
            $table->time('wed_start_time')->nullable();
            $table->time('wed_end_time')->nullable();

            $table->enum('thu', [0, 1])->default(0)->comment('0:NO 1:YES');
            $table->time('thu_start_time')->nullable();
            $table->time('thu_end_time')->nullable();

             $table->enum('fri', [0, 1])->default(0)->comment('0:NO 1:YES');
            $table->time('fri_start_time')->nullable();
            $table->time('fri_end_time')->nullable();

            $table->enum('sat', [0, 1])->default(0)->comment('0:NO 1:YES');
            $table->time('sat_start_time')->nullable();
            $table->time('sat_end_time')->nullable();

            $table->enum('sun', [0, 1])->default(0)->comment('0:NO 1:YES');
            $table->time('sun_start_time')->nullable();
            $table->time('sun_end_time')->nullable();

            
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
        Schema::dropIfExists('chef_schedule');
    }
}
