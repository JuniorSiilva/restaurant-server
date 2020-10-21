<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryContract extends RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15, ?string $search = '');

    public function getRankRequestedsCategories(int $take = 10);
}
