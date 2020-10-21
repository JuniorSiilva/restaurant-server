<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Exceptions\OrderIsClosedException;
use App\Repositories\Contracts\OrderRepositoryContract;

class CheckOrderStatus extends Middleware
{
    /**
     * @var \App\Repositories\OrderRepository
     */
    protected $orderRepository = OrderRepositoryContract::class;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $orderId = $request->route('id');

        $order = $this->orderRepository->findById($orderId, false);

        if ($order->getStatus() !== OrderStatus::ABERTO) {
            throw new OrderIsClosedException;
        }

        return $next($request);
    }
}
