<?php

namespace App\Services;

use App\Models\Table;
use App\Services\Contracts\TableServiceContract;
use App\Repositories\Contracts\TableRepositoryContract;

class TableService extends Service implements TableServiceContract
{
    /**
     * @var \App\Repositories\TableRepository
     */
    protected $tableRepository = TableRepositoryContract::class;

    public function create(array $data) : int
    {
        return $this->save(new Table, $data);
    }

    public function update(array $data, $id) : int
    {
        return $this->save($this->tableRepository->findById($id, false), $data);
    }

    protected function save(Table $table, array $data) : int
    {
        $table->fill($data);

        $table->save();

        return $table->getKey();
    }
}
