<?php

namespace App\Providers;

use App\Facades\Tenant;
use App\Services\TenantService;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tenant', TenantService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureQueue();
    }

    protected function configureQueue()
    {
        $this->app['queue']->createPayloadUsing(function () {
            return Tenant::get() !== null ? [
                'tenant' => serialize(Tenant::get()),
            ] : [];
        });

        $this->app['queue']->before(function ($event) {
            if (! empty($event->job->payload()['tenant'])) {
                Tenant::set(unserialize($event->job->payload()['tenant']));
            }
        });
    }
}
