<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateTable;
use App\Http\Requests\UpdateTable;
use App\Http\Resources\TableResource;
use App\Http\Requests\DefaultListRequest;
use App\Services\Contracts\TableServiceContract;
use App\Repositories\Contracts\TableRepositoryContract;

class TableController extends Controller
{
    /**
     * @var \App\Repositories\TableRepository
     */
    protected $tableRepository = TableRepositoryContract::class;

    /**
     * @var \App\Services\TableService
     */
    protected $tableService = TableServiceContract::class;

    public function get(DefaultListRequest $defaultListRequest)
    {
        $categories = $this->tableRepository->getAll(true, 15, $defaultListRequest->input('search', ''));

        return custom_response($categories)->setResource(TableResource::class)->do();
    }

    public function find(int $id)
    {
        $table = $this->tableRepository->findById($id);

        return custom_response($table)->setResource(TableResource::class)->do();
    }

    public function create(CreateTable $request)
    {
        $tableId = $this->tableService->create($request->validated());

        return custom_response(['id' => $tableId], Response::HTTP_CREATED)->do();
    }

    public function update(UpdateTable $request, int $id)
    {
        $tableId = $this->tableService->update($request->validated(), $id);

        return custom_response(['id' => $tableId])->do();
    }
}
