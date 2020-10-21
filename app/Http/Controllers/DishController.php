<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\ListMenu;
use App\Http\Requests\CreateDish;
use App\Http\Requests\UpdateDish;
use App\Http\Resources\DishResource;
use App\Http\Requests\CreateAttachments;
use App\Http\Resources\DishMenuResource;
use App\Http\Requests\DefaultListRequest;
use App\Services\Contracts\DishServiceContract;
use App\Http\Requests\CreateOrUpdateDishOptional;
use App\Services\Contracts\AttachmentServiceContract;
use App\Repositories\Contracts\DishRepositoryContract;
use App\Services\Contracts\DishOptionalServiceContract;

class DishController extends Controller
{
    /**
     * @var \App\Repositories\DishRepository
     */
    protected $dishRepository = DishRepositoryContract::class;

    /**
     * @var \App\Services\DishService
     */
    protected $dishService = DishServiceContract::class;

    /**
     * @var \App\Services\DishOptionalService
     */
    protected $dishOptionalService = DishOptionalServiceContract::class;

    /**
     * @var \App\Services\AttachmentService
     */
    protected $attachmentService = AttachmentServiceContract::class;

    public function menu(ListMenu $request)
    {
        $search = $request->input('search', '');
        $categories = $request->input('categories', '');

        $dishes = $this->dishRepository->getMenu(15, $search, $categories);

        return custom_response($dishes)->setResource(DishMenuResource::class)->do();
    }

    public function newAttachments(CreateAttachments $request, int $id)
    {
        $dish = $this->dishRepository->findById($id, false);

        $this->attachmentService->createMany($dish, $request->attachments);

        return custom_response(['id' => $dish->getKey()])->do();
    }

    public function get(DefaultListRequest $defaultListRequest)
    {
        $dishes = $this->dishRepository->getAll(true, 15, $defaultListRequest->input('search', ''));

        return custom_response($dishes)->setResource(DishResource::class)->do();
    }

    public function find(int $id)
    {
        $dish = $this->dishRepository->findById($id);

        return custom_response($dish)->setResource(DishResource::class)->do();
    }

    public function create(CreateDish $request)
    {
        $dishId = $this->dishService->create($request->validated());

        return custom_response(['id' => $dishId], Response::HTTP_CREATED)->do();
    }

    public function update(UpdateDish $request, int $id)
    {
        $dishId = $this->dishService->update($request->validated(), $id);

        return custom_response(['id' => $dishId])->do();
    }

    public function createOptional(CreateOrUpdateDishOptional $request, int $dishId)
    {
        $dishOptionalId = $this->dishOptionalService->create($request->validated(), $dishId);

        return custom_response(['id' => $dishOptionalId], Response::HTTP_CREATED)->do();
    }

    public function updateOptional(CreateOrUpdateDishOptional $request, int $dishId, int $dishOptionalId)
    {
        $dishOptionalId = $this->dishOptionalService->update($request->validated(), $dishOptionalId);

        return custom_response(['id' => $dishOptionalId])->do();
    }

    public function removeOptional(int $dishId, int $dishOptionalId)
    {
        $dishOptionalId = $this->dishOptionalService->remove($dishOptionalId);

        return custom_response(['id' => $dishOptionalId])->do();
    }
}
