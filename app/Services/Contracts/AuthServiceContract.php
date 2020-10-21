<?php

namespace App\Services\Contracts;

use App\Models\User;

interface AuthServiceContract
{
    /**
     * Authenticate an user.
     *
     * @param array $credentials
     * @return string
     * @throws App\Exceptions\UnauthorizedHttpException
     */
    public function authenticate(array $credentials);

    /**
     * Make logof on authenticated user.
     *
     * @return void
     */
    public function logout();

    public function getUserTokens();

    public function revokeToken(int $id);

    /**
     * Revoke all tokens.
     */
    public function revokeAllTokens(User $user);

    /**
     * Return id of the authenticated user.
     *
     * @return int
     */
    public function authenticatedUserId();

    /**
     * Return authenticated user.
     *
     * @return User
     */
    public function authenticatedUser();

    /**
     * Catch the authenticated user.
     *
     * @return User
     */
    public function profile();

    /**
     * Update profile from the authenticated user.
     *
     * @return User
     */
    public function updateAuthProfile(array $data);
}
