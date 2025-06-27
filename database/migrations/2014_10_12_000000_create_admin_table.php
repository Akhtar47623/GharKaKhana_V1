<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id')->nullable()->unsigned();
            $table->string('uuid');
            $table->string('display_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email',128)->unique();
            $table->integer('phone');
            $table->string('password');
            $table->string('full_address');
            $table->integer('country_id')->nullable()->unsigned();
            $table->integer('state_id')->nullable()->unsigned();
            $table->integer('city_id')->nullable()->unsigned();
            $table->integer('zip_code')->nullable();
            $table->integer('device_type_id')->nullable();
            $table->integer('device_token')->nullable();
            $table->integer('api_token')->nullable();
            $table->string('profile')->default('default.png');
            $table->timestamp('email_verified_at')->nullable();            
            $table->rememberToken();
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
        Schema::dropIfExists('Admin');
    }
}
