<?php

namespace App\Services;

use Cache;
use App\Models\User;
use App\Models\Customer;
use App\Models\UserTenant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Exceptions\CustomerNotFoundException;
use App\Services\Contracts\TenantServiceContract;
use App\Exceptions\CustomerDatabaseNotReadyException;
use App\Repositories\Contracts\TenantRepositoryContract;

class TenantService extends Service implements TenantServiceContract
{
    /**
     * @var \App\Models\Customer
     */
    protected $tenant;

    /**
     * @var \App\Repositories\TenantRepository
     */
    protected $tenantRepository = TenantRepositoryContract::class;

    public function get() :? Customer
    {
        return $this->tenant;
    }

    public function set($tenant)
    {
        if (! ($tenant instanceof Customer)) {
            $tenant = $this->tenantRepository->findByCompanyName($tenant);

            if (! $tenant) {
                throw new CustomerNotFoundException();
            }
        }

        $this->tenant = $tenant;

        $this->configure();
    }

    public function registerUser(User $user) : UserTenant
    {
        $userTenant = UserTenant::where('email', $user->getEmailForPasswordReset())->firstOrNew();

        if (! $userTenant->exists) {
            $userTenant->setEmail($user->getEmailForPasswordReset());
        }

        $userTenant->addTenant($this->tenant);

        $userTenant->save();

        return $userTenant;
    }

    public function removeUser(User $user) : UserTenant
    {
        $userTenant = UserTenant::where('email', $user->getEmailForPasswordReset())->first();

        $userTenant->removeTenant($this->tenant);

        $userTenant->save();

        if (count($userTenant->getTenanties()) == 1) {
            $userTenant->delete();
        }

        return $userTenant;
    }

    protected function configure()
    {
        $this->setCachePrefix();

        $this->setDatabase();
    }

    protected function setCachePrefix()
    {
        Cache::setPrefix(Str::slug($this->tenant->getCompany(), '_').'_cache');
    }

    protected function setDatabase()
    {
        if (! ($database = $this->tenant->database)) {
            throw new CustomerDatabaseNotReadyException();
        }

        $config = [
            'driver' => $database->getDriver(),
            'host' => $database->getHost(),
            'port' => $database->getPort(),
            'database' => $database->getName(),
            'username' => $database->getUser(),
            'password' => $database->getPassword(),
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ];

        Config::set('database.connections.pgsql', $config);

        DB::purge('pgsql');

        DB::setDefaultConnection('pgsql');
    }
}
