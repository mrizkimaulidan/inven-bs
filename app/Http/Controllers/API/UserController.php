<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userData = $user->toArray();
        $userData['role'] = $user->roles()->first();

        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $userData
        ]);
    }
}
