<?php

namespace App\Http\Controllers;

use App\Modules\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private $_service;

    public function __construct(UserService $userService)
    {
        $this->_service = $userService;
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $user = $this->_service->registerUser($data);

        if (!$user) {
            return response()->json(['message' => 'Registration failed'], Response::HTTP_BAD_REQUEST);
        }
        return response()->noContent();
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $token = $this->_service->login($data);

        if (!$token) {
            return response()->json(['message' => 'Credentials are not valid'], Response::HTTP_UNAUTHORIZED);
        }
        return response([
            "status" => "success",
            "authorisation" => [
                'token' => $token,
                'type' => "bearer"
            ]
        ], Response::HTTP_OK);
    }
}
