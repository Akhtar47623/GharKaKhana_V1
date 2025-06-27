<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuNutritionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_nutrition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');
            $table->integer('service_per_container');
            $table->enum('rounding',[0,1,2])->default(0)->comment('0:Default 1:Usually 2:Varied');
            $table->decimal('quantity',10, 2);
            $table->string('units');
            $table->integer('serving_size');
            $table->enum('serving_size_unit',['gm','ml'])->comment('gm:Grams ml:Mililiteres');
            $table->integer('calories');
            $table->integer('total_fat');
            $table->integer('saturated_fat');
            $table->integer('trans_fat');
            $table->integer('cholesterol');
            $table->integer('sodium');
            $table->integer('total_carbohydrates');
            $table->integer('dietry_fiber');
            $table->integer('sugars');
            $table->integer('added_sugar');
            $table->integer('protein');
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
        Schema::dropIfExists('menu_nutrition');
    }
}
