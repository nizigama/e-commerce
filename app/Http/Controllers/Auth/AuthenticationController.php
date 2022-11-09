<?php

namespace App\Http\Controllers\Auth;

use App\Classes\User;
use App\Contracts\Services\Authentication\AuthServiceContract;
use App\Exceptions\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function __construct(protected AuthServiceContract $authService)
    {
        $this->middleware("auth:sanctum")->only("logout");
    }

    public function register(RegisterRequest $request)
    {
        try {

            $this->authService->register($request->user);

            $token = $this->authService->login($request->user);

            if (is_null($token)) {
                throw new UnknownException("Failed logging in the registered user, try to login");
            }

            return response()->json(["message" => "Registration successful", "token" => $token]);
        } catch (\Throwable $th) {

            Log::error("Failed to register a new user", [
                "request" => $request,
                "class" => __CLASS__,
                "function" => __FUNCTION__,
                "exception" => $th
            ]);

            $error = getHttpMessageAndStatusCodeFromException($th);

            return \response()->json(['message' => $error[0]], $error[1]);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authService->login($request->user);

            if (is_null($token)) {

                Log::error("Failed to generate a login token", [
                    "request" => $request,
                    "class" => __CLASS__,
                    "function" => __FUNCTION__,
                ]);

                return response()->json(["message" => "Login failed contact support"], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json(["token" => $token]);
        } catch (\Throwable $th) {

            $error = getHttpMessageAndStatusCodeFromException($th);

            return \response()->json(['message' => $error[0]], $error[1]);
        }
    }

    public function logout()
    {

        $loggedInUser = new User(id: Auth::id(), email: Auth::user()->email);

        $loggedOut = $this->authService->logout($loggedInUser);

        if (!$loggedOut) {

            Log::error("Failed to logout", [
                "request" => request(),
                "class" => __CLASS__,
                "function" => __FUNCTION__,
            ]);

            return response()->json(["message" => "Logout failed"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(["message" => "Successfully logged out"]);
    }
}
