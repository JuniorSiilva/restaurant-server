<?php

namespace App\Repositories\Contracts;

use App\Models\Customer;

interface TenantRepositoryContract
{
    public function findByCompanyName(string $customer) :? Customer;
}
