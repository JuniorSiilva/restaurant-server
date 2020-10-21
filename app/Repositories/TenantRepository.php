<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\TenantRepositoryContract;

class TenantRepository extends Repository implements TenantRepositoryContract
{
    protected $model = Customer::class;

    public function findByCompanyName(string $customer) :? Customer
    {
        $query = $this->getQuery();

        $query->where('slug_company', '=', $customer)->orWhere('domain', '=', $customer);

        $query->with('database');

        return $query->first();
    }
}
