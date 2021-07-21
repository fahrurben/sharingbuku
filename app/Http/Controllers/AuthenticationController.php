<?php


namespace App\Http\Controllers;


use App\Http\Requests\LoginPostRequest;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function login(LoginPostRequest $request)
    {
        $credentials = $request->all();
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Wrong username or password!'], 401);
        }

        $user = User::where(['email' => $credentials['email']])->firstOrFail();

        return response()->json([
            'access_token' => $token,
            'full_name' => $user->first_name. ' ' . $user->last_name,
            'token_type' => 'bearer',
            'expires_in' => 86400, // 86400 s ( 1 Day )
        ]);
    }
}