<?php

namespace App\Services\Contracts;

use App\Models\User;
use App\Exceptions\AppException;

interface VerificationUserServiceContract
{
    /**
     * Verify an user.
     *
     * @param string|int $id
     * @return void
     * @throws AppException
     */
    public function verify($id);

    /**
     * Send the confirmation notification to user.
     *
     * @param User $user
     * @return void
     */
    public function sendConfirmNotification(User $user);
}
