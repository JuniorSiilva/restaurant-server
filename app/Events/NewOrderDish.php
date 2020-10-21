<?php

namespace App\Events;

use App\Models\OrderDish;
use Illuminate\Queue\SerializesModels;
use App\Events\Channels\PrivateTenantChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewOrderDish implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderDish;

    public $broadcastQueue = 'orders';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OrderDish $orderDish)
    {
        $this->orderDish = $orderDish;
    }

    public function broadcastAs()
    {
        return 'new.order.dish';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateTenantChannel('orders');
    }
}
