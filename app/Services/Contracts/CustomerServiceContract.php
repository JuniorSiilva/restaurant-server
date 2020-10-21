<?php

namespace App\Services\Contracts;

use App\Models\Customer;
use App\Models\CustomerDatabase;

interface CustomerServiceContract
{
    public function create(array $data) : int;

    public function createDatabase(Customer $customer, array $data) : CustomerDatabase;
}
