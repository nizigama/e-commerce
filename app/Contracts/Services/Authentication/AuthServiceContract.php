<?php

namespace App\Contracts\Services\Authentication;

use App\Classes\User;

interface AuthServiceContract
{
    /**
     * Registers a new user and returns the created User class with it's DB ID
     * 
     * @throws Exception
     */
    public function register(User $user): User;

    /**
     * Login the provided user then returns a string, a token in case of stateless authentication, or null in case of stateful authentication depending on the implementation of the login function
     *  If login fails an exception will be thrown
     * 
     * @throws Exception
     */
    public function login(User $user): ?string;

    /**
     * Logs out the provided user and returns true or false depending on if it succeeded or failed
     */
    public function logout(User $user): bool;
}
