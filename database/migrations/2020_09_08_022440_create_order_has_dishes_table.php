<?php

use App\Enums\OrderDishStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHasDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_has_dishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dish_id');
            $table->foreignId('order_id');
            $table->decimal('price', 8, 2);
            $table->string('description', 500)->nullable();
            $table->enum('status', OrderDishStatus::getKeys())->default(OrderDishStatus::SOLICITADO);
            $table->foreign('dish_id')->references('id')->on('dishes');
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('order_has_dishes');
    }
}
