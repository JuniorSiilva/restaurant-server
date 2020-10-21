<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\DishService;
use App\Services\UserService;
use App\Services\OrderService;
use App\Services\TableService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Services\AttachmentService;
use App\Services\DishOptionalService;
use App\Services\ForgotPasswordService;
use Illuminate\Support\ServiceProvider;
use App\Services\VerificationUserService;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\DishServiceContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\OrderServiceContract;
use App\Services\Contracts\TableServiceContract;
use App\Services\Contracts\ForgotPasswordContract;
use App\Services\Contracts\CategoryServiceContract;
use App\Services\Contracts\CustomerServiceContract;
use App\Services\Contracts\AttachmentServiceContract;
use App\Services\Contracts\DishOptionalServiceContract;
use App\Services\Contracts\VerificationUserServiceContract;

class ServicesBindProvider extends ServiceProvider
{
    protected $services = [
        AuthServiceContract::class => AuthService::class,
        UserServiceContract::class => UserService::class,
        VerificationUserServiceContract::class => VerificationUserService::class,
        ForgotPasswordContract::class => ForgotPasswordService::class,
        CustomerServiceContract::class => CustomerService::class,
        DishServiceContract::class => DishService::class,
        DishOptionalServiceContract::class => DishOptionalService::class,
        CategoryServiceContract::class => CategoryService::class,
        TableServiceContract::class => TableService::class,
        AttachmentServiceContract::class => AttachmentService::class,
        OrderServiceContract::class => OrderService::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->services as $contract => $service) {
            $this->app->singleton($contract, $service);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
