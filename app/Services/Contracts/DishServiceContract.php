<?php

namespace App\Services\Contracts;

interface DishServiceContract
{
    public function create(array $data) : int;

    public function update(array $data, $id) : int;
}
