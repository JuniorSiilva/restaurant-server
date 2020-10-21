<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Jenssegers\Mongodb\Eloquent\Model;

class UserTenant extends Model
{
    protected $connection = 'mongodb';

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function getTenanties()
    {
        return $this->attributes['tenanties'];
    }

    public function addTenant(Customer $customer)
    {
        $this->push('tenanties', [
            Arr::only($customer->getAttributes(), ['id', 'company', 'slug_company', 'domain']),
        ], true);

        return $this;
    }

    public function removeTenant(Customer $customer)
    {
        $this->pull('tenanties', [
            'id' => $customer->getKey(),
        ]);

        return $this;
    }
}
