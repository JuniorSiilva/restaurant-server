<?php

namespace App\Services\Contracts;

interface CategoryServiceContract
{
    public function create(array $data) : int;

    public function update(array $data, $id) : int;
}
