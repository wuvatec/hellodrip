<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticationRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login', 'register');
    }

    /**
     * Register a new user
     *
     * @param AuthenticationRequest $request
     * @return JsonResponse
     */
    public function register(AuthenticationRequest $request): JsonResponse
    {
        $user = User::create($request->only('name', 'email', 'password', 'active'));
        return \response()->json([
            'success' => true,
            'message' => 'User successfully created',
            'data' => $user,
        ], Response::HTTP_CREATED);
    }

    /**
     * Validate and generate access token
     *
     * @param AuthenticationRequest $request
     * @return JsonResponse
     */
    public function login(AuthenticationRequest $request): JsonResponse
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
            'is_active' => 1,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized!'], Response::HTTP_UNAUTHORIZED);
        }

        $token = auth()->user()->createToken('api-authentication', ['authenticate'])->plainTextToken;

        return \response()->json([
            'success' => true,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    /**
     * Get the authenticated user
     *
     * @param Request $request
     * @return mixed
     */
    public function user(Request $request)
    {
        return \response()->json([
            'success' => true,
            'message' => 'Authorized user',
            'data' => $request->user()
        ], Response::HTTP_OK);
    }

    /**
     * Revoke authorized access token
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return \response()->json([
            'success' => true,
            'data' => 'No content',
        ], Response::HTTP_NO_CONTENT);
    }
}
