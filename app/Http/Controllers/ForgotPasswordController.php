<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\ForgotPassword;
use App\Services\Contracts\ForgotPasswordContract;

class ForgotPasswordController extends Controller
{
    /**
     * @var \App\Services\ForgotPasswordService
     */
    protected $forgotPasswordService = ForgotPasswordContract::class;

    public function lost(ForgotPassword $request)
    {
        $this->forgotPasswordService->sendResetLink(
            $request->only('email')
        );

        return custom_response(null, Response::HTTP_NO_CONTENT)->do();
    }

    public function reset(ResetPassword $request)
    {
        $this->forgotPasswordService->resetPassword(
            $request->validated()
        );

        return custom_response(null, Response::HTTP_NO_CONTENT)->do();
    }
}
