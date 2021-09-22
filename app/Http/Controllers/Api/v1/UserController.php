<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
