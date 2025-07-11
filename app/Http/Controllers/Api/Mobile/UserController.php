<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'sometimes|string',
            'avatar' => 'nullable|string',
        ]);
        $user->update($data);

        return new UserResource($user);
    }
}
