<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserFormRequest;
use App\Http\Requests\User\UpdateUserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(StoreUserFormRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return response()->json([
            'message' => 'User created'
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserFormRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return response()->json([
            'message' => 'User edited'
        ], 200);
    }
}
