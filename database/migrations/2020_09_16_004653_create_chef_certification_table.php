<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChefCertificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_certification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');           
            $table->unsignedBigInteger('chef_id');
            $table->string('certi_name');
            $table->string('certi_authority');
            $table->string('certi_from');
            $table->string('certi_to');
            $table->string('certi_url')->nullable();
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
        Schema::dropIfExists('chef_certification');
    }
}
