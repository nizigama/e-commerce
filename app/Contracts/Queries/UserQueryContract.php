<?php

namespace App\Contracts\Queries;

use App\Classes\User;

interface UserQueryContract
{
    public function isEmailUnique(string $email): bool;

    public function create(User $user): ?User;

    public function findByEmail(string $email): ?User;

    /**
     * Returns the hashed password of the provided user, if user not found an exception will be thrown
     * 
     * @throws Exception
     */
    public function getUserHashedPassword(User $user): string;

    public function createAuthToken(User $user): ?string;

    public function deleteUserTokens(User $user): bool;
}
