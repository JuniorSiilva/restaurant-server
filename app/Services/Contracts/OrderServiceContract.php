<?php

namespace App\Services\Contracts;

interface OrderServiceContract
{
    public function create(array $data) : int;

    public function close(int $id) : int;

    public function addDish(array $data, int $id) : int;
}
