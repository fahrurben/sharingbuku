<?php


namespace App\Http\Controllers;


use App\Http\Requests\AddBookRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function getBooks()
    {
        $user = Auth::user();

        return $user->listings()->orderBy('title')->get();
    }

    public function addBook(AddBookRequest $request)
    {
        $user = Auth::user();
        $is_new = $request->get('is_new');

        try {
            if ($is_new) {
                $book = new Book();
                $book->fill($request->all());
                $book->slug = Str::slug($request->get('book'));
                $book->created_at = new \DateTime();
                $book->created_by = $user->id;
                $book->save();
            } else {
                $book = Book::find($request->get('book_id'));

                if (!$book) {
                    return response()->json(['error' => 'Book is not found'],401);
                }
            }

            $book->owners()->syncWithPivotValues($user->id, ['status' => 0], false);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],500);
        }
    }
}