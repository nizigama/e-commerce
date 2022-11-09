<?php

namespace App\Queries;

use App\Classes\User;
use App\Contracts\Queries\UserQueryContract;
use App\Exceptions\NotFoundException;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserQuery implements UserQueryContract
{

    public function isEmailUnique(string $email): bool
    {
        return !ModelsUser::where("email", $email)->exists();
    }

    public function create(User $user): ?User
    {
        $model = ModelsUser::create([
            "name" => $user->names,
            "email" => $user->email,
            "password" => $user->password
        ]);

        $user->id = $model->id;

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        $model = ModelsUser::where("email", $email)->first(["id", "name", "email"]);

        if (is_null($model)) {
            return null;
        }

        return new User(names: $model->name, email: $model->email, id: $model->id);
    }

    /**
     * @throws Exception
     */
    public function getUserHashedPassword(User $user): string
    {
        return ModelsUser::find($user->id)?->password ?? throw new NotFoundException("User not found");
    }

    public function createAuthToken(User $user): ?string
    {
        return ModelsUser::find($user?->id)?->createToken("auth_token")?->plainTextToken;
    }

    public function deleteUserTokens(User $user): bool
    {
        return ModelsUser::find($user?->id)?->tokens()?->delete() >= 0;
    }
}
