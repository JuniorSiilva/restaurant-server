<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateCategory;
use App\Http\Requests\UpdateCategory;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\DefaultListRequest;
use App\Http\Resources\CategoryRankResource;
use App\Services\Contracts\CategoryServiceContract;
use App\Repositories\Contracts\CategoryRepositoryContract;

class CategoryController extends Controller
{
    /**
     * @var \App\Repositories\CategoryRepository
     */
    protected $categoryRepository = CategoryRepositoryContract::class;

    /**
     * @var \App\Services\CategoryService
     */
    protected $categoryService = CategoryServiceContract::class;

    public function getRankCategories()
    {
        $categories = $this->categoryRepository->getRankRequestedsCategories();

        return custom_response($categories)->setResource(CategoryRankResource::class)->do();
    }

    public function get(DefaultListRequest $defaultListRequest)
    {
        $categories = $this->categoryRepository->getAll(true, 15, $defaultListRequest->input('search', ''));

        return custom_response($categories)->setResource(CategoryResource::class)->do();
    }

    public function find(int $id)
    {
        $category = $this->categoryRepository->findById($id);

        return custom_response($category)->setResource(CategoryResource::class)->do();
    }

    public function create(CreateCategory $request)
    {
        $categoryId = $this->categoryService->create($request->validated());

        return custom_response(['id' => $categoryId], Response::HTTP_CREATED)->do();
    }

    public function update(UpdateCategory $request, int $id)
    {
        $categoryId = $this->categoryService->update($request->validated(), $id);

        return custom_response(['id' => $categoryId])->do();
    }
}
