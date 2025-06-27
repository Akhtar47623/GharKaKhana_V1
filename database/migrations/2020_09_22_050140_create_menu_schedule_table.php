<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');

            $table->integer('lead_time');
            
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

            $table->enum('recurring', [0, 1])->default(1)->comment('0:ON 1:OFF');
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
        Schema::dropIfExists('menu_schedule');
    }
}
