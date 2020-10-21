<?php

namespace App\Services\Contracts;

use App\Models\User;
use App\Models\Customer;
use App\Models\UserTenant;

interface TenantServiceContract
{
    public function get() :? Customer;

    public function set(string $name);

    public function registerUser(User $user) : UserTenant;

    public function removeUser(User $user) : UserTenant;
}
