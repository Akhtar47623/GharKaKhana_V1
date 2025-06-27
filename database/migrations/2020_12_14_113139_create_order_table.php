<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('chef_id');
            $table->unsignedBigInteger('cust_id');
            $table->enum('pick_del_option', [1, 2])->default(1)->comment('1:PICKUP 2:DELIVERY');
            $table->enum('delivery_by', [1, 2])->comment('1:CHEF 2:DELIVERY COMPANY');
            $table->unsignedBigInteger('delivery_company_id');
            $table->enum('payment_method',[1,2])->comment('1:CASH 2:CREDIT');
            $table->date('delivery_date');
            $table->time('delivery_time');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('chef_discount', 10, 2);
            $table->decimal('house_discount', 10, 2);
            $table->decimal('makem_discount', 10, 2, 10, 2);
            $table->decimal('service_fee', 10, 2);
            $table->decimal('delivery_fee', 10, 2);
            $table->decimal('tax_fee', 10, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('tip_fee', 10, 2);
            $table->decimal('pay_total', 10, 2);
            $table->decimal('chef_commission_fee', 10, 2);
            $table->decimal('delivery_commission_fee', 10, 2);
            $table->decimal('revenue_from_chef', 10, 2);
            $table->decimal('revenue_from_delivery', 10, 2);             
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
        Schema::dropIfExists('order');
    }
}
