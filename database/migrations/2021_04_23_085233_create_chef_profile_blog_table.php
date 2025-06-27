<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChefProfileBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_profile_blog', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');           
            $table->unsignedBigInteger('chef_id');
            $table->string('title');
            $table->string('image')->default('default.png');
            $table->text('description');
            $table->enum('status', ['A', 'I'])->default('A')->comment('A:ACTIVE I:INACTIVE'); 
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
        Schema::dropIfExists('chef_profile_blog');
    }
}
