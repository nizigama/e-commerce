<?php

namespace App\Services\Authentication;

use App\Classes\User;
use App\Contracts\Queries\UserQueryContract;
use App\Contracts\Services\Authentication\AuthServiceContract;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use Exception;
use Illuminate\Support\Facades\Hash;

class StatelessAuthService implements AuthServiceContract
{

    public function __construct(protected UserQueryContract $userQuery)
    {
    }

    /**
     * @throws Exception
     */
    public function register(User $user): User
    {
        throw_if(!$this->userQuery->isEmailUnique($user->email), new ForbiddenException("Email already used"));

        $passwordValue = $user->password;

        $user->password = Hash::make($user->password);

        $user = $this->userQuery->create($user);

        $user->password = $passwordValue;

        return $user;
    }

    public function login(User $user): ?string
    {
        $dbUser = $this->userQuery->findByEmail($user->email);

        if (is_null($dbUser)) {
            throw new NotFoundException("User not found");
        }

        $hashedPassword = $this->userQuery->getUserHashedPassword($dbUser);

        if (!Hash::check($user->password, $hashedPassword)) {
            throw new ForbiddenException("Wrong credentials");
        }

        $this->userQuery->deleteUserTokens($dbUser);

        return $this->userQuery->createAuthToken($dbUser);
    }

    public function logout(User $user): bool
    {
        return $this->userQuery->deleteUserTokens($user);
    }
}
