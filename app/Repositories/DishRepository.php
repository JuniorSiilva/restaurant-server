<?php

namespace App\Repositories;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\DishRepositoryContract;

class DishRepository extends Repository implements DishRepositoryContract
{
    protected $model = Dish::class;

    public function getMenu(int $take = 15, ?string $search = '', array $categories = [])
    {
        $query = $this->getQuery();

        $query->where('name', 'ILIKE', "%$search%");

        $query->with('categories');

        $query->whereHas('categories', function (Builder $builder) use ($categories) {
            $builder->whereIn('id', $categories);
        });

        $query->mostRequesteds();

        $query->orderBy('name', 'ASC');

        return $query->paginate($take);
    }

    public function getAll(bool $paginate = false, int $take = 15, ?string $search = '')
    {
        $query = $this->getQuery();

        $query->where('name', 'ILIKE', "%$search%");

        $query->orderBy('name', 'ASC');

        $query->with('categories');

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }

    public function findById($id, bool $includeRelations = true, array $relations = ['categories', 'optionals']) : ? Model
    {
        return parent::findById($id, $includeRelations, $relations);
    }
}
