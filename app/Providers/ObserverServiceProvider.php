<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDish;
use App\Observers\UserObserver;
use App\Observers\OrderObserver;
use App\Observers\CustomerObserver;
use App\Observers\OrderDishObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Customer::observe(CustomerObserver::class);
        Order::observe(OrderObserver::class);
        OrderDish::observe(OrderDishObserver::class);
    }
}
