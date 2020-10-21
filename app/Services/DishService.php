<?php

namespace App\Services;

use DB;
use App\Models\Dish;
use App\Services\Contracts\DishServiceContract;
use App\Repositories\Contracts\DishRepositoryContract;

class DishService extends Service implements DishServiceContract
{
    /**
     * @var \App\Repositories\DishRepository
     */
    protected $dishRepository = DishRepositoryContract::class;

    public function create(array $data) : int
    {
        return $this->save(new Dish, $data);
    }

    public function update(array $data, $id) : int
    {
        return $this->save($this->dishRepository->findById($id, false), $data);
    }

    protected function save(Dish $dish, array $data) : int
    {
        DB::transaction(function () use ($dish, $data) {
            $dish->fill($data);

            $dish->save();

            $dish->categories()->sync(array_column($data['categories'], 'id'));
        });

        return $dish->getKey();
    }
}
