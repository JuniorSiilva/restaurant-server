<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryContract;

class OrderRepository extends Repository implements OrderRepositoryContract
{
    protected $model = Order::class;
}
