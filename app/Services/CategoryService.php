<?php

namespace App\Services;

use App\Models\Category;
use App\Services\Contracts\CategoryServiceContract;
use App\Repositories\Contracts\CategoryRepositoryContract;

class CategoryService extends Service implements CategoryServiceContract
{
    /**
     * @var \App\Repositories\CategoryRepository
     */
    protected $categoryRepository = CategoryRepositoryContract::class;

    public function create(array $data) : int
    {
        return $this->save(new Category, $data);
    }

    public function update(array $data, $id) : int
    {
        return $this->save($this->categoryRepository->findById($id, false), $data);
    }

    protected function save(Category $category, array $data) : int
    {
        $category->fill($data);

        $category->save();

        return $category->getKey();
    }
}
