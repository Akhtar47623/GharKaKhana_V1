<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuOptionGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_option_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chef_id');
            $table->string('uuid');
            $table->string('group_name');
            $table->enum('option', ['M', 'S'])->default('M')->comment('M:MULTIPLE(SEL ALL) S:SIGLE(SEL ONLY ONE');
            $table->enum('required', [0, 1])->default(0)->comment('0:NO 1:YES');
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
        Schema::dropIfExists('menu_option_group');
    }
}
