<?php

namespace App\Observers;

use App\Models\OrderDish;
use App\Events\NewOrderDish;

class OrderDishObserver
{
    public function created(OrderDish $orderDish)
    {
        event(new NewOrderDish($orderDish));
    }
}
