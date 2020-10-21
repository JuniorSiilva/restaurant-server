<?php

namespace App\Repositories\Contracts;

interface DishRepositoryContract extends RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15, ?string $search = '');

    public function getMenu(int $take = 15, ?string $search = '', array $categories = []);
}
