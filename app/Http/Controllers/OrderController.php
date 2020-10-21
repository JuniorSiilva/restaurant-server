<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateOrder;
use App\Http\Requests\RequestDish;
use App\Services\Contracts\OrderServiceContract;
use App\Repositories\Contracts\OrderRepositoryContract;

class OrderController extends Controller
{
    /**
     * @var \App\Services\OrderService
     */
    protected $orderService = OrderServiceContract::class;

    /**
     * @var \App\Repositories\OrderRepository
     */
    protected $orderRepository = OrderRepositoryContract::class;

    public function create(CreateOrder $request)
    {
        $orderId = $this->orderService->create($request->validated());

        return custom_response(['id' => $orderId], Response::HTTP_CREATED)->do();
    }

    public function close(int $id)
    {
        $orderId = $this->orderService->close($id);

        return custom_response(['id' => $orderId])->do();
    }

    public function request(RequestDish $request, int $id)
    {
        $orderId = $this->orderService->addDish($request->validated(), $id);

        return custom_response(['id' => $orderId], Response::HTTP_CREATED)->do();
    }
}
