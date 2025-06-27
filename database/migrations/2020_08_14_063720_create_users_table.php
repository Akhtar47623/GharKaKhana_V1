<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->enum('type', ['Chef', 'Customer'])->default('Customer');
            $table->string('display_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email',128)->unique();
            $table->integer('mobile');
            $table->string('password');            
            $table->integer('country_id')->nullable()->unsigned();
            $table->string('profile')->default('default.png');
            $table->string('provider')->nullable();
            $table->string('provider_id')->unique()->nullable();
            $table->enum('status', ['A', 'I'])->default('A')->comment('A:ACTIVE I:INACTIVE');
            $table->date('activate_date')->nullable();
            $table->string('validate_code')->nullable();
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
        Schema::dropIfExists('users');
    }
}
