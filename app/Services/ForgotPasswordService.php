<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Password;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\ForgotPasswordContract;

class ForgotPasswordService extends Service implements ForgotPasswordContract
{
    /**
     * @var \App\Services\UserService
     */
    protected $userService = UserServiceContract::class;

    public function sendResetLink(array $data)
    {
        return $this->broker()->sendResetLink($data);
    }

    public function resetPassword(array $data)
    {
        $response = $this->broker()->reset(
            $data, function ($user, $password) {
                $this->userService->resetPassword($user, $password);
            }
        );

        if ($response !== Password::PASSWORD_RESET) {
            throw new BusinessException(__($response));
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
