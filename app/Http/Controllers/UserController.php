<?php


namespace App\Http\Controllers;


use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getProfile()
    {
        $id = Auth::id();
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['error' => 'User not found'],500);
        }

        return $user;
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['error' => 'User not found'],500);
        }

        try {
            $user->fill($request->all());
            $user->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],500);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['error' => 'User not found'],500);
        }

        $credentials = [
            'email' => $user->email,
            'password' => $request->get('old_password'),
        ];

        if (!auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Old password is wrong'],500);
        }

        try {
            $user->password = Hash::make($request->get('new_password'));
            $user->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],500);
        }
    }
}