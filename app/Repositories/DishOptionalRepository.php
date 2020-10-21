<?php

namespace App\Repositories;

use App\Models\DishOptional;
use App\Repositories\Contracts\DishOptionalRepositoryContract;

class DishOptionalRepository extends Repository implements DishOptionalRepositoryContract
{
    protected $model = DishOptional::class;
}
