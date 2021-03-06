<?php


namespace App\Http\Controllers;


use App\Constant;
use App\Http\Requests\AddBookRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\TransactionResource;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
            return response()->json(['error' => 'User not found'], 500);
        }

        return $user;
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['error' => 'User not found'], 500);
        }

        try {
            $user->fill($request->all());
            $user->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['error' => 'User not found'], 500);
        }

        $credentials = [
            'email' => $user->email,
            'password' => $request->get('old_password'),
        ];

        if (!auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Old password is wrong'], 500);
        }

        try {
            $user->password = Hash::make($request->get('new_password'));
            $user->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getBooks()
    {
        $user = Auth::user();
        $books = $user->listings()->orderBy('title')->paginate(20);
        return BookResource::collection($books);
    }

    public function addBook(Request $request)
    {
        $user = Auth::user();
        $is_new = $request->get('is_new');
        $image_filename = null;

        if ($request->files->has('image')) {
            $image = $request->file('image');
            $image_path = $image->store('books');
            $image_filename = str_replace('books/', '', $image_path);
        }

        try {
            if ($is_new) {
                $book = new Book();
                $book->fill($request->all());
                $book->image = $image_filename ?: null;
                $book->slug = Str::slug($request->get('book'));
                $book->created_at = new \DateTime();
                $book->created_by = $user->id;
                $book->save();
            } else {
                $book = Book::find($request->get('book_id'));

                if (!$book) {
                    return response()->json(['error' => 'Book is not found'], 401);
                }
            }

            $book->owners()->syncWithPivotValues($user->id, ['status' => 0], false);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function myRequest()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $requestList = Transaction::where('requestor_id', $user_id)
            ->whereNotIn('resolution', [Transaction::RESOLUTION_FINISHED, Transaction::RESOLUTION_REJECTED, Transaction::RESOLUTION_CANCELLED])
            ->orderBy('created_at', Constant::DESC)
            ->paginate(Constant::PAGE_SIZE);

        return TransactionResource::collection($requestList);
    }

    public function incomingRequest()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $requestList = Transaction::whereHas('listing', function (Builder $query) use ($user_id) {
            $query->where('user_id', $user_id);
        })
            ->whereNotIn('resolution', [Transaction::RESOLUTION_FINISHED, Transaction::RESOLUTION_REJECTED, Transaction::RESOLUTION_CANCELLED])
            ->orderBy('created_at', Constant::DESC)
            ->paginate(Constant::PAGE_SIZE);

        return TransactionResource::collection($requestList);
    }
}