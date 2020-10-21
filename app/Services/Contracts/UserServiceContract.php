<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceContract
{
    /**
     * Create an user.
     *
     * @param array $data
     * @return int
     */
    public function create(array $data);

    /**
     * Update profile from user.
     *
     * @param array $data
     * @return int
     */
    public function updateProfile(array $data, int $id);

    /**
     * Reset a password from user.
     *
     * @param User $user
     * @param string $password
     * @return mixed
     */
    public function resetPassword(User $user, string $password);
}
