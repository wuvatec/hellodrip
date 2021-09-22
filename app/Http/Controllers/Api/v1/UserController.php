<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Only administrator can access all users
        if (!$request->user()->isAdmin()){
            return response()->json([
                'success' => 'error',
                'message' => 'Unauthorized access',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return User::paginate(15);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($data);

        return  response()->json([
            'success' => true,
            'message' => "User successfully created",
            'data' => $user,
        ], Response::HTTP_CREATED);
    }

    public function show(Request $request, User $user): JsonResponse
    {
        if (!$request->user()->isAdmin()  && $request->user()->id !== $user->id)  {
            return \response()->json([
                'success'  => false,
                'message'  => 'Unauthorized access',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return \response()->json([
            'success' => true,
            'data' => $user,
        ], Response::HTTP_OK);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required',
            // 'email' => 'bail|required|email|unique:users',
            'email' =>  ['bail', 'required', 'email', Rule::unique('users')->ignore($user->id,  'id')],
        ]);

        if ($request->user()->id !== $user->id) {

            return \response()->json([
                'success'  => false,
                'message'  => 'Unauthorized access',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user->update($data);

        return \response()->json([
            'success' => true,
            'message' => 'User successfully updated',
            'data' => $user,
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        // Administrator can only delete other usersss
        if (!$request->user()->isAdmin()) {
            return \response()->json([
                'success'  => false,
                'message'  => 'Unauthorized!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Administrator can not be deleted
        if ($user->isAdmin()) {
            return \response()->json([
                'success'  => false,
                'message'  => 'You are not authorized to delete this user!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Delete a user that is not an admin
        $user->delete();

        return \response()->json([
            'success' => true,
        ], Response::HTTP_NO_CONTENT);
    }
}
