<?php

namespace App\Console\Commands;

use App\Facades\Tenant;
use App\Models\Customer;
use App\Exceptions\CustomerDatabaseNotReadyException;
use App\Repositories\Contracts\TenantRepositoryContract;

class TenantsMigrateCommand extends Command
{
    /**
     * @var \App\Repositories\TenantRepository
     */
    protected $tenantRepository = TenantRepositoryContract::class;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrate {tenant?} {--refresh} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate tenants';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('tenant')) {
            $this->migrate(
                $this->tenantRepository->findByCompanyName($this->argument('tenant'))
            );
        } else {
            $tenants = $this->tenantRepository->getAll();

            if ($tenants->isEmpty()) {
                return $this->info('No tenants found');
            }

            $tenants->each(function (Customer $customer) {
                $this->migrate($customer);
            });
        }
    }

    public function migrate(Customer $customer)
    {
        try {
            Tenant::set($customer);

            $this->line('');
            $this->line('-----------------------------------------');
            $this->info("Migrating Tenant ({$customer->getCompany()})");
            $this->line('-----------------------------------------');

            $options = ['--force' => true];

            if ($this->option('seed')) {
                $options['--seed'] = true;
            }

            $this->call(
                $this->option('refresh') ? 'migrate:refresh' : 'migrate',
                $options
            );
        } catch (CustomerDatabaseNotReadyException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
