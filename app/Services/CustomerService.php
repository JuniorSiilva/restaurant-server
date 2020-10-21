<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerDatabase;
use App\Services\Contracts\CustomerServiceContract;

class CustomerService extends Service implements CustomerServiceContract
{
    public function create(array $data) : int
    {
        $customer = new Customer($data);
        $customer->save();

        return $customer->getKey();
    }

    public function createDatabase(Customer $customer, array $data) : CustomerDatabase
    {
        $database = new CustomerDatabase($data);
        $database->customer()->associate($customer);
        $database->save();

        return $database;
    }
}
