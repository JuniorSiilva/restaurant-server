<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\Authenticate;
use App\Http\Resources\UserTokenResource;
use App\Services\Contracts\AuthServiceContract;

class AuthController extends Controller
{
    /**
     * @var \App\Services\AuthService
     */
    protected $authService = AuthServiceContract::class;

    public function login(Authenticate $request)
    {
        $token = $this->authService->authenticate($request->validated());

        return custom_response(['token' => $token])->do();
    }

    public function tokens()
    {
        $tokens = $this->authService->getUserTokens();

        return custom_response($tokens)->setResource(UserTokenResource::class)->do();
    }

    public function revoke(int $id)
    {
        $this->authService->revokeToken($id);

        return custom_response(null, Response::HTTP_NO_CONTENT)->do();
    }

    public function logout()
    {
        $this->authService->logout();

        return custom_response(null, Response::HTTP_NO_CONTENT)->do();
    }
}
