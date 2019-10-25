<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('company')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('goornorate');
            $table->string('phone');
            $table->string('products' , '50');
            $table->string('quantity_products' , '50');
            $table->enum('status',['0','1','2'])->default('0'); // 0 = pending , 1 =accepted , 2 =rejected 
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
        Schema::dropIfExists('orders');
    }
}
