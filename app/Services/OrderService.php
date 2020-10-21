<?php

namespace App\Services;

use DB;
use App\Models\Order;
use App\Models\OrderDish;
use App\Exceptions\TableOccupiedException;
use App\Services\Contracts\OrderServiceContract;
use App\Repositories\Contracts\DishRepositoryContract;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\TableRepositoryContract;
use App\Repositories\Contracts\DishOptionalRepositoryContract;

class OrderService extends Service implements OrderServiceContract
{
    /**
     * @var \App\Repositories\OrderRepository
     */
    protected $orderRepository = OrderRepositoryContract::class;

    /**
     * @var \App\Repositories\TableRepository
     */
    protected $tableRepository = TableRepositoryContract::class;

    /**
     * @var \App\Repositories\DishRepository
     */
    protected $dishRepository = DishRepositoryContract::class;

    /**
     * @var \App\Repositories\DishOptionalRepository
     */
    protected $dishOptionalRepository = DishOptionalRepositoryContract::class;

    public function create(array $data) : int
    {
        if ($this->tableRepository->tableIsOccupied($data['table']['id'])) {
            throw new TableOccupiedException;
        }

        $order = new Order($data);

        $order->table()->associate($data['table']['id']);

        $order->save();

        return $order->getKey();
    }

    public function close(int $id) : int
    {
        $order = $this->orderRepository->findById($id, false);

        $order->close();

        return $order->getKey();
    }

    public function addDish(array $data, int $id) : int
    {
        $order = $this->orderRepository->findById($id, false);

        $dish = $this->dishRepository->findById($data['dish']['id'], false);

        $optionalsId = array_column($data['optionals'] ?? [], 'id');

        $totalPrice = $this->getOptionalsPrice($optionalsId) + $dish->getPrice();

        DB::transaction(function () use ($order, $dish, $data, $optionalsId, $totalPrice) {
            $orderDish = new OrderDish($data);

            $orderDish->order()->associate($order);

            $orderDish->dish()->associate($dish);

            $orderDish->setPrice($totalPrice);

            $orderDish->save();

            $orderDish->dishOptionals()->attach($optionalsId);
        });

        return $order->getKey();
    }

    protected function getOptionalsPrice(array $optionals)
    {
        return array_reduce($optionals, function ($carry, $item) {
            $optional = $this->dishOptionalRepository->findById($item, false);

            return $carry += $optional->getPrice();
        });
    }
}
