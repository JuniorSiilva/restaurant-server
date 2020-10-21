<?php

namespace App\Services\Contracts;

interface DishOptionalServiceContract
{
    public function create(array $data, int $dish) : int;

    public function update(array $data, int $id) : int;

    public function remove(int $id) : int;
}
