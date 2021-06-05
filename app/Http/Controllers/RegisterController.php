<?php


namespace App\Http\Controllers;


use App\Http\Requests\RegisterSubmitRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function submit(RegisterSubmitRequest $request)
    {
        try {
            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($request->get('password'));
            $user->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],500);
        }
    }
}