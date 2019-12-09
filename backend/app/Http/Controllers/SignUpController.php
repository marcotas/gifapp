<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SignUpController extends Controller
{
    public function __invoke(Request $request)
    {
        $values = $this->validate($request, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:255|confirmed',
        ]);

        $values['password'] = bcrypt($values['password']);

        /** @var User $user */
        $user  = User::create($values);
        $token = $user->createToken("{$user->id} token");
        $token = [
            'access_token' => $token->accessToken,
            'expires_in'   => now()->addDay(1)->timestamp,
        ];

        return response()->json(compact('user', 'token'), Response::HTTP_CREATED);
    }
}
