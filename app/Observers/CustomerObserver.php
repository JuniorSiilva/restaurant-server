<?php

namespace App\Observers;

use App\Models\Customer;
use App\Events\CreatedNewCustomer;

class CustomerObserver
{
    public function created(Customer $customer)
    {
        event(new CreatedNewCustomer($customer));
    }
}
