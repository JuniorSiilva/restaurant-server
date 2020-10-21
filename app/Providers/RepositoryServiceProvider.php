<?php

namespace App\Providers;

use App\Repositories\DishRepository;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TableRepository;
use App\Repositories\TenantRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\UserTenantRepository;
use App\Repositories\DishOptionalRepository;
use App\Repositories\Contracts\DishRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\TableRepositoryContract;
use App\Repositories\Contracts\TenantRepositoryContract;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Repositories\Contracts\AttachmentRepositoryContract;
use App\Repositories\Contracts\UserTenantRepositoryContract;
use App\Repositories\Contracts\DishOptionalRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        UserRepositoryContract::class => UserRepository::class,
        TenantRepositoryContract::class => TenantRepository::class,
        DishRepositoryContract::class => DishRepository::class,
        DishOptionalRepositoryContract::class => DishOptionalRepository::class,
        CategoryRepositoryContract::class => CategoryRepository::class,
        TableRepositoryContract::class => TableRepository::class,
        AttachmentRepositoryContract::class => AttachmentRepository::class,
        OrderRepositoryContract::class => OrderRepository::class,
        UserTenantRepositoryContract::class => UserTenantRepository::class,
    ];

    /**
     * Register repositories.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $contract => $service) {
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
