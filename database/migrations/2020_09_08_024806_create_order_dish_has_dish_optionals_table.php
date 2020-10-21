<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDishHasDishOptionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_dish_has_dish_optionals', function (Blueprint $table) {
            $table->foreignId('order_dish_id');
            $table->foreignId('dish_optional_id');
            $table->foreign('order_dish_id')->references('id')->on('order_has_dishes');
            $table->foreign('dish_optional_id')->references('id')->on('dish_optionals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_dish_has_dish_optionals');
    }
}
