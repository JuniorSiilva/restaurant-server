<?php

namespace App\Repositories\Contracts;

use App\Models\UserTenant;

interface UserTenantRepositoryContract
{
    public function findByEmail(string $email) :? UserTenant;
}
