<?php

namespace App\Repositories;

use App\Models\UserTenant;
use App\Repositories\Contracts\UserTenantRepositoryContract;

class UserTenantRepository extends Repository implements UserTenantRepositoryContract
{
    protected $model = UserTenant::class;

    public function findByEmail(string $email) :? UserTenant
    {
        $query = $this->getQuery();

        $query->where('email', 'like', $email);

        return $query->first();
    }
}
