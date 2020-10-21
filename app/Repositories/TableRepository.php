<?php

namespace App\Repositories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\TableRepositoryContract;

class TableRepository extends Repository implements TableRepositoryContract
{
    protected $model = Table::class;

    public function getAll(bool $paginate = false, int $take = 15, ?string $search = '')
    {
        $query = $this->getQuery();

        $query->where('identification', 'ILIKE', "%$search%");

        $query->orderBy('identification', 'ASC');

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }

    public function tableIsOccupied(int $id) : bool
    {
        $query = $this->getQuery();

        $query->whereHas('orders', function (Builder $builder) {
            $builder->isOpen();
        });

        $query->where('id', $id);

        return $query->exists();
    }
}
