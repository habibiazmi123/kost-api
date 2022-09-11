<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegisterResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthApiController extends Controller
{
    //

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $input = $request->only([
            "email",
            "password"
        ]);

        if (!auth()->attempt($input)) {
            return sendError("Email / Password is invalid.", 500);
        }

        $token = auth()->user()->createToken('AppToken')->accessToken;

        return response(["token" => $token]);
    }

    public function register(Request $request)
    {
        $input = $request->only([
            "name",
            "email",
            "password",
            "user_type",
        ]);

        $input["user_type"] = $input["user_type"] ?? "Regular";
        $input["credit_amount"] = $input["user_type"] == "Regular" ? 20 : ($input["user_type"] == "Premium" ? 40 : 0);

        DB::beginTransaction();

        try {
            $user = $this->userService->saveUser($input);
            $user->assignRole($input["user_type"]);

            DB::commit();

            return sendResponse(new RegisterResource($user));
        } catch (Exception $e) {
            DB::rollBack();
            return sendError($e->getMessage(), 500);
        }

    }
}
