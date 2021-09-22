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

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(Request $request, User $user)
    {
        if (!$request->user()->isAdmin()) {
            return \response()->json([
                'success'  => false,
                'message'  => 'Unauthorized!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($user->isAdmin()) {
            return \response()->json([
                'success'  => false,
                'message'  => 'You are not authorized to delete this user!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user->delete();

        return \response()->json([
            'success' => true,
            'message'  => 'User successfully deleted!'
        ], Response::HTTP_NO_CONTENT);
    }
}
