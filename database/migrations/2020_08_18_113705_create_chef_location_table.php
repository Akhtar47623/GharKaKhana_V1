<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChefLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_location', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chef_id');
            $table->string('address');
            $table->integer('state_id')->nullable()->unsigned();
            $table->integer('city_id')->nullable()->unsigned();
            $table->enum('acknowledgement',[1,0])->default(0)->comment('1:TRUE 0:FALSE');
            $table->enum('privacy_policy',[1,0])->default(0)->comment('1:TRUE 0:FALSE');
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
        Schema::dropIfExists('chef_location');
    }
}
