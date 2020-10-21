<?php

namespace App\Services;

use App\Models\DishOptional;
use App\Services\Contracts\AttachmentServiceContract;
use App\Services\Contracts\DishOptionalServiceContract;
use App\Repositories\Contracts\DishOptionalRepositoryContract;

class DishOptionalService extends Service implements DishOptionalServiceContract
{
    /**
     * @var \App\Repositories\DishOptionalRepository
     */
    protected $dishOptionalRepository = DishOptionalRepositoryContract::class;

    /**
     * @var \App\Services\AttachmentService
     */
    protected $attachmentService = AttachmentServiceContract::class;

    public function create(array $data, int $dish) : int
    {
        $optional = new DishOptional($data);

        $optional->dish()->associate($dish);

        $optional->save();

        $this->attachmentService->createMany($optional, $data['attachments'] ?? []);

        return $optional->getKey();
    }

    public function update(array $data, int $id) : int
    {
        $optional = $this->dishOptionalRepository->findById($id, false);

        $optional->fill($data);

        $optional->save();

        $this->attachmentService->createMany($optional, $data['attachments'] ?? []);

        return $optional->getKey();
    }

    public function remove(int $id) : int
    {
        $optional = $this->dishOptionalRepository->findById($id, false);

        $optional->delete();

        return $optional->getKey();
    }
}
