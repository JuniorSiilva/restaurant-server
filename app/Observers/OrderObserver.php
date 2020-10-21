<?php

namespace App\Observers;

use App\Models\Order;
use App\Events\ClosedOrder;
use App\Events\CreatedOrder;

class OrderObserver
{
    public function created(Order $order)
    {
        event(new CreatedOrder($order));
    }

    public function closed(Order $order)
    {
        event(new ClosedOrder($order));
    }
}
