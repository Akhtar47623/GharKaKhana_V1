<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_rating', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('chef_id');
            $table->unsignedBigInteger('cust_id');
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->date('date_of_order');
            $table->enum('pick_del_option',[1,2])->default(1)->comment('1:Pickup 2:Delivery');
            $table->text('chef_review')->nullable();
            $table->tinyInteger('chef_rating')->nullable();
            $table->text('delivery_review')->nullable();
            $table->tinyInteger('delivery_rating')->nullable();
            $table->enum('status',[0,1,2])->default(0)->comment('0:Open 1:Skip 2:Complete');
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
        Schema::dropIfExists('review_rating');
    }
}
