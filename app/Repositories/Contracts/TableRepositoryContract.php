<?php

namespace App\Repositories\Contracts;

interface TableRepositoryContract extends RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15, ?string $search = '');

    public function tableIsOccupied(int $id) : bool;
}
