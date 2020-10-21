<?php

namespace App\Services\Contracts;

interface ForgotPasswordContract
{
    /**
     * Rules for requesting password recovery.
     */
    public const RESET_LINK = [
        'email' => 'required|email|exists:users,email',
    ];

    /**
     * Send e-mail with the link to password recovery.
     *
     * @param array $data
     * @return mixed
     */
    public function sendResetLink(array $data);

    /**
     * Reset the password.
     *
     * @param array $data
     * @return mixed
     */
    public function resetPassword(array $data);
}
