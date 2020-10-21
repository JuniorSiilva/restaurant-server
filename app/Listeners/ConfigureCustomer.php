<?php

namespace App\Listeners;

use App\Facades\Tenant;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Events\CreatedNewCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Services\Contracts\UserServiceContract;
use App\Notifications\RegisterCustomerNotification;
use App\Services\Contracts\CustomerServiceContract;

class ConfigureCustomer extends Listener implements ShouldQueue
{
    /**
     * @var \App\Services\CustomerService
     */
    protected $customerService = CustomerServiceContract::class;

    /**
     * @var \App\Services\UserService
     */
    protected $userService = UserServiceContract::class;

    public $queue = 'customers';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CreatedNewCustomer $event)
    {
        $customer = $event->customer;

        $this->createDatabase($customer);

        Tenant::set($customer);

        $this->migrateAndSeedDatabase();

        $this->createRootUser($customer);

        $this->notify($customer);
    }

    protected function createRootUser(Customer $customer)
    {
        $this->userService->create([
            'name' => $customer->getName(),
            'email' => $customer->getEmail(),
            'password' => $customer->getPassword(),
        ]);

        $customer->cryptPassword();

        $customer->save();
    }

    protected function createDatabase(Customer $customer)
    {
        $dbName = Str::of($customer->getCompany())->slug('_');

        $configs = array_merge(
            ['name' => $dbName],
            Config::get('tenant.database')
        );

        DB::connection('root')->statement("CREATE DATABASE $dbName;");

        $this->customerService->createDatabase($customer, $configs);
    }

    protected function migrateAndSeedDatabase()
    {
        Artisan::call('migrate:refresh', [
            '--seed' => true,
        ]);
    }

    protected function notify(Customer $customer)
    {
        Notification::send($customer, new RegisterCustomerNotification());
    }
}
