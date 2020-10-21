<?php

namespace App\Observers;

use App\Models\User;
use App\Facades\Tenant;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\VerificationUserServiceContract;

class UserObserver extends Observer
{
    /**
     * @var \App\Services\VerificationUserService
     */
    protected $verificationUserService = VerificationUserServiceContract::class;

    /**
     * @var \App\Services\AuthService
     */
    protected $authService = AuthServiceContract::class;

    public function updated(User $user)
    {
        if ($user->isDirty('password')) {
            event(new PasswordReset($user));

            $this->authService->revokeAllTokens($user);
        }
    }

    public function created(User $user)
    {
        if ($user instanceof MustVerifyEmail) {
            $this->verificationUserService->sendConfirmNotification($user);
        }

        Tenant::registerUser($user);
    }

    public function deleted(User $user)
    {
        Tenant::removeUser($user);
    }
}
