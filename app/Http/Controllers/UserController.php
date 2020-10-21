<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateProfile;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserTenantResource;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\VerificationUserServiceContract;
use App\Repositories\Contracts\UserTenantRepositoryContract;

class UserController extends Controller
{
    /**
     * @var \App\Services\AuthService
     */
    protected $authService = AuthServiceContract::class;

    /**
     * @var \App\Services\UserService
     */
    protected $userService = UserServiceContract::class;

    /**
     * @var \App\Services\VerificationUserService
     */
    protected $verificationService = VerificationUserServiceContract::class;

    /**
     * @var \App\Repositories\UserTenantRepository
     */
    protected $userTenantRepository = UserTenantRepositoryContract::class;

    public function create(CreateUser $request)
    {
        $user = $this->userService->create($request->validated());

        return custom_response(['id' => $user], Response::HTTP_CREATED)->do();
    }

    public function tenanties(string $email)
    {
        $user = $this->userTenantRepository->findByEmail($email);

        if (! $user) {
            return custom_response(null, Response::HTTP_NO_CONTENT)->do();
        }

        return custom_response($user)->setResource(UserTenantResource::class)->do();
    }

    public function verify($id)
    {
        $this->verificationService->verify($id);

        return custom_response(null, Response::HTTP_NO_CONTENT)->do();
    }

    public function profileUpdate(UpdateProfile $request)
    {
        $this->authService->updateAuthProfile($request->validated());

        return custom_response(null, Response::HTTP_NO_CONTENT)->do();
    }

    public function profile()
    {
        $user = $this->authService->profile();

        return custom_response($user)->setResource(UserResource::class)->do();
    }
}
