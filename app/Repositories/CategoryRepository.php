<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryContract;

class CategoryRepository extends Repository implements CategoryRepositoryContract
{
    protected $model = Category::class;

    public function getRankRequestedsCategories(int $take = 10)
    {
        $query = $this->getQuery();

        $query->mostRequesteds();

        $query->orderBy('name', 'ASC');

        return $query->paginate($take);
    }

    public function getAll(bool $paginate = false, int $take = 15, ?string $search = '')
    {
        $query = $this->getQuery();

        $query->where('name', 'ILIKE', "%$search%");

        $query->orderBy('name', 'ASC');

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }
}
