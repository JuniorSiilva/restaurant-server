<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateCustomer;
use App\Services\Contracts\CustomerServiceContract;

class CustomerController extends Controller
{
    /**
     * @var \App\Services\CustomerService
     */
    protected $customerService = CustomerServiceContract::class;

    public function create(CreateCustomer $request)
    {
        $customer = $this->customerService->create($request->validated());

        return custom_response(['id' => $customer], Response::HTTP_CREATED)->do();
    }
}
